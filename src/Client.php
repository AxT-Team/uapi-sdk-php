<?php
namespace Uapi;

use GuzzleHttp\Client as Guzzle;

class ResponseMeta {
    public ?string $requestId = null;
    public ?string $retryAfterRaw = null;
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
    public ?int $billingKeyRateLimit = null;
    public ?int $billingKeyRateRemaining = null;
    public ?string $billingKeyRateUnit = null;
    public ?int $billingKeyRateWindowSeconds = null;
    public ?int $billingKeyRateResetAfterSeconds = null;
    public ?int $billingIpRateLimit = null;
    public ?int $billingIpRateRemaining = null;
    public ?string $billingIpRateUnit = null;
    public ?int $billingIpRateWindowSeconds = null;
    public ?int $billingIpRateResetAfterSeconds = null;
    public ?int $visitorRateLimit = null;
    public ?int $visitorRateRemaining = null;
    public ?string $visitorRateUnit = null;
    public ?int $visitorRateWindowSeconds = null;
    public ?int $visitorRateResetAfterSeconds = null;
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
    public function __get(string $name) {
        if ($name === 'code') {
            return $this->apiCode;
        }
        trigger_error('Undefined property: ' . static::class . '::$' . $name, E_USER_NOTICE);
        return null;
    }
    public function __isset(string $name): bool {
        return $name === 'code';
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
    public ?ResponseMeta $lastResponseMeta = null;
    function __construct(string $baseUrl, ?string $token = null, bool $verifyTls = true) {
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
    public function request(string $method, string $path, array $query = [], $body = null) {
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
        $meta->retryAfterRaw = $raw['retry-after'] ?? null;
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
        $meta->billingKeyRateLimit = $meta->rateLimitPolicies['billing-key-rate']['quota'] ?? null;
        $meta->billingKeyRateRemaining = $meta->rateLimits['billing-key-rate']['remaining'] ?? null;
        $meta->billingKeyRateUnit = $meta->rateLimitPolicies['billing-key-rate']['unit'] ?? ($meta->rateLimits['billing-key-rate']['unit'] ?? null);
        $meta->billingKeyRateWindowSeconds = $meta->rateLimitPolicies['billing-key-rate']['windowSeconds'] ?? null;
        $meta->billingKeyRateResetAfterSeconds = $meta->rateLimits['billing-key-rate']['resetAfterSeconds'] ?? null;
        $meta->billingIpRateLimit = $meta->rateLimitPolicies['billing-ip-rate']['quota'] ?? null;
        $meta->billingIpRateRemaining = $meta->rateLimits['billing-ip-rate']['remaining'] ?? null;
        $meta->billingIpRateUnit = $meta->rateLimitPolicies['billing-ip-rate']['unit'] ?? ($meta->rateLimits['billing-ip-rate']['unit'] ?? null);
        $meta->billingIpRateWindowSeconds = $meta->rateLimitPolicies['billing-ip-rate']['windowSeconds'] ?? null;
        $meta->billingIpRateResetAfterSeconds = $meta->rateLimits['billing-ip-rate']['resetAfterSeconds'] ?? null;
        $meta->visitorRateLimit = $meta->rateLimitPolicies['visitor-rate']['quota'] ?? null;
        $meta->visitorRateRemaining = $meta->rateLimits['visitor-rate']['remaining'] ?? null;
        $meta->visitorRateUnit = $meta->rateLimitPolicies['visitor-rate']['unit'] ?? ($meta->rateLimits['visitor-rate']['unit'] ?? null);
        $meta->visitorRateWindowSeconds = $meta->rateLimitPolicies['visitor-rate']['windowSeconds'] ?? null;
        $meta->visitorRateResetAfterSeconds = $meta->rateLimits['visitor-rate']['resetAfterSeconds'] ?? null;
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
        if (array_key_exists('id', $args)) $query['id'] = $args['id'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getClipzyRaw(array $args = []) {
        $path='/api/v1/api/raw/{id}';
        $query = [];
        $body = [];
        if (array_key_exists('id', $args)) $path = str_replace('{'.'id'.'}', strval($args['id']), $path);
        if (array_key_exists('key', $args)) $query['key'] = $args['key'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postClipzyStore(array $args = []) {
        $path='/api/v1/api/store';
        $query = [];
        $body = [];
        if (array_key_exists('compressedData', $args)) $body['compressedData'] = $args['compressedData'];
        if (array_key_exists('ttl', $args)) $body['ttl'] = $args['ttl'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class ConvertApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getConvertUnixtime(array $args = []) {
        $path='/api/v1/convert/unixtime';
        $query = [];
        $body = [];
        if (array_key_exists('time', $args)) $query['time'] = $args['time'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postConvertJson(array $args = []) {
        $path='/api/v1/convert/json';
        $query = [];
        $body = [];
        if (array_key_exists('content', $args)) $body['content'] = $args['content'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class DailyApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getDailyNewsImage(array $args = []) {
        $path='/api/v1/daily/news-image';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class GameApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getGameEpicFree(array $args = []) {
        $path='/api/v1/game/epic-free';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getGameMinecraftHistoryid(array $args = []) {
        $path='/api/v1/game/minecraft/historyid';
        $query = [];
        $body = [];
        if (array_key_exists('name', $args)) $query['name'] = $args['name'];
        if (array_key_exists('uuid', $args)) $query['uuid'] = $args['uuid'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getGameMinecraftServerstatus(array $args = []) {
        $path='/api/v1/game/minecraft/serverstatus';
        $query = [];
        $body = [];
        if (array_key_exists('server', $args)) $query['server'] = $args['server'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getGameMinecraftUserinfo(array $args = []) {
        $path='/api/v1/game/minecraft/userinfo';
        $query = [];
        $body = [];
        if (array_key_exists('username', $args)) $query['username'] = $args['username'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getGameSteamSummary(array $args = []) {
        $path='/api/v1/game/steam/summary';
        $query = [];
        $body = [];
        if (array_key_exists('steamid', $args)) $query['steamid'] = $args['steamid'];
        if (array_key_exists('id', $args)) $query['id'] = $args['id'];
        if (array_key_exists('id3', $args)) $query['id3'] = $args['id3'];
        if (array_key_exists('key', $args)) $query['key'] = $args['key'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class ImageApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAvatarGravatar(array $args = []) {
        $path='/api/v1/avatar/gravatar';
        $query = [];
        $body = [];
        if (array_key_exists('email', $args)) $query['email'] = $args['email'];
        if (array_key_exists('hash', $args)) $query['hash'] = $args['hash'];
        if (array_key_exists('s', $args)) $query['s'] = $args['s'];
        if (array_key_exists('d', $args)) $query['d'] = $args['d'];
        if (array_key_exists('r', $args)) $query['r'] = $args['r'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getImageBingDaily(array $args = []) {
        $path='/api/v1/image/bing-daily';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getImageMotou(array $args = []) {
        $path='/api/v1/image/motou';
        $query = [];
        $body = [];
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        if (array_key_exists('bg_color', $args)) $query['bg_color'] = $args['bg_color'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getImageQrcode(array $args = []) {
        $path='/api/v1/image/qrcode';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $query['text'] = $args['text'];
        if (array_key_exists('size', $args)) $query['size'] = $args['size'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('transparent', $args)) $query['transparent'] = $args['transparent'];
        if (array_key_exists('fgcolor', $args)) $query['fgcolor'] = $args['fgcolor'];
        if (array_key_exists('bgcolor', $args)) $query['bgcolor'] = $args['bgcolor'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getImageTobase64(array $args = []) {
        $path='/api/v1/image/tobase64';
        $query = [];
        $body = [];
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postImageCompress(array $args = []) {
        $path='/api/v1/image/compress';
        $query = [];
        $body = [];
        if (array_key_exists('level', $args)) $query['level'] = $args['level'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postImageFrombase64(array $args = []) {
        $path='/api/v1/image/frombase64';
        $query = [];
        $body = [];
        if (array_key_exists('imageData', $args)) $body['imageData'] = $args['imageData'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postImageMotou(array $args = []) {
        $path='/api/v1/image/motou';
        $query = [];
        $body = [];
        if (array_key_exists('bg_color', $args)) $body['bg_color'] = $args['bg_color'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('image_url', $args)) $body['image_url'] = $args['image_url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postImageNsfw(array $args = []) {
        $path='/api/v1/image/nsfw';
        $query = [];
        $body = [];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        if (array_key_exists('url', $args)) $body['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postImageSpeechless(array $args = []) {
        $path='/api/v1/image/speechless';
        $query = [];
        $body = [];
        if (array_key_exists('bottom_text', $args)) $body['bottom_text'] = $args['bottom_text'];
        if (array_key_exists('top_text', $args)) $body['top_text'] = $args['top_text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postImageSvg(array $args = []) {
        $path='/api/v1/image/svg';
        $query = [];
        $body = [];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        if (array_key_exists('width', $args)) $query['width'] = $args['width'];
        if (array_key_exists('height', $args)) $query['height'] = $args['height'];
        if (array_key_exists('quality', $args)) $query['quality'] = $args['quality'];
        if (array_key_exists('file', $args)) $body['file'] = $args['file'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class MiscApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getHistoryProgrammer(array $args = []) {
        $path='/api/v1/history/programmer';
        $query = [];
        $body = [];
        if (array_key_exists('month', $args)) $query['month'] = $args['month'];
        if (array_key_exists('day', $args)) $query['day'] = $args['day'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getHistoryProgrammerToday(array $args = []) {
        $path='/api/v1/history/programmer/today';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscDistrict(array $args = []) {
        $path='/api/v1/misc/district';
        $query = [];
        $body = [];
        if (array_key_exists('keywords', $args)) $query['keywords'] = $args['keywords'];
        if (array_key_exists('adcode', $args)) $query['adcode'] = $args['adcode'];
        if (array_key_exists('lat', $args)) $query['lat'] = $args['lat'];
        if (array_key_exists('lng', $args)) $query['lng'] = $args['lng'];
        if (array_key_exists('level', $args)) $query['level'] = $args['level'];
        if (array_key_exists('country', $args)) $query['country'] = $args['country'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscHolidayCalendar(array $args = []) {
        $path='/api/v1/misc/holiday-calendar';
        $query = [];
        $body = [];
        if (array_key_exists('date', $args)) $query['date'] = $args['date'];
        if (array_key_exists('month', $args)) $query['month'] = $args['month'];
        if (array_key_exists('year', $args)) $query['year'] = $args['year'];
        if (array_key_exists('timezone', $args)) $query['timezone'] = $args['timezone'];
        if (array_key_exists('holiday_type', $args)) $query['holiday_type'] = $args['holiday_type'];
        if (array_key_exists('include_nearby', $args)) $query['include_nearby'] = $args['include_nearby'];
        if (array_key_exists('nearby_limit', $args)) $query['nearby_limit'] = $args['nearby_limit'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscHotboard(array $args = []) {
        $path='/api/v1/misc/hotboard';
        $query = [];
        $body = [];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        if (array_key_exists('time', $args)) $query['time'] = $args['time'];
        if (array_key_exists('keyword', $args)) $query['keyword'] = $args['keyword'];
        if (array_key_exists('time_start', $args)) $query['time_start'] = $args['time_start'];
        if (array_key_exists('time_end', $args)) $query['time_end'] = $args['time_end'];
        if (array_key_exists('limit', $args)) $query['limit'] = $args['limit'];
        if (array_key_exists('sources', $args)) $query['sources'] = $args['sources'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscLunartime(array $args = []) {
        $path='/api/v1/misc/lunartime';
        $query = [];
        $body = [];
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        if (array_key_exists('timezone', $args)) $query['timezone'] = $args['timezone'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscPhoneinfo(array $args = []) {
        $path='/api/v1/misc/phoneinfo';
        $query = [];
        $body = [];
        if (array_key_exists('phone', $args)) $query['phone'] = $args['phone'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscRandomnumber(array $args = []) {
        $path='/api/v1/misc/randomnumber';
        $query = [];
        $body = [];
        if (array_key_exists('min', $args)) $query['min'] = $args['min'];
        if (array_key_exists('max', $args)) $query['max'] = $args['max'];
        if (array_key_exists('count', $args)) $query['count'] = $args['count'];
        if (array_key_exists('allow_repeat', $args)) $query['allow_repeat'] = $args['allow_repeat'];
        if (array_key_exists('allow_decimal', $args)) $query['allow_decimal'] = $args['allow_decimal'];
        if (array_key_exists('decimal_places', $args)) $query['decimal_places'] = $args['decimal_places'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscTimestamp(array $args = []) {
        $path='/api/v1/misc/timestamp';
        $query = [];
        $body = [];
        if (array_key_exists('ts', $args)) $query['ts'] = $args['ts'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscTrackingCarriers(array $args = []) {
        $path='/api/v1/misc/tracking/carriers';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscTrackingDetect(array $args = []) {
        $path='/api/v1/misc/tracking/detect';
        $query = [];
        $body = [];
        if (array_key_exists('tracking_number', $args)) $query['tracking_number'] = $args['tracking_number'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscTrackingQuery(array $args = []) {
        $path='/api/v1/misc/tracking/query';
        $query = [];
        $body = [];
        if (array_key_exists('tracking_number', $args)) $query['tracking_number'] = $args['tracking_number'];
        if (array_key_exists('carrier_code', $args)) $query['carrier_code'] = $args['carrier_code'];
        if (array_key_exists('phone', $args)) $query['phone'] = $args['phone'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscWeather(array $args = []) {
        $path='/api/v1/misc/weather';
        $query = [];
        $body = [];
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        if (array_key_exists('adcode', $args)) $query['adcode'] = $args['adcode'];
        if (array_key_exists('extended', $args)) $query['extended'] = $args['extended'];
        if (array_key_exists('forecast', $args)) $query['forecast'] = $args['forecast'];
        if (array_key_exists('hourly', $args)) $query['hourly'] = $args['hourly'];
        if (array_key_exists('minutely', $args)) $query['minutely'] = $args['minutely'];
        if (array_key_exists('indices', $args)) $query['indices'] = $args['indices'];
        if (array_key_exists('lang', $args)) $query['lang'] = $args['lang'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getMiscWorldtime(array $args = []) {
        $path='/api/v1/misc/worldtime';
        $query = [];
        $body = [];
        if (array_key_exists('city', $args)) $query['city'] = $args['city'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postMiscDateDiff(array $args = []) {
        $path='/api/v1/misc/date-diff';
        $query = [];
        $body = [];
        if (array_key_exists('end_date', $args)) $body['end_date'] = $args['end_date'];
        if (array_key_exists('format', $args)) $body['format'] = $args['format'];
        if (array_key_exists('start_date', $args)) $body['start_date'] = $args['start_date'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class NetworkApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getNetworkDns(array $args = []) {
        $path='/api/v1/network/dns';
        $query = [];
        $body = [];
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkIcp(array $args = []) {
        $path='/api/v1/network/icp';
        $query = [];
        $body = [];
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkIpinfo(array $args = []) {
        $path='/api/v1/network/ipinfo';
        $query = [];
        $body = [];
        if (array_key_exists('ip', $args)) $query['ip'] = $args['ip'];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkMyip(array $args = []) {
        $path='/api/v1/network/myip';
        $query = [];
        $body = [];
        if (array_key_exists('source', $args)) $query['source'] = $args['source'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkPing(array $args = []) {
        $path='/api/v1/network/ping';
        $query = [];
        $body = [];
        if (array_key_exists('host', $args)) $query['host'] = $args['host'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkPingmyip(array $args = []) {
        $path='/api/v1/network/pingmyip';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkPortscan(array $args = []) {
        $path='/api/v1/network/portscan';
        $query = [];
        $body = [];
        if (array_key_exists('host', $args)) $query['host'] = $args['host'];
        if (array_key_exists('port', $args)) $query['port'] = $args['port'];
        if (array_key_exists('protocol', $args)) $query['protocol'] = $args['protocol'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkUrlstatus(array $args = []) {
        $path='/api/v1/network/urlstatus';
        $query = [];
        $body = [];
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkWhois(array $args = []) {
        $path='/api/v1/network/whois';
        $query = [];
        $body = [];
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        if (array_key_exists('format', $args)) $query['format'] = $args['format'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getNetworkWxdomain(array $args = []) {
        $path='/api/v1/network/wxdomain';
        $query = [];
        $body = [];
        if (array_key_exists('domain', $args)) $query['domain'] = $args['domain'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class PoemApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSaying(array $args = []) {
        $path='/api/v1/saying';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class RandomApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAnswerbookAsk(array $args = []) {
        $path='/api/v1/answerbook/ask';
        $query = [];
        $body = [];
        if (array_key_exists('question', $args)) $query['question'] = $args['question'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getRandomImage(array $args = []) {
        $path='/api/v1/random/image';
        $query = [];
        $body = [];
        if (array_key_exists('category', $args)) $query['category'] = $args['category'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getRandomString(array $args = []) {
        $path='/api/v1/random/string';
        $query = [];
        $body = [];
        if (array_key_exists('length', $args)) $query['length'] = $args['length'];
        if (array_key_exists('type', $args)) $query['type'] = $args['type'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postAnswerbookAsk(array $args = []) {
        $path='/api/v1/answerbook/ask';
        $query = [];
        $body = [];
        if (array_key_exists('question', $args)) $body['question'] = $args['question'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class SocialApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getGithubRepo(array $args = []) {
        $path='/api/v1/github/repo';
        $query = [];
        $body = [];
        if (array_key_exists('repo', $args)) $query['repo'] = $args['repo'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialBilibiliArchives(array $args = []) {
        $path='/api/v1/social/bilibili/archives';
        $query = [];
        $body = [];
        if (array_key_exists('mid', $args)) $query['mid'] = $args['mid'];
        if (array_key_exists('keywords', $args)) $query['keywords'] = $args['keywords'];
        if (array_key_exists('orderby', $args)) $query['orderby'] = $args['orderby'];
        if (array_key_exists('ps', $args)) $query['ps'] = $args['ps'];
        if (array_key_exists('pn', $args)) $query['pn'] = $args['pn'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialBilibiliLiveroom(array $args = []) {
        $path='/api/v1/social/bilibili/liveroom';
        $query = [];
        $body = [];
        if (array_key_exists('mid', $args)) $query['mid'] = $args['mid'];
        if (array_key_exists('room_id', $args)) $query['room_id'] = $args['room_id'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialBilibiliReplies(array $args = []) {
        $path='/api/v1/social/bilibili/replies';
        $query = [];
        $body = [];
        if (array_key_exists('oid', $args)) $query['oid'] = $args['oid'];
        if (array_key_exists('sort', $args)) $query['sort'] = $args['sort'];
        if (array_key_exists('ps', $args)) $query['ps'] = $args['ps'];
        if (array_key_exists('pn', $args)) $query['pn'] = $args['pn'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialBilibiliUserinfo(array $args = []) {
        $path='/api/v1/social/bilibili/userinfo';
        $query = [];
        $body = [];
        if (array_key_exists('uid', $args)) $query['uid'] = $args['uid'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialBilibiliVideoinfo(array $args = []) {
        $path='/api/v1/social/bilibili/videoinfo';
        $query = [];
        $body = [];
        if (array_key_exists('aid', $args)) $query['aid'] = $args['aid'];
        if (array_key_exists('bvid', $args)) $query['bvid'] = $args['bvid'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialQqGroupinfo(array $args = []) {
        $path='/api/v1/social/qq/groupinfo';
        $query = [];
        $body = [];
        if (array_key_exists('group_id', $args)) $query['group_id'] = $args['group_id'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getSocialQqUserinfo(array $args = []) {
        $path='/api/v1/social/qq/userinfo';
        $query = [];
        $body = [];
        if (array_key_exists('qq', $args)) $query['qq'] = $args['qq'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class StatusApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getStatusRatelimit(array $args = []) {
        $path='/api/v1/status/ratelimit';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getStatusUsage(array $args = []) {
        $path='/api/v1/status/usage';
        $query = [];
        $body = [];
        if (array_key_exists('path', $args)) $query['path'] = $args['path'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
}
class TextApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getTextMd5(array $args = []) {
        $path='/api/v1/text/md5';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $query['text'] = $args['text'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postTextAesDecrypt(array $args = []) {
        $path='/api/v1/text/aes/decrypt';
        $query = [];
        $body = [];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('nonce', $args)) $body['nonce'] = $args['nonce'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextAesDecryptAdvanced(array $args = []) {
        $path='/api/v1/text/aes/decrypt-advanced';
        $query = [];
        $body = [];
        if (array_key_exists('iv', $args)) $body['iv'] = $args['iv'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('mode', $args)) $body['mode'] = $args['mode'];
        if (array_key_exists('padding', $args)) $body['padding'] = $args['padding'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextAesEncrypt(array $args = []) {
        $path='/api/v1/text/aes/encrypt';
        $query = [];
        $body = [];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextAesEncryptAdvanced(array $args = []) {
        $path='/api/v1/text/aes/encrypt-advanced';
        $query = [];
        $body = [];
        if (array_key_exists('iv', $args)) $body['iv'] = $args['iv'];
        if (array_key_exists('key', $args)) $body['key'] = $args['key'];
        if (array_key_exists('mode', $args)) $body['mode'] = $args['mode'];
        if (array_key_exists('output_format', $args)) $body['output_format'] = $args['output_format'];
        if (array_key_exists('padding', $args)) $body['padding'] = $args['padding'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextAnalyze(array $args = []) {
        $path='/api/v1/text/analyze';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextBase64Decode(array $args = []) {
        $path='/api/v1/text/base64/decode';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextBase64Encode(array $args = []) {
        $path='/api/v1/text/base64/encode';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextConvert(array $args = []) {
        $path='/api/v1/text/convert';
        $query = [];
        $body = [];
        if (array_key_exists('from', $args)) $body['from'] = $args['from'];
        if (array_key_exists('options', $args)) $body['options'] = $args['options'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        if (array_key_exists('to', $args)) $body['to'] = $args['to'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextMd5(array $args = []) {
        $path='/api/v1/text/md5';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTextMd5Verify(array $args = []) {
        $path='/api/v1/text/md5/verify';
        $query = [];
        $body = [];
        if (array_key_exists('hash', $args)) $body['hash'] = $args['hash'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class TranslateApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getAiTranslateLanguages(array $args = []) {
        $path='/api/v1/ai/translate/languages';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postAiTranslate(array $args = []) {
        $path='/api/v1/ai/translate';
        $query = [];
        $body = [];
        if (array_key_exists('target_lang', $args)) $query['target_lang'] = $args['target_lang'];
        if (array_key_exists('context', $args)) $body['context'] = $args['context'];
        if (array_key_exists('preserve_format', $args)) $body['preserve_format'] = $args['preserve_format'];
        if (array_key_exists('source_lang', $args)) $body['source_lang'] = $args['source_lang'];
        if (array_key_exists('style', $args)) $body['style'] = $args['style'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTranslateStream(array $args = []) {
        $path='/api/v1/translate/stream';
        $query = [];
        $body = [];
        if (array_key_exists('from_lang', $args)) $body['from_lang'] = $args['from_lang'];
        if (array_key_exists('query', $args)) $body['query'] = $args['query'];
        if (array_key_exists('to_lang', $args)) $body['to_lang'] = $args['to_lang'];
        if (array_key_exists('tone', $args)) $body['tone'] = $args['tone'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postTranslateText(array $args = []) {
        $path='/api/v1/translate/text';
        $query = [];
        $body = [];
        if (array_key_exists('to_lang', $args)) $query['to_lang'] = $args['to_lang'];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class WebparseApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getWebTomarkdownAsyncStatus(array $args = []) {
        $path='/api/v1/web/tomarkdown/async/{task_id}';
        $query = [];
        $body = [];
        if (array_key_exists('task_id', $args)) $path = str_replace('{'.'task_id'.'}', strval($args['task_id']), $path);
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getWebparseExtractimages(array $args = []) {
        $path='/api/v1/webparse/extractimages';
        $query = [];
        $body = [];
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function getWebparseMetadata(array $args = []) {
        $path='/api/v1/webparse/metadata';
        $query = [];
        $body = [];
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postWebTomarkdownAsync(array $args = []) {
        $path='/api/v1/web/tomarkdown/async';
        $query = [];
        $body = [];
        if (array_key_exists('url', $args)) $query['url'] = $args['url'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class MinGanCiShiBieApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSensitiveWordAnalyzeQuery(array $args = []) {
        $path='/api/v1/sensitive-word/analyze-query';
        $query = [];
        $body = [];
        if (array_key_exists('keyword', $args)) $query['keyword'] = $args['keyword'];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postSensitiveWordAnalyze(array $args = []) {
        $path='/api/v1/sensitive-word/analyze';
        $query = [];
        $body = [];
        if (array_key_exists('keywords', $args)) $body['keywords'] = $args['keywords'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
    function postSensitiveWordQuickCheck(array $args = []) {
        $path='/api/v1/text/profanitycheck';
        $query = [];
        $body = [];
        if (array_key_exists('text', $args)) $body['text'] = $args['text'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
class ZhiNengSouSuoApi {
    private Client $c; function __construct(Client $c){ $this->c=$c; }
    function getSearchEngines(array $args = []) {
        $path='/api/v1/search/engines';
        $query = [];
        $body = [];
        return $this->c->request('GET', $path, $query, empty($body) ? null : $body);
    }
    function postSearchAggregate(array $args = []) {
        $path='/api/v1/search/aggregate';
        $query = [];
        $body = [];
        if (array_key_exists('fetch_full', $args)) $body['fetch_full'] = $args['fetch_full'];
        if (array_key_exists('filetype', $args)) $body['filetype'] = $args['filetype'];
        if (array_key_exists('query', $args)) $body['query'] = $args['query'];
        if (array_key_exists('site', $args)) $body['site'] = $args['site'];
        if (array_key_exists('sort', $args)) $body['sort'] = $args['sort'];
        if (array_key_exists('time_range', $args)) $body['time_range'] = $args['time_range'];
        if (array_key_exists('timeout_ms', $args)) $body['timeout_ms'] = $args['timeout_ms'];
        return $this->c->request('POST', $path, $query, empty($body) ? null : $body);
    }
}
