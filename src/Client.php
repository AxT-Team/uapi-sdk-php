<?php
namespace Uapi;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\BadResponseException;

class UapiError extends \Exception {
    public string $code; public int $status; public $details;
    function __construct(string $code, int $status, string $message, $details = null) {
        parent::__construct("[$status] $code: $message"); $this->code = $code; $this->status = $status; $this->details = $details;
    }
}
class ApiErrorError extends UapiError {}
class AvatarNotFoundError extends UapiError {}
class ConversionFailedError extends UapiError {}
class FileOpenErrorError extends UapiError {}
class FileRequiredError extends UapiError {}
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


class Client {
    private Guzzle $http;
    function __construct(string $baseUrl, ?string $token = null) {
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $this->http = new Guzzle(['base_uri' => $baseUrl, 'headers' => $headers, 'http_errors' => false]);
    }
    private function request(string $method, string $path, array $query = [], $body = null) {
        $res = $this->http->request($method, $path, ['query'=>$query, 'json'=>$body]);
        $status = $res->getStatusCode();
        if ($status >= 400) {
            $json = json_decode((string)$res->getBody(), true) ?? [];
            $code = strtoupper($json['code'] ?? ($status==401?'UNAUTHORIZED':($status==404?'NOT_FOUND':($status==429?'SERVICE_BUSY':($status>=500?'INTERNAL_SERVER_ERROR':'API_ERROR')))));
            $msg = $json['message'] ?? $res->getReasonPhrase();
            $cls = $this->classByCode($code);
            throw new $cls($code, $status, $msg, $json['details'] ?? null);
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
            default => UapiError::class
        };
    }
    function clipzyZaiXianJianTieBan() { return new ClipzyZaiXianJianTieBanApi($this); }
    class ClipzyZaiXianJianTieBanApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getClipzyGet(array $args = []) { $path='/api/get'; return $this->c->request('GET', $path, $args); }
        function getClipzyRaw(array $args = []) { $path='/api/raw/{id}'; if (array_key_exists('id', $args)) $path = str_replace('{'.'id'.'}', strval($args['id']), $path); return $this->c->request('GET', $path, $args); }
        function postClipzyStore(array $args = []) { $path='/api/store'; return $this->c->request('POST', $path, $args); }
    }
    function convert() { return new ConvertApi($this); }
    class ConvertApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getConvertUnixtime(array $args = []) { $path='/convert/unixtime'; return $this->c->request('GET', $path, $args); }
        function postConvertJson(array $args = []) { $path='/convert/json'; return $this->c->request('POST', $path, $args); }
    }
    function daily() { return new DailyApi($this); }
    class DailyApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getDailyNewsImage(array $args = []) { $path='/daily/news-image'; return $this->c->request('GET', $path, $args); }
    }
    function game() { return new GameApi($this); }
    class GameApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getGameEpicFree(array $args = []) { $path='/game/epic-free'; return $this->c->request('GET', $path, $args); }
        function getGameMinecraftHistoryid(array $args = []) { $path='/game/minecraft/historyid'; return $this->c->request('GET', $path, $args); }
        function getGameMinecraftServerstatus(array $args = []) { $path='/game/minecraft/serverstatus'; return $this->c->request('GET', $path, $args); }
        function getGameMinecraftUserinfo(array $args = []) { $path='/game/minecraft/userinfo'; return $this->c->request('GET', $path, $args); }
        function getGameSteamSummary(array $args = []) { $path='/game/steam/summary'; return $this->c->request('GET', $path, $args); }
    }
    function image() { return new ImageApi($this); }
    class ImageApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getAvatarGravatar(array $args = []) { $path='/avatar/gravatar'; return $this->c->request('GET', $path, $args); }
        function getImageBingDaily(array $args = []) { $path='/image/bing-daily'; return $this->c->request('GET', $path, $args); }
        function getImageMotou(array $args = []) { $path='/image/motou'; return $this->c->request('GET', $path, $args); }
        function getImageQrcode(array $args = []) { $path='/image/qrcode'; return $this->c->request('GET', $path, $args); }
        function getImageTobase64(array $args = []) { $path='/image/tobase64'; return $this->c->request('GET', $path, $args); }
        function postImageCompress(array $args = []) { $path='/image/compress'; return $this->c->request('POST', $path, $args); }
        function postImageFrombase64(array $args = []) { $path='/image/frombase64'; return $this->c->request('POST', $path, $args); }
        function postImageMotou(array $args = []) { $path='/image/motou'; return $this->c->request('POST', $path, $args); }
        function postImageSpeechless(array $args = []) { $path='/image/speechless'; return $this->c->request('POST', $path, $args); }
        function postImageSvg(array $args = []) { $path='/image/svg'; return $this->c->request('POST', $path, $args); }
    }
    function misc() { return new MiscApi($this); }
    class MiscApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getHistoryProgrammer(array $args = []) { $path='/history/programmer'; return $this->c->request('GET', $path, $args); }
        function getHistoryProgrammerToday(array $args = []) { $path='/history/programmer/today'; return $this->c->request('GET', $path, $args); }
        function getMiscHotboard(array $args = []) { $path='/misc/hotboard'; return $this->c->request('GET', $path, $args); }
        function getMiscPhoneinfo(array $args = []) { $path='/misc/phoneinfo'; return $this->c->request('GET', $path, $args); }
        function getMiscRandomnumber(array $args = []) { $path='/misc/randomnumber'; return $this->c->request('GET', $path, $args); }
        function getMiscTimestamp(array $args = []) { $path='/misc/timestamp'; return $this->c->request('GET', $path, $args); }
        function getMiscTrackingCarriers(array $args = []) { $path='/misc/tracking/carriers'; return $this->c->request('GET', $path, $args); }
        function getMiscTrackingDetect(array $args = []) { $path='/misc/tracking/detect'; return $this->c->request('GET', $path, $args); }
        function getMiscTrackingQuery(array $args = []) { $path='/misc/tracking/query'; return $this->c->request('GET', $path, $args); }
        function getMiscWeather(array $args = []) { $path='/misc/weather'; return $this->c->request('GET', $path, $args); }
        function getMiscWorldtime(array $args = []) { $path='/misc/worldtime'; return $this->c->request('GET', $path, $args); }
    }
    function network() { return new NetworkApi($this); }
    class NetworkApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getNetworkDns(array $args = []) { $path='/network/dns'; return $this->c->request('GET', $path, $args); }
        function getNetworkIcp(array $args = []) { $path='/network/icp'; return $this->c->request('GET', $path, $args); }
        function getNetworkIpinfo(array $args = []) { $path='/network/ipinfo'; return $this->c->request('GET', $path, $args); }
        function getNetworkMyip(array $args = []) { $path='/network/myip'; return $this->c->request('GET', $path, $args); }
        function getNetworkPing(array $args = []) { $path='/network/ping'; return $this->c->request('GET', $path, $args); }
        function getNetworkPingmyip(array $args = []) { $path='/network/pingmyip'; return $this->c->request('GET', $path, $args); }
        function getNetworkPortscan(array $args = []) { $path='/network/portscan'; return $this->c->request('GET', $path, $args); }
        function getNetworkUrlstatus(array $args = []) { $path='/network/urlstatus'; return $this->c->request('GET', $path, $args); }
        function getNetworkWhois(array $args = []) { $path='/network/whois'; return $this->c->request('GET', $path, $args); }
        function getNetworkWxdomain(array $args = []) { $path='/network/wxdomain'; return $this->c->request('GET', $path, $args); }
    }
    function poem() { return new PoemApi($this); }
    class PoemApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getSaying(array $args = []) { $path='/saying'; return $this->c->request('GET', $path, $args); }
    }
    function random() { return new RandomApi($this); }
    class RandomApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getAnswerbookAsk(array $args = []) { $path='/answerbook/ask'; return $this->c->request('GET', $path, $args); }
        function getRandomImage(array $args = []) { $path='/random/image'; return $this->c->request('GET', $path, $args); }
        function getRandomString(array $args = []) { $path='/random/string'; return $this->c->request('GET', $path, $args); }
        function postAnswerbookAsk(array $args = []) { $path='/answerbook/ask'; return $this->c->request('POST', $path, $args); }
    }
    function social() { return new SocialApi($this); }
    class SocialApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getGithubRepo(array $args = []) { $path='/github/repo'; return $this->c->request('GET', $path, $args); }
        function getSocialBilibiliArchives(array $args = []) { $path='/social/bilibili/archives'; return $this->c->request('GET', $path, $args); }
        function getSocialBilibiliLiveroom(array $args = []) { $path='/social/bilibili/liveroom'; return $this->c->request('GET', $path, $args); }
        function getSocialBilibiliReplies(array $args = []) { $path='/social/bilibili/replies'; return $this->c->request('GET', $path, $args); }
        function getSocialBilibiliUserinfo(array $args = []) { $path='/social/bilibili/userinfo'; return $this->c->request('GET', $path, $args); }
        function getSocialBilibiliVideoinfo(array $args = []) { $path='/social/bilibili/videoinfo'; return $this->c->request('GET', $path, $args); }
        function getSocialQqGroupinfo(array $args = []) { $path='/social/qq/groupinfo'; return $this->c->request('GET', $path, $args); }
        function getSocialQqUserinfo(array $args = []) { $path='/social/qq/userinfo'; return $this->c->request('GET', $path, $args); }
    }
    function status() { return new StatusApi($this); }
    class StatusApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getStatusRatelimit(array $args = []) { $path='/status/ratelimit'; return $this->c->request('GET', $path, $args); }
        function getStatusUsage(array $args = []) { $path='/status/usage'; return $this->c->request('GET', $path, $args); }
    }
    function text() { return new TextApi($this); }
    class TextApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getTextMd5(array $args = []) { $path='/text/md5'; return $this->c->request('GET', $path, $args); }
        function postTextAesDecrypt(array $args = []) { $path='/text/aes/decrypt'; return $this->c->request('POST', $path, $args); }
        function postTextAesEncrypt(array $args = []) { $path='/text/aes/encrypt'; return $this->c->request('POST', $path, $args); }
        function postTextAnalyze(array $args = []) { $path='/text/analyze'; return $this->c->request('POST', $path, $args); }
        function postTextBase64Decode(array $args = []) { $path='/text/base64/decode'; return $this->c->request('POST', $path, $args); }
        function postTextBase64Encode(array $args = []) { $path='/text/base64/encode'; return $this->c->request('POST', $path, $args); }
        function postTextMd5(array $args = []) { $path='/text/md5'; return $this->c->request('POST', $path, $args); }
        function postTextMd5Verify(array $args = []) { $path='/text/md5/verify'; return $this->c->request('POST', $path, $args); }
    }
    function translate() { return new TranslateApi($this); }
    class TranslateApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getAiTranslateLanguages(array $args = []) { $path='/ai/translate/languages'; return $this->c->request('GET', $path, $args); }
        function postAiTranslate(array $args = []) { $path='/ai/translate'; return $this->c->request('POST', $path, $args); }
        function postTranslateText(array $args = []) { $path='/translate/text'; return $this->c->request('POST', $path, $args); }
    }
    function webparse() { return new WebparseApi($this); }
    class WebparseApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getWebTomarkdownAsyncStatus(array $args = []) { $path='/web/tomarkdown/async/{task_id}'; if (array_key_exists('task_id', $args)) $path = str_replace('{'.'task_id'.'}', strval($args['task_id']), $path); return $this->c->request('GET', $path, $args); }
        function getWebparseExtractimages(array $args = []) { $path='/webparse/extractimages'; return $this->c->request('GET', $path, $args); }
        function getWebparseMetadata(array $args = []) { $path='/webparse/metadata'; return $this->c->request('GET', $path, $args); }
        function postWebTomarkdownAsync(array $args = []) { $path='/web/tomarkdown/async'; return $this->c->request('POST', $path, $args); }
    }
    function minGanCiShiBie() { return new MinGanCiShiBieApi($this); }
    class MinGanCiShiBieApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getSensitiveWordAnalyzeQuery(array $args = []) { $path='/sensitive-word/analyze-query'; return $this->c->request('GET', $path, $args); }
        function postSensitiveWordAnalyze(array $args = []) { $path='/sensitive-word/analyze'; return $this->c->request('POST', $path, $args); }
        function postSensitiveWordQuickCheck(array $args = []) { $path='/text/profanitycheck'; return $this->c->request('POST', $path, $args); }
    }
    function zhiNengSouSuo() { return new ZhiNengSouSuoApi($this); }
    class ZhiNengSouSuoApi {
        private Client $c; function __construct(Client $c){ $this->c=$c; }
        function getSearchEngines(array $args = []) { $path='/search/engines'; return $this->c->request('GET', $path, $args); }
        function postSearchAggregate(array $args = []) { $path='/search/aggregate'; return $this->c->request('POST', $path, $args); }
    }
}
