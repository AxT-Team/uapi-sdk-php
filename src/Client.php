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
    public function request(string $method, string $path, array $query = [], $body = null, ?bool $disableCache = null) {
        $query = $this->applyCacheControl($method, $query, $disableCache);
        $path = ltrim($path, '/');
        $res = $this->http->request($method, $path, ['query'=>$query, 'json'=>$body]);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getClipzyRaw(array $args = []) {
        $path='/api/v1/api/raw/{id}';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('id', $args)) $path = str_replace('{'.'id'.'}', strval($args['id']), $path);
        if (array_key_exists('key', $args)) $query['key'] = $args['key'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postClipzyStore(array $args = []) {
        $path='/api/v1/api/store';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('compressedData', $args)) $body['compressedData'] = $args['compressedData'];
        if (array_key_exists('ttl', $args)) $body['ttl'] = $args['ttl'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postConvertJson(array $args = []) {
        $path='/api/v1/convert/json';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('content', $args)) $body['content'] = $args['content'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getGameMinecraftHistoryid(array $args = []) {
        $path='/api/v1/game/minecraft/historyid';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('name', $args)) $query['name'] = $args['name'];
        if (array_key_exists('uuid', $args)) $query['uuid'] = $args['uuid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getGameMinecraftServerstatus(array $args = []) {
        $path='/api/v1/game/minecraft/serverstatus';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('server', $args)) $query['server'] = $args['server'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getGameMinecraftUserinfo(array $args = []) {
        $path='/api/v1/game/minecraft/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('username', $args)) $query['username'] = $args['username'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getImageBingDaily(array $args = []) {
        $path='/api/v1/image/bing-daily';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getImageMotou(array $args = []) {
        $path='/api/v1/image/motou';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        if (array_key_exists('bg_color', $args)) $query['bg_color'] = $args['bg_color'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getImageTobase64(array $args = []) {
        $path='/api/v1/image/tobase64';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postImageFrombase64(array $args = []) {
        $path='/api/v1/image/frombase64';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('imageData', $args)) $body['imageData'] = $args['imageData'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postImageNsfw(array $args = []) {
        $path='/api/v1/image/nsfw';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postImageSpeechless(array $args = []) {
        $path='/api/v1/image/speechless';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('bottom_text', $args)) $body['bottom_text'] = $args['bottom_text'];
        if (array_key_exists('top_text', $args)) $body['top_text'] = $args['top_text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getHistoryProgrammerToday(array $args = []) {
        $path='/api/v1/history/programmer/today';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        if (array_key_exists('sources', $args)) $query['sources'] = $args['sources'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscLunartime(array $args = []) {
        $path='/api/v1/misc/lunartime';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        if (array_key_exists('timezone', $args)) $query['timezone'] = $args['timezone'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscPhoneinfo(array $args = []) {
        $path='/api/v1/misc/phoneinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('phone', $args)) $query['phone'] = $args['phone'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscTimestamp(array $args = []) {
        $path='/api/v1/misc/timestamp';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscTrackingCarriers(array $args = []) {
        $path='/api/v1/misc/tracking/carriers';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscTrackingDetect(array $args = []) {
        $path='/api/v1/misc/tracking/detect';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('tracking_number', $args)) $query['tracking_number'] = $args['tracking_number'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getMiscWorldtime(array $args = []) {
        $path='/api/v1/misc/worldtime';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkIcp(array $args = []) {
        $path='/api/v1/network/icp';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkIpinfo(array $args = []) {
        $path='/api/v1/network/ipinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('ip', $args)) $query['ip'] = $args['ip'];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkMyip(array $args = []) {
        $path='/api/v1/network/myip';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkPing(array $args = []) {
        $path='/api/v1/network/ping';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('host', $args)) $query['host'] = $args['host'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkPingmyip(array $args = []) {
        $path='/api/v1/network/pingmyip';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkUrlstatus(array $args = []) {
        $path='/api/v1/network/urlstatus';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkWhois(array $args = []) {
        $path='/api/v1/network/whois';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getNetworkWxdomain(array $args = []) {
        $path='/api/v1/network/wxdomain';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getRandomImage(array $args = []) {
        $path='/api/v1/random/image';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('category', $args)) $query['category'] = $args['category'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getRandomString(array $args = []) {
        $path='/api/v1/random/string';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('length', $args)) $query['length'] = $args['length'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postAnswerbookAsk(array $args = []) {
        $path='/api/v1/answerbook/ask';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('question', $args)) $body['question'] = $args['question'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getSocialBilibiliLiveroom(array $args = []) {
        $path='/api/v1/social/bilibili/liveroom';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('mid', $args)) $query['mid'] = $args['mid'];
        if (array_key_exists('room_id', $args)) $query['room_id'] = $args['room_id'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getSocialBilibiliUserinfo(array $args = []) {
        $path='/api/v1/social/bilibili/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('uid', $args)) $query['uid'] = $args['uid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getSocialBilibiliVideoinfo(array $args = []) {
        $path='/api/v1/social/bilibili/videoinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('aid', $args)) $query['aid'] = $args['aid'];
        if (array_key_exists('bvid', $args)) $query['bvid'] = $args['bvid'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getSocialQqGroupinfo(array $args = []) {
        $path='/api/v1/social/qq/groupinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('group_id', $args)) $query['group_id'] = $args['group_id'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getSocialQqUserinfo(array $args = []) {
        $path='/api/v1/social/qq/userinfo';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getStatusUsage(array $args = []) {
        $path='/api/v1/status/usage';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('path', $args)) $query['path'] = $args['path'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextAesEncrypt(array $args = []) {
        $path='/api/v1/text/aes/encrypt';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextAnalyze(array $args = []) {
        $path='/api/v1/text/analyze';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextBase64Decode(array $args = []) {
        $path='/api/v1/text/base64/decode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextBase64Encode(array $args = []) {
        $path='/api/v1/text/base64/encode';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextMd5(array $args = []) {
        $path='/api/v1/text/md5';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTextMd5Verify(array $args = []) {
        $path='/api/v1/text/md5/verify';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('hash', $args)) $body['hash'] = $args['hash'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postTranslateText(array $args = []) {
        $path='/api/v1/translate/text';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('to_lang', $args)) $query['to_lang'] = $args['to_lang'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getWebparseExtractimages(array $args = []) {
        $path='/api/v1/webparse/extractimages';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function getWebparseMetadata(array $args = []) {
        $path='/api/v1/webparse/metadata';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postWebTomarkdownAsync(array $args = []) {
        $path='/api/v1/web/tomarkdown/async';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postSensitiveWordAnalyze(array $args = []) {
        $path='/api/v1/sensitive-word/analyze';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('keywords', $args)) $body['keywords'] = $args['keywords'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
    function postSensitiveWordQuickCheck(array $args = []) {
        $path='/api/v1/text/profanitycheck';
        $query = [];
        $body = [];
        $disableCache = $this->c->readDisableCacheFlag($args);
        if (array_key_exists('_t', $args)) $query['_t'] = $args['_t'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
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
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body, $disableCache);
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
        if (array_key_exists('timeout_ms', $args)) $body['timeout_ms'] = $args['timeout_ms'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body, $disableCache);
    }
}
