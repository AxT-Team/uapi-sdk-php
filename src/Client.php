<?php
namespace Uapi;

use GuzzleHttp\Client as Guzzle;

class ResponseMeta {
    public ?string $requestId = null;
    public ?int $retryAfterSeconds = null;
    public ?string $debitStatus = null;
    public ?int $creditsRequested = null;
    public ?int $creditsCharged = null;
    public ?string $creditsPricing = null;
    public ?int $activeQuotaBuckets = null;
    public ?bool $stopOnEmpty = null;
    public ?string $rateLimitPolicyRaw = null;
    public ?string $rateLimitRaw = null;
    public array $rateLimitPolicies = [];
    public array $rateLimits = [];
    public ?int $balanceLimitCents = null;
    public ?int $balanceRemainingCents = null;
    public ?int $quotaLimitCredits = null;
    public ?int $quotaRemainingCredits = null;
    public ?int $visitorQuotaLimitCredits = null;
    public ?int $visitorQuotaRemainingCredits = null;
    public array $rawHeaders = [];
}

class UapiError extends \Exception {
    public string $apiCode;
    public int $status;
    public $details;
    public $payload;
    public ?ResponseMeta $meta;
    function __construct(string $code, int $status, string $message, $details = null, $payload = null, ?ResponseMeta $meta = null) {
        parent::__construct("[$status] $code: $message");
        $this->apiCode = $code;
        $this->status = $status;
        $this->details = $details;
        $this->payload = $payload;
        $this->meta = $meta;
    }
}
class ApiErrorError extends UapiError {}
class AvatarNotFoundError extends UapiError {}
class ConversionFailedError extends UapiError {}
class FileOpenErrorError extends UapiError {}
class FileRequiredError extends UapiError {}
class InsufficientCreditsError extends UapiError {}
class InternalServerErrorError extends UapiError {}
class InvalidParameterError extends UapiError {}
class InvalidParamsError extends UapiError {}
class NotFoundError extends UapiError {}
class NoMatchError extends UapiError {}
class NoTrackingDataError extends UapiError {}
class PhoneInfoFailedError extends UapiError {}
class RecognitionFailedError extends UapiError {}
class RequestEntityTooLargeError extends UapiError {}
class ServiceBusyError extends UapiError {}
class TimezoneNotFoundError extends UapiError {}
class UnauthorizedError extends UapiError {}
class UnsupportedCarrierError extends UapiError {}
class UnsupportedFormatError extends UapiError {}
class VisitorMonthlyQuotaExhaustedError extends UapiError {}


class Client {
    private Guzzle $http;
    private bool $disableCacheDefault = false;
    public ?ResponseMeta $lastResponseMeta = null;
    function __construct(string $baseUrl, ?string $token = null, bool|array $verifyTls = true, ?array $options = null) {
        if (is_array($verifyTls)) {
            $options = $verifyTls;
            $verifyTls = true;
        }
        $options = $options ?? [];
        $this->disableCacheDefault = $this->coerceBool($options['disableCache'] ?? ($options['disable_cache'] ?? false)) ?? false;
        $envSkip = getenv('UAPI_SKIP_TLS_VERIFY');
        if ($envSkip !== false) {
            $verifyTls = false;
        }
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $baseUrl = self::normalizeBaseUrl($baseUrl) . '/';
        $options = ['base_uri' => $baseUrl, 'headers' => $headers, 'http_errors' => false];
        if (!$verifyTls) {
            $options['verify'] = false;
        }
        $this->http = new Guzzle($options);
    }
    private static function normalizeBaseUrl(string $baseUrl): string {
        $normalized = rtrim($baseUrl, '/');
        if (str_ends_with($normalized, '/api/v1')) {
            $normalized = substr($normalized, 0, -strlen('/api/v1'));
        }
        return $normalized;
    }
    /** @internal */
    public function request(string $method, string $path, array $query = [], $body = null, ?bool $disableCache = null, bool $multipart = false, array $fileFields = []) {
        $query = $this->applyCacheControl($method, $query, $disableCache);
        $path = ltrim($path, '/');
        $options = ['query' => $query];
        if ($multipart) {
            $options['multipart'] = $this->buildMultipartBody(is_array($body) ? $body : [], $fileFields);
        } elseif ($body !== null) {
            $options['json'] = $body;
        }
        $res = $this->http->request($method, $path, $options);
        $this->lastResponseMeta = $this->extractMeta($res->getHeaders());
        $status = $res->getStatusCode();
        if ($status >= 400) {
            $json = json_decode((string)$res->getBody(), true) ?? [];
            $code = strtoupper($json['code'] ?? $json['error'] ?? ($status==400?'INVALID_PARAMETER':($status==401?'UNAUTHORIZED':($status==402?'INSUFFICIENT_CREDITS':($status==404?'NOT_FOUND':($status==429?'SERVICE_BUSY':($status>=500?'INTERNAL_SERVER_ERROR':'API_ERROR')))))));
            $msg = $json['message'] ?? $res->getReasonPhrase();
            $cls = $this->classByCode($code);
            $details = $json['details'] ?? $json['quota'] ?? $json['docs'] ?? null;
            throw new $cls($code, $status, $msg, $details, $json, $this->lastResponseMeta);
        }
        $ct = $res->getHeaderLine('content-type');
        return str_contains($ct, 'application/json') ? json_decode((string)$res->getBody(), true) : (string)$res->getBody();
    }

    private function buildMultipartBody(array $body, array $fileFields): array {
        $parts = [];
        $fileFieldSet = array_fill_keys($fileFields, true);
        foreach ($body as $name => $value) {
            if ($value === null) {
                continue;
            }
            if (isset($fileFieldSet[$name])) {
                $parts[] = $this->makeMultipartFilePart($name, $value);
                continue;
            }
            $parts[] = [
                'name' => $name,
                'contents' => $this->stringifyFormValue($value),
            ];
        }
        return $parts;
    }

    private function makeMultipartFilePart(string $name, mixed $value): array {
        if (is_resource($value)) {
            return ['name' => $name, 'contents' => $value, 'filename' => 'upload.bin'];
        }
        if ($value instanceof \SplFileInfo) {
            $path = $value->getPathname();
            if (!is_file($path)) {
                throw new \InvalidArgumentException("File not found: {$path}");
            }
            return ['name' => $name, 'contents' => fopen($path, 'rb'), 'filename' => $value->getBasename()];
        }
        if (is_array($value) && array_key_exists('contents', $value)) {
            return [
                'name' => $name,
                'contents' => $value['contents'],
                'filename' => $value['filename'] ?? 'upload.bin',
            ];
        }
        if (is_string($value)) {
            if (!is_file($value)) {
                throw new \InvalidArgumentException("File not found: {$value}");
            }
            return ['name' => $name, 'contents' => fopen($value, 'rb'), 'filename' => basename($value)];
        }
        throw new \InvalidArgumentException(sprintf('Unsupported multipart file value for %s: %s', $name, get_debug_type($value)));
    }

    private function stringifyFormValue(mixed $value): string {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
        }
        return (string) $value;
    }
    private function classByCode(string $code) {
        return match ($code) {
            'API_ERROR' => ApiErrorError::class,
            'AVATAR_NOT_FOUND' => AvatarNotFoundError::class,
            'CONVERSION_FAILED' => ConversionFailedError::class,
            'FILE_OPEN_ERROR' => FileOpenErrorError::class,
            'FILE_REQUIRED' => FileRequiredError::class,
            'INSUFFICIENT_CREDITS' => InsufficientCreditsError::class,
            'INTERNAL_SERVER_ERROR' => InternalServerErrorError::class,
            'INVALID_PARAMETER' => InvalidParameterError::class,
            'INVALID_PARAMS' => InvalidParamsError::class,
            'NOT_FOUND' => NotFoundError::class,
            'NO_MATCH' => NoMatchError::class,
            'NO_TRACKING_DATA' => NoTrackingDataError::class,
            'PHONE_INFO_FAILED' => PhoneInfoFailedError::class,
            'RECOGNITION_FAILED' => RecognitionFailedError::class,
            'REQUEST_ENTITY_TOO_LARGE' => RequestEntityTooLargeError::class,
            'SERVICE_BUSY' => ServiceBusyError::class,
            'TIMEZONE_NOT_FOUND' => TimezoneNotFoundError::class,
            'UNAUTHORIZED' => UnauthorizedError::class,
            'UNSUPPORTED_CARRIER' => UnsupportedCarrierError::class,
            'UNSUPPORTED_FORMAT' => UnsupportedFormatError::class,
            'VISITOR_MONTHLY_QUOTA_EXHAUSTED' => VisitorMonthlyQuotaExhaustedError::class,
            default => UapiError::class
        };
    }

    private function extractMeta(array $headers): ResponseMeta {
        $meta = new ResponseMeta();
        $raw = [];
        foreach ($headers as $key => $values) {
            $raw[strtolower($key)] = is_array($values) ? implode(', ', array_map('strval', $values)) : strval($values);
        }
        $meta->rawHeaders = $raw;
        $meta->requestId = $raw['x-request-id'] ?? null;
        $meta->retryAfterSeconds = $this->parseInt($raw['retry-after'] ?? null);
        $meta->debitStatus = $raw['uapi-debit-status'] ?? null;
        $meta->creditsRequested = $this->parseInt($raw['uapi-credits-requested'] ?? null);
        $meta->creditsCharged = $this->parseInt($raw['uapi-credits-charged'] ?? null);
        $meta->creditsPricing = $raw['uapi-credits-pricing'] ?? null;
        $meta->activeQuotaBuckets = $this->parseInt($raw['uapi-quota-active-buckets'] ?? null);
        $meta->stopOnEmpty = $this->parseBool($raw['uapi-stop-on-empty'] ?? null);
        $meta->rateLimitPolicyRaw = $raw['ratelimit-policy'] ?? null;
        $meta->rateLimitRaw = $raw['ratelimit'] ?? null;

        foreach ($this->parseStructuredItems($meta->rateLimitPolicyRaw) as $item) {
            $meta->rateLimitPolicies[$item['name']] = [
                'name' => $item['name'],
                'quota' => $this->parseInt($item['params']['q'] ?? null),
                'unit' => $item['params']['uapi-unit'] ?? null,
                'windowSeconds' => $this->parseInt($item['params']['w'] ?? null),
            ];
        }
        foreach ($this->parseStructuredItems($meta->rateLimitRaw) as $item) {
            $meta->rateLimits[$item['name']] = [
                'name' => $item['name'],
                'remaining' => $this->parseInt($item['params']['r'] ?? null),
                'unit' => $item['params']['uapi-unit'] ?? null,
                'resetAfterSeconds' => $this->parseInt($item['params']['t'] ?? null),
            ];
        }

        $meta->balanceLimitCents = $meta->rateLimitPolicies['billing-balance']['quota'] ?? null;
        $meta->balanceRemainingCents = $meta->rateLimits['billing-balance']['remaining'] ?? null;
        $meta->quotaLimitCredits = $meta->rateLimitPolicies['billing-quota']['quota'] ?? null;
        $meta->quotaRemainingCredits = $meta->rateLimits['billing-quota']['remaining'] ?? null;
        $meta->visitorQuotaLimitCredits = $meta->rateLimitPolicies['visitor-quota']['quota'] ?? null;
        $meta->visitorQuotaRemainingCredits = $meta->rateLimits['visitor-quota']['remaining'] ?? null;
        return $meta;
    }

    private function parseStructuredItems(?string $raw): array {
        if ($raw === null || trim($raw) === '') {
            return [];
        }
        $items = [];
        foreach (array_filter(array_map('trim', explode(',', $raw))) as $chunk) {
            $parts = array_filter(array_map('trim', explode(';', $chunk)));
            if (!$parts) {
                continue;
            }
            $item = ['name' => $this->unquote(array_shift($parts)), 'params' => []];
            foreach ($parts as $part) {
                if (!str_contains($part, '=')) {
                    continue;
                }
                [$key, $value] = explode('=', $part, 2);
                $item['params'][trim($key)] = $this->unquote($value);
            }
            $items[] = $item;
        }
        return $items;
    }

    private function unquote(string $value): string {
        $text = trim($value);
        return strlen($text) >= 2 && $text[0] === '"' && $text[strlen($text) - 1] === '"' ? substr($text, 1, -1) : $text;
    }

    private function parseInt(?string $value): ?int {
        return $value !== null && is_numeric(trim($value)) ? intval($value) : null;
    }

    private function parseBool(?string $value): ?bool {
        $normalized = $value !== null ? strtolower(trim($value)) : null;
        return match ($normalized) {
            'true' => true,
            'false' => false,
            default => null,
        };
    }

    public function coerceBool(mixed $value): ?bool {
        if ($value === null) {
            return null;
        }
        if (is_bool($value)) {
            return $value;
        }
        if (is_int($value) || is_float($value)) {
            return $value != 0;
        }
        if (is_string($value)) {
            return match (strtolower(trim($value))) {
                '1', 'true', 'yes', 'on' => true,
                '0', 'false', 'no', 'off' => false,
                default => null,
            };
        }
        return null;
    }

    public function readDisableCacheFlag(array $args): ?bool {
        if (array_key_exists('disableCache', $args)) {
            return $this->coerceBool($args['disableCache']);
        }
        if (array_key_exists('disable_cache', $args)) {
            return $this->coerceBool($args['disable_cache']);
        }
        return null;
    }

    public function applyCacheControl(string $method, array $query, ?bool $disableCache): array {
        if (strtoupper($method) !== 'GET') {
            return $query;
        }
        if (array_key_exists('_t', $query) && $query['_t'] !== null) {
            return $query;
        }
        $effectiveDisableCache = $disableCache ?? $this->disableCacheDefault;
        if (!$effectiveDisableCache) {
            return $query;
        }
        $query['_t'] = (string) round(microtime(true) * 1000);
        return $query;
    }
    function clipzyZaiXianJianTieBan() { return new ClipzyZaiXianJianTieBanApi($this); }
    function convert() { return new ConvertApi($this); }
    function daily() { return new DailyApi($this); }
    function dictionary() { return new DictionaryApi($this); }
    function game() { return new GameApi($this); }
    function image() { return new ImageApi($this); }
    function misc() { return new MiscApi($this); }
    function network() { return new NetworkApi($this); }
    function poem() { return new PoemApi($this); }
    function random() { return new RandomApi($this); }
    function social() { return new SocialApi($this); }
    function status() { return new StatusApi($this); }
    function text() { return new TextApi($this); }
    function translate() { return new TranslateApi($this); }
    function webparse() { return new WebparseApi($this); }
    function minGanCiShiBie() { return new MinGanCiShiBieApi($this); }
    function zhiNengSouSuo() { return new ZhiNengSouSuoApi($this); }
    function shuiYinYuAigcBiaoShi() { return new ShuiYinYuAigcBiaoShiApi($this); }
}
class ClipzyZaiXianJianTieBanApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getClipzyGet(array $args = []) {
        $path='/api/v1/api/get';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('id', $args)) $query['id'] = $args['id'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getClipzyRaw(array $args = []) {
        $path='/api/v1/api/raw/{id}';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('id', $args)) $path = str_replace('{'.'id'.'}', strval($args['id']), $path);
        if (array_key_exists('key', $args)) $query['key'] = $args['key'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postClipzyStore(array $args = []) {
        $path='/api/v1/api/store';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('compressedData', $args)) $body['compressedData'] = $args['compressedData'];
        if (array_key_exists('ttl', $args)) $body['ttl'] = $args['ttl'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class ConvertApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getConvertUnixtime(array $args = []) {
        $path='/api/v1/convert/unixtime';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('time', $args)) $query['time'] = $args['time'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postConvertJson(array $args = []) {
        $path='/api/v1/convert/json';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('content', $args)) $body['content'] = $args['content'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class DailyApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getDailyNewsImage(array $args = []) {
        $path='/api/v1/daily/news-image';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getDailyWord(array $args = []) {
        $path='/api/v1/daily/word';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('lang', $args)) $query['lang'] = $args['lang'];
        if (array_key_exists('category', $args)) $query['category'] = $args['category'];
        if (array_key_exists('count', $args)) $query['count'] = $args['count'];
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('seed', $args)) $query['seed'] = $args['seed'];
        if (array_key_exists('example', $args)) $query['example'] = $args['example'];
        if (array_key_exists('phonetic', $args)) $query['phonetic'] = $args['phonetic'];
        if (array_key_exists('define', $args)) $query['define'] = $args['define'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class DictionaryApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getDictionaryAudio(array $args = []) {
        $path='/api/v1/dictionary/audio';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('word', $args)) $query['word'] = $args['word'];
        if (array_key_exists('accent', $args)) $query['accent'] = $args['accent'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getDictionaryLookup(array $args = []) {
        $path='/api/v1/dictionary/lookup';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('word', $args)) $query['word'] = $args['word'];
        if (array_key_exists('lang', $args)) $query['lang'] = $args['lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class GameApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getGameEpicFree(array $args = []) {
        $path='/api/v1/game/epic-free';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameMinecraftHistoryid(array $args = []) {
        $path='/api/v1/game/minecraft/historyid';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('name', $args)) $query['name'] = $args['name'];
        if (array_key_exists('uuid', $args)) $query['uuid'] = $args['uuid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameMinecraftMods(array $args = []) {
        $path='/api/v1/game/minecraft/mods';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('query', $args)) $query['query'] = $args['query'];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('enrich', $args)) $query['enrich'] = $args['enrich'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameMinecraftServerstatus(array $args = []) {
        $path='/api/v1/game/minecraft/serverstatus';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('server', $args)) $query['server'] = $args['server'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameMinecraftUserinfo(array $args = []) {
        $path='/api/v1/game/minecraft/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('username', $args)) $query['username'] = $args['username'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameMinecraftVersion(array $args = []) {
        $path='/api/v1/game/minecraft/version';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameSteamServers(array $args = []) {
        $path='/api/v1/game/steam/servers';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('appid', $args)) $query['appid'] = $args['appid'];
        if (array_key_exists('name', $args)) $query['name'] = $args['name'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGameSteamSummary(array $args = []) {
        $path='/api/v1/game/steam/summary';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('steamid', $args)) $query['steamid'] = $args['steamid'];
        if (array_key_exists('id', $args)) $query['id'] = $args['id'];
        if (array_key_exists('id3', $args)) $query['id3'] = $args['id3'];
        if (array_key_exists('key', $args)) $query['key'] = $args['key'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class ImageApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAvatarGravatar(array $args = []) {
        $path='/api/v1/avatar/gravatar';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('email', $args)) $query['email'] = $args['email'];
        if (array_key_exists('hash', $args)) $query['hash'] = $args['hash'];
        if (array_key_exists('s', $args)) $query['s'] = $args['s'];
        if (array_key_exists('d', $args)) $query['d'] = $args['d'];
        if (array_key_exists('r', $args)) $query['r'] = $args['r'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getImageBingDaily(array $args = []) {
        $path='/api/v1/image/bing-daily';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('random', $args)) $query['random'] = $args['random'];
        if (array_key_exists('resolution', $args)) $query['resolution'] = $args['resolution'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getImageBingDailyHistory(array $args = []) {
        $path='/api/v1/image/bing-daily/history';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('resolution', $args)) $query['resolution'] = $args['resolution'];
        if (array_key_exists('page', $args)) $query['page'] = $args['page'];
        if (array_key_exists('page_size', $args)) $query['page_size'] = $args['page_size'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getImageMotou(array $args = []) {
        $path='/api/v1/image/motou';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        if (array_key_exists('bg_color', $args)) $query['bg_color'] = $args['bg_color'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getImageQrcode(array $args = []) {
        $path='/api/v1/image/qrcode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('text', $args)) $query['text'] = $args['text'];
        if (array_key_exists('size', $args)) $query['size'] = $args['size'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('transparent', $args)) $query['transparent'] = $args['transparent'];
        if (array_key_exists('fgcolor', $args)) $query['fgcolor'] = $args['fgcolor'];
        if (array_key_exists('bgcolor', $args)) $query['bgcolor'] = $args['bgcolor'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getImageTobase64(array $args = []) {
        $path='/api/v1/image/tobase64';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postImageCompress(array $args = []) {
        $path='/api/v1/image/compress';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('level', $args)) $query['level'] = $args['level'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postImageDecode(array $args = []) {
        $path='/api/v1/image/decode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('width', $args)) $query['width'] = $args['width'];
        if (array_key_exists('height', $args)) $query['height'] = $args['height'];
        if (array_key_exists('max_width', $args)) $query['max_width'] = $args['max_width'];
        if (array_key_exists('max_height', $args)) $query['max_height'] = $args['max_height'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('color_mode', $args)) $query['color_mode'] = $args['color_mode'];
        if (array_key_exists('fit', $args)) $query['fit'] = $args['fit'];
        if (array_key_exists('background', $args)) $query['background'] = $args['background'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postImageFrombase64(array $args = []) {
        $path='/api/v1/image/frombase64';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('imageData', $args)) $body['imageData'] = $args['imageData'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postImageMotou(array $args = []) {
        $path='/api/v1/image/motou';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('bg_color', $args)) $body['bg_color'] = $args['bg_color'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_url', $args)) $body['image_url'] = $args['image_url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postImageNsfw(array $args = []) {
        $path='/api/v1/image/nsfw';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postImageOcr(array $args = []) {
        $path='/api/v1/image/ocr';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('enable_cls', $args)) $body['enable_cls'] = $args['enable_cls'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_base64', $args)) $body['image_base64'] = $args['image_base64'];
        if (array_key_exists('image_name', $args)) $body['image_name'] = $args['image_name'];
        if (array_key_exists('need_location', $args)) $body['need_location'] = $args['need_location'];
        if (array_key_exists('return_markdown', $args)) $body['return_markdown'] = $args['return_markdown'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postImageSpeechless(array $args = []) {
        $path='/api/v1/image/speechless';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('bottom_text', $args)) $body['bottom_text'] = $args['bottom_text'];
        if (array_key_exists('top_text', $args)) $body['top_text'] = $args['top_text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postImageSvg(array $args = []) {
        $path='/api/v1/image/svg';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('width', $args)) $query['width'] = $args['width'];
        if (array_key_exists('height', $args)) $query['height'] = $args['height'];
        if (array_key_exists('quality', $args)) $query['quality'] = $args['quality'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
}
class MiscApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getHistoryProgrammer(array $args = []) {
        $path='/api/v1/history/programmer';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('month', $args)) $query['month'] = $args['month'];
        if (array_key_exists('day', $args)) $query['day'] = $args['day'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getHistoryProgrammerToday(array $args = []) {
        $path='/api/v1/history/programmer/today';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscDistrict(array $args = []) {
        $path='/api/v1/misc/district';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('keywords', $args)) $query['keywords'] = $args['keywords'];
        if (array_key_exists('adcode', $args)) $query['adcode'] = $args['adcode'];
        if (array_key_exists('lat', $args)) $query['lat'] = $args['lat'];
        if (array_key_exists('lng', $args)) $query['lng'] = $args['lng'];
        if (array_key_exists('level', $args)) $query['level'] = $args['level'];
        if (array_key_exists('country', $args)) $query['country'] = $args['country'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscHolidayCalendar(array $args = []) {
        $path='/api/v1/misc/holiday-calendar';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('month', $args)) $query['month'] = $args['month'];
        if (array_key_exists('year', $args)) $query['year'] = $args['year'];
        if (array_key_exists('timezone', $args)) $query['timezone'] = $args['timezone'];
        if (array_key_exists('holiday_type', $args)) $query['holiday_type'] = $args['holiday_type'];
        if (array_key_exists('include_nearby', $args)) $query['include_nearby'] = $args['include_nearby'];
        if (array_key_exists('nearby_limit', $args)) $query['nearby_limit'] = $args['nearby_limit'];
        if (array_key_exists('exclude_past', $args)) $query['exclude_past'] = $args['exclude_past'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscHotboard(array $args = []) {
        $path='/api/v1/misc/hotboard';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('time', $args)) $query['time'] = $args['time'];
        if (array_key_exists('keyword', $args)) $query['keyword'] = $args['keyword'];
        if (array_key_exists('time_start', $args)) $query['time_start'] = $args['time_start'];
        if (array_key_exists('time_end', $args)) $query['time_end'] = $args['time_end'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscLunartime(array $args = []) {
        $path='/api/v1/misc/lunartime';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        if (array_key_exists('timezone', $args)) $query['timezone'] = $args['timezone'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscMovieBoxOffice(array $args = []) {
        $path='/api/v1/misc/movie-box-office';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscMovieRatingRank(array $args = []) {
        $path='/api/v1/misc/movie-rating-rank';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('channel', $args)) $query['channel'] = $args['channel'];
        if (array_key_exists('platform', $args)) $query['platform'] = $args['platform'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('period', $args)) $query['period'] = $args['period'];
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscPhoneinfo(array $args = []) {
        $path='/api/v1/misc/phoneinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('phone', $args)) $query['phone'] = $args['phone'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscRandomnumber(array $args = []) {
        $path='/api/v1/misc/randomnumber';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('min', $args)) $query['min'] = $args['min'];
        if (array_key_exists('max', $args)) $query['max'] = $args['max'];
        if (array_key_exists('count', $args)) $query['count'] = $args['count'];
        if (array_key_exists('allow_repeat', $args)) $query['allow_repeat'] = $args['allow_repeat'];
        if (array_key_exists('allow_decimal', $args)) $query['allow_decimal'] = $args['allow_decimal'];
        if (array_key_exists('decimal_places', $args)) $query['decimal_places'] = $args['decimal_places'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscTimestamp(array $args = []) {
        $path='/api/v1/misc/timestamp';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscTrackingCarriers(array $args = []) {
        $path='/api/v1/misc/tracking/carriers';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscTrackingDetect(array $args = []) {
        $path='/api/v1/misc/tracking/detect';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('tracking_number', $args)) $query['tracking_number'] = $args['tracking_number'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscTrackingQuery(array $args = []) {
        $path='/api/v1/misc/tracking/query';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('tracking_number', $args)) $query['tracking_number'] = $args['tracking_number'];
        if (array_key_exists('carrier_code', $args)) $query['carrier_code'] = $args['carrier_code'];
        if (array_key_exists('phone', $args)) $query['phone'] = $args['phone'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscWeather(array $args = []) {
        $path='/api/v1/misc/weather';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        if (array_key_exists('adcode', $args)) $query['adcode'] = $args['adcode'];
        if (array_key_exists('extended', $args)) $query['extended'] = $args['extended'];
        if (array_key_exists('forecast', $args)) $query['forecast'] = $args['forecast'];
        if (array_key_exists('hourly', $args)) $query['hourly'] = $args['hourly'];
        if (array_key_exists('minutely', $args)) $query['minutely'] = $args['minutely'];
        if (array_key_exists('indices', $args)) $query['indices'] = $args['indices'];
        if (array_key_exists('lang', $args)) $query['lang'] = $args['lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscWeatherHistory(array $args = []) {
        $path='/api/v1/misc/weather/history';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        if (array_key_exists('adcode', $args)) $query['adcode'] = $args['adcode'];
        if (array_key_exists('start_date', $args)) $query['start_date'] = $args['start_date'];
        if (array_key_exists('end_date', $args)) $query['end_date'] = $args['end_date'];
        if (array_key_exists('days', $args)) $query['days'] = $args['days'];
        if (array_key_exists('lang', $args)) $query['lang'] = $args['lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getMiscWorldtime(array $args = []) {
        $path='/api/v1/misc/worldtime';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postMiscDateDiff(array $args = []) {
        $path='/api/v1/misc/date-diff';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('end_date', $args)) $body['end_date'] = $args['end_date'];
        if (array_key_exists('format', $args)) $body['format'] = $args['format'];
        if (array_key_exists('start_date', $args)) $body['start_date'] = $args['start_date'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class NetworkApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getNetworkDns(array $args = []) {
        $path='/api/v1/network/dns';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkIcp(array $args = []) {
        $path='/api/v1/network/icp';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkIpinfo(array $args = []) {
        $path='/api/v1/network/ipinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ip', $args)) $query['ip'] = $args['ip'];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkMyip(array $args = []) {
        $path='/api/v1/network/myip';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkPing(array $args = []) {
        $path='/api/v1/network/ping';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('host', $args)) $query['host'] = $args['host'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkPingmyip(array $args = []) {
        $path='/api/v1/network/pingmyip';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkPortscan(array $args = []) {
        $path='/api/v1/network/portscan';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('host', $args)) $query['host'] = $args['host'];
        if (array_key_exists('port', $args)) $query['port'] = $args['port'];
        if (array_key_exists('protocol', $args)) $query['protocol'] = $args['protocol'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkUrlstatus(array $args = []) {
        $path='/api/v1/network/urlstatus';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkWhois(array $args = []) {
        $path='/api/v1/network/whois';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getNetworkWxdomain(array $args = []) {
        $path='/api/v1/network/wxdomain';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class PoemApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSaying(array $args = []) {
        $path='/api/v1/saying';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSayingRandom(array $args = []) {
        $path='/api/v1/saying/random';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('mode', $args)) $query['mode'] = $args['mode'];
        if (array_key_exists('scene', $args)) $query['scene'] = $args['scene'];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('category', $args)) $query['category'] = $args['category'];
        if (array_key_exists('tag', $args)) $query['tag'] = $args['tag'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class RandomApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAnswerbookAsk(array $args = []) {
        $path='/api/v1/answerbook/ask';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('question', $args)) $query['question'] = $args['question'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getRandomImage(array $args = []) {
        $path='/api/v1/random/image';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('category', $args)) $query['category'] = $args['category'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getRandomString(array $args = []) {
        $path='/api/v1/random/string';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('length', $args)) $query['length'] = $args['length'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postAnswerbookAsk(array $args = []) {
        $path='/api/v1/answerbook/ask';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('question', $args)) $body['question'] = $args['question'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class SocialApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getGithubRepo(array $args = []) {
        $path='/api/v1/github/repo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('repo', $args)) $query['repo'] = $args['repo'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getGithubUser(array $args = []) {
        $path='/api/v1/github/user';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('user', $args)) $query['user'] = $args['user'];
        if (array_key_exists('activity', $args)) $query['activity'] = $args['activity'];
        if (array_key_exists('activity_scope', $args)) $query['activity_scope'] = $args['activity_scope'];
        if (array_key_exists('org', $args)) $query['org'] = $args['org'];
        if (array_key_exists('pinned', $args)) $query['pinned'] = $args['pinned'];
        if (array_key_exists('repos', $args)) $query['repos'] = $args['repos'];
        if (array_key_exists('repos_limit', $args)) $query['repos_limit'] = $args['repos_limit'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialBilibiliArchives(array $args = []) {
        $path='/api/v1/social/bilibili/archives';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('mid', $args)) $query['mid'] = $args['mid'];
        if (array_key_exists('keywords', $args)) $query['keywords'] = $args['keywords'];
        if (array_key_exists('orderby', $args)) $query['orderby'] = $args['orderby'];
        if (array_key_exists('ps', $args)) $query['ps'] = $args['ps'];
        if (array_key_exists('pn', $args)) $query['pn'] = $args['pn'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialBilibiliLiveroom(array $args = []) {
        $path='/api/v1/social/bilibili/liveroom';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('mid', $args)) $query['mid'] = $args['mid'];
        if (array_key_exists('room_id', $args)) $query['room_id'] = $args['room_id'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialBilibiliReplies(array $args = []) {
        $path='/api/v1/social/bilibili/replies';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('oid', $args)) $query['oid'] = $args['oid'];
        if (array_key_exists('sort', $args)) $query['sort'] = $args['sort'];
        if (array_key_exists('ps', $args)) $query['ps'] = $args['ps'];
        if (array_key_exists('pn', $args)) $query['pn'] = $args['pn'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialBilibiliUserinfo(array $args = []) {
        $path='/api/v1/social/bilibili/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('uid', $args)) $query['uid'] = $args['uid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialBilibiliVideoinfo(array $args = []) {
        $path='/api/v1/social/bilibili/videoinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('aid', $args)) $query['aid'] = $args['aid'];
        if (array_key_exists('bvid', $args)) $query['bvid'] = $args['bvid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialQqGroupinfo(array $args = []) {
        $path='/api/v1/social/qq/groupinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('group_id', $args)) $query['group_id'] = $args['group_id'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getSocialQqUserinfo(array $args = []) {
        $path='/api/v1/social/qq/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class StatusApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getStatusRatelimit(array $args = []) {
        $path='/api/v1/status/ratelimit';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getStatusUsage(array $args = []) {
        $path='/api/v1/status/usage';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('path', $args)) $query['path'] = $args['path'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class TextApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getTextMd5(array $args = []) {
        $path='/api/v1/text/md5';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('text', $args)) $query['text'] = $args['text'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextAesDecrypt(array $args = []) {
        $path='/api/v1/text/aes/decrypt';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('nonce', $args)) $body['nonce'] = $args['nonce'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextAesDecryptAdvanced(array $args = []) {
        $path='/api/v1/text/aes/decrypt-advanced';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('iv', $args)) $body['iv'] = $args['iv'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('mode', $args)) $body['mode'] = $args['mode'];
        if (array_key_exists('padding', $args)) $body['padding'] = $args['padding'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextAesEncrypt(array $args = []) {
        $path='/api/v1/text/aes/encrypt';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextAesEncryptAdvanced(array $args = []) {
        $path='/api/v1/text/aes/encrypt-advanced';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('iv', $args)) $body['iv'] = $args['iv'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('mode', $args)) $body['mode'] = $args['mode'];
        if (array_key_exists('output_format', $args)) $body['output_format'] = $args['output_format'];
        if (array_key_exists('padding', $args)) $body['padding'] = $args['padding'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextAnalyze(array $args = []) {
        $path='/api/v1/text/analyze';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextBase64Decode(array $args = []) {
        $path='/api/v1/text/base64/decode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextBase64Encode(array $args = []) {
        $path='/api/v1/text/base64/encode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextConvert(array $args = []) {
        $path='/api/v1/text/convert';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('from', $args)) $body['from'] = $args['from'];
        if (array_key_exists('options', $args)) $body['options'] = $args['options'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        if (array_key_exists('to', $args)) $body['to'] = $args['to'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextMarkdownToHtml(array $args = []) {
        $path='/api/v1/text/markdown-to-html';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('format', $args)) $body['format'] = $args['format'];
        if (array_key_exists('sanitize', $args)) $body['sanitize'] = $args['sanitize'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextMarkdownToPdf(array $args = []) {
        $path='/api/v1/text/markdown-to-pdf';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('paper_size', $args)) $body['paper_size'] = $args['paper_size'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        if (array_key_exists('theme', $args)) $body['theme'] = $args['theme'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextMd5(array $args = []) {
        $path='/api/v1/text/md5';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTextMd5Verify(array $args = []) {
        $path='/api/v1/text/md5/verify';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('hash', $args)) $body['hash'] = $args['hash'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class TranslateApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAiTranslateLanguages(array $args = []) {
        $path='/api/v1/ai/translate/languages';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postAiTranslate(array $args = []) {
        $path='/api/v1/ai/translate';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('target_lang', $args)) $query['target_lang'] = $args['target_lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('context', $args)) $body['context'] = $args['context'];
        if (array_key_exists('preserve_format', $args)) $body['preserve_format'] = $args['preserve_format'];
        if (array_key_exists('source_lang', $args)) $body['source_lang'] = $args['source_lang'];
        if (array_key_exists('style', $args)) $body['style'] = $args['style'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTranslateStream(array $args = []) {
        $path='/api/v1/translate/stream';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('from_lang', $args)) $body['from_lang'] = $args['from_lang'];
        if (array_key_exists('query', $args)) $body['query'] = $args['query'];
        if (array_key_exists('to_lang', $args)) $body['to_lang'] = $args['to_lang'];
        if (array_key_exists('tone', $args)) $body['tone'] = $args['tone'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postTranslateText(array $args = []) {
        $path='/api/v1/translate/text';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('to_lang', $args)) $query['to_lang'] = $args['to_lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class WebparseApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getWebTomarkdownAsyncStatus(array $args = []) {
        $path='/api/v1/web/tomarkdown/async/{task_id}';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('task_id', $args)) $path = str_replace('{'.'task_id'.'}', strval($args['task_id']), $path);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getWebparseExtractimages(array $args = []) {
        $path='/api/v1/webparse/extractimages';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function getWebparseMetadata(array $args = []) {
        $path='/api/v1/webparse/metadata';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postWebTomarkdownAsync(array $args = []) {
        $path='/api/v1/web/tomarkdown/async';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class MinGanCiShiBieApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSensitiveWordAnalyzeQuery(array $args = []) {
        $path='/api/v1/sensitive-word/analyze-query';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('keyword', $args)) $query['keyword'] = $args['keyword'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postSensitiveWordAnalyze(array $args = []) {
        $path='/api/v1/sensitive-word/analyze';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('keywords', $args)) $body['keywords'] = $args['keywords'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postSensitiveWordQuickCheck(array $args = []) {
        $path='/api/v1/text/profanitycheck';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class ZhiNengSouSuoApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSearchEngines(array $args = []) {
        $path='/api/v1/search/engines';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
    function postSearchAggregate(array $args = []) {
        $path='/api/v1/search/aggregate';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('fetch_full', $args)) $body['fetch_full'] = $args['fetch_full'];
        if (array_key_exists('filetype', $args)) $body['filetype'] = $args['filetype'];
        if (array_key_exists('query', $args)) $body['query'] = $args['query'];
        if (array_key_exists('site', $args)) $body['site'] = $args['site'];
        if (array_key_exists('sort', $args)) $body['sort'] = $args['sort'];
        if (array_key_exists('time_range', $args)) $body['time_range'] = $args['time_range'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
class ShuiYinYuAigcBiaoShiApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function postWatermarkDecode(array $args = []) {
        $path='/api/v1/watermark/decode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('ecc', $args)) $body['ecc'] = $args['ecc'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_base64', $args)) $body['image_base64'] = $args['image_base64'];
        if (array_key_exists('model_type', $args)) $body['model_type'] = $args['model_type'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postWatermarkEmbed(array $args = []) {
        $path='/api/v1/watermark/embed';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('ecc', $args)) $body['ecc'] = $args['ecc'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_base64', $args)) $body['image_base64'] = $args['image_base64'];
        if (array_key_exists('jpeg_quality', $args)) $body['jpeg_quality'] = $args['jpeg_quality'];
        if (array_key_exists('model_type', $args)) $body['model_type'] = $args['model_type'];
        if (array_key_exists('out_format', $args)) $body['out_format'] = $args['out_format'];
        if (array_key_exists('payload', $args)) $body['payload'] = $args['payload'];
        if (array_key_exists('strength', $args)) $body['strength'] = $args['strength'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postWatermarkLabel(array $args = []) {
        $path='/api/v1/watermark/label';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('content_producer', $args)) $body['content_producer'] = $args['content_producer'];
        if (array_key_exists('content_propagator', $args)) $body['content_propagator'] = $args['content_propagator'];
        if (array_key_exists('embed_watermark', $args)) $body['embed_watermark'] = $args['embed_watermark'];
        if (array_key_exists('explicit_height_ratio', $args)) $body['explicit_height_ratio'] = $args['explicit_height_ratio'];
        if (array_key_exists('explicit_label', $args)) $body['explicit_label'] = $args['explicit_label'];
        if (array_key_exists('explicit_position', $args)) $body['explicit_position'] = $args['explicit_position'];
        if (array_key_exists('explicit_text', $args)) $body['explicit_text'] = $args['explicit_text'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_base64', $args)) $body['image_base64'] = $args['image_base64'];
        if (array_key_exists('jpeg_quality', $args)) $body['jpeg_quality'] = $args['jpeg_quality'];
        if (array_key_exists('label', $args)) $body['label'] = $args['label'];
        if (array_key_exists('out_format', $args)) $body['out_format'] = $args['out_format'];
        if (array_key_exists('produce_id', $args)) $body['produce_id'] = $args['produce_id'];
        if (array_key_exists('propagate_id', $args)) $body['propagate_id'] = $args['propagate_id'];
        if (array_key_exists('skip_metadata', $args)) $body['skip_metadata'] = $args['skip_metadata'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        if (array_key_exists('watermark_payload', $args)) $body['watermark_payload'] = $args['watermark_payload'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, true, ['file']);
    }
    function postWatermarkProducerCode(array $args = []) {
        $path='/api/v1/watermark/producer-code';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('binding', $args)) $body['binding'] = $args['binding'];
        if (array_key_exists('code', $args)) $body['code'] = $args['code'];
        if (array_key_exists('identifier', $args)) $body['identifier'] = $args['identifier'];
        if (array_key_exists('model_code', $args)) $body['model_code'] = $args['model_code'];
        if (array_key_exists('service_type', $args)) $body['service_type'] = $args['service_type'];
        if (array_key_exists('subject_type', $args)) $body['subject_type'] = $args['subject_type'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache, false, []);
    }
}
