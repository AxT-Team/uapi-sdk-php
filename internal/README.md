## uapi-sdk-php internal

这个目录保留的是 OpenAPI Generator 生成的原始参考文档，主要用来对照 operation、model 和生成器层面的类名。
如果你是想直接安装并使用 SDK，请优先查看仓库根目录的 `README.md`。

## 安装

```bash
composer require axt-team/uapi-sdk-php
```

## 最小示例

```php
<?php
require 'vendor/autoload.php';

$client = new Uapi\Client('https://uapis.cn', 'YOUR_API_KEY');
$result = $client->misc()->getMiscHotboard(['type' => 'weibo']);
var_dump($result);
```

## 说明

下面继续保留自动生成的 API / Model 索引，方便你按生成器原始命名检索。

## API Endpoints

All URIs are relative to *https://uapis.cn/api/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*DefaultApi* | [**getSearchEngines**](docs/Api/DefaultApi.md#getsearchengines) | **GET** /search/engines | 搜索引擎配置
*DefaultApi* | [**getSensitiveWordAnalyzeQuery**](docs/Api/DefaultApi.md#getsensitivewordanalyzequery) | **GET** /sensitive-word/analyze-query | 敏感词分析 (GET)
*DefaultApi* | [**postSearchAggregate**](docs/Api/DefaultApi.md#postsearchaggregate) | **POST** /search/aggregate | 智能搜索
*DefaultApi* | [**postSensitiveWordAnalyze**](docs/Api/DefaultApi.md#postsensitivewordanalyze) | **POST** /sensitive-word/analyze | 分析敏感词
*DefaultApi* | [**postSensitiveWordQuickCheck**](docs/Api/DefaultApi.md#postsensitivewordquickcheck) | **POST** /text/profanitycheck | 敏感词检测（快速）
*ClipzyApi* | [**getClipzyGet**](docs/Api/ClipzyApi.md#getclipzyget) | **GET** /api/get | 步骤2 (方法一): 获取加密数据
*ClipzyApi* | [**getClipzyRaw**](docs/Api/ClipzyApi.md#getclipzyraw) | **GET** /api/raw/{id} | 步骤2 (方法二): 获取原始文本
*ClipzyApi* | [**postClipzyStore**](docs/Api/ClipzyApi.md#postclipzystore) | **POST** /api/store | 步骤1：上传加密数据
*ConvertApi* | [**getConvertUnixtime**](docs/Api/ConvertApi.md#getconvertunixtime) | **GET** /convert/unixtime | 时间戳转换
*ConvertApi* | [**postConvertJson**](docs/Api/ConvertApi.md#postconvertjson) | **POST** /convert/json | JSON 格式化
*DailyApi* | [**getDailyNewsImage**](docs/Api/DailyApi.md#getdailynewsimage) | **GET** /daily/news-image | 每日新闻图
*GameApi* | [**getGameEpicFree**](docs/Api/GameApi.md#getgameepicfree) | **GET** /game/epic-free | Epic 免费游戏
*GameApi* | [**getGameMinecraftHistoryid**](docs/Api/GameApi.md#getgameminecrafthistoryid) | **GET** /game/minecraft/historyid | 查询 MC 曾用名
*GameApi* | [**getGameMinecraftServerstatus**](docs/Api/GameApi.md#getgameminecraftserverstatus) | **GET** /game/minecraft/serverstatus | 查询 MC 服务器
*GameApi* | [**getGameMinecraftUserinfo**](docs/Api/GameApi.md#getgameminecraftuserinfo) | **GET** /game/minecraft/userinfo | 查询 MC 玩家
*GameApi* | [**getGameSteamSummary**](docs/Api/GameApi.md#getgamesteamsummary) | **GET** /game/steam/summary | 查询 Steam 用户
*ImageApi* | [**getAvatarGravatar**](docs/Api/ImageApi.md#getavatargravatar) | **GET** /avatar/gravatar | 获取Gravatar头像
*ImageApi* | [**getImageBingDaily**](docs/Api/ImageApi.md#getimagebingdaily) | **GET** /image/bing-daily | 必应壁纸
*ImageApi* | [**getImageMotou**](docs/Api/ImageApi.md#getimagemotou) | **GET** /image/motou | 生成摸摸头GIF (QQ号)
*ImageApi* | [**getImageQrcode**](docs/Api/ImageApi.md#getimageqrcode) | **GET** /image/qrcode | 生成二维码
*ImageApi* | [**getImageTobase64**](docs/Api/ImageApi.md#getimagetobase64) | **GET** /image/tobase64 | 图片转 Base64
*ImageApi* | [**postImageCompress**](docs/Api/ImageApi.md#postimagecompress) | **POST** /image/compress | 无损压缩图片
*ImageApi* | [**postImageFrombase64**](docs/Api/ImageApi.md#postimagefrombase64) | **POST** /image/frombase64 | 通过Base64编码上传图片
*ImageApi* | [**postImageMotou**](docs/Api/ImageApi.md#postimagemotou) | **POST** /image/motou | 生成摸摸头GIF
*ImageApi* | [**postImageNsfw**](docs/Api/ImageApi.md#postimagensfw) | **POST** /image/nsfw | 图片敏感检测
*ImageApi* | [**postImageSpeechless**](docs/Api/ImageApi.md#postimagespeechless) | **POST** /image/speechless | 生成你们怎么不说话了表情包
*ImageApi* | [**postImageSvg**](docs/Api/ImageApi.md#postimagesvg) | **POST** /image/svg | SVG转图片
*MiscApi* | [**getHistoryProgrammer**](docs/Api/MiscApi.md#gethistoryprogrammer) | **GET** /history/programmer | 程序员历史事件
*MiscApi* | [**getHistoryProgrammerToday**](docs/Api/MiscApi.md#gethistoryprogrammertoday) | **GET** /history/programmer/today | 程序员历史上的今天
*MiscApi* | [**getMiscDistrict**](docs/Api/MiscApi.md#getmiscdistrict) | **GET** /misc/district | Adcode 国内外行政区域查询
*MiscApi* | [**getMiscHolidayCalendar**](docs/Api/MiscApi.md#getmischolidaycalendar) | **GET** /misc/holiday-calendar | 查询节假日与万年历
*MiscApi* | [**getMiscHotboard**](docs/Api/MiscApi.md#getmischotboard) | **GET** /misc/hotboard | 查询热榜
*MiscApi* | [**getMiscLunartime**](docs/Api/MiscApi.md#getmisclunartime) | **GET** /misc/lunartime | 查询农历时间
*MiscApi* | [**getMiscPhoneinfo**](docs/Api/MiscApi.md#getmiscphoneinfo) | **GET** /misc/phoneinfo | 查询手机归属地
*MiscApi* | [**getMiscRandomnumber**](docs/Api/MiscApi.md#getmiscrandomnumber) | **GET** /misc/randomnumber | 随机数生成
*MiscApi* | [**getMiscTimestamp**](docs/Api/MiscApi.md#getmisctimestamp) | **GET** /misc/timestamp | 转换时间戳 (旧版，推荐使用/convert/unixtime)
*MiscApi* | [**getMiscTrackingCarriers**](docs/Api/MiscApi.md#getmisctrackingcarriers) | **GET** /misc/tracking/carriers | 获取支持的快递公司列表
*MiscApi* | [**getMiscTrackingDetect**](docs/Api/MiscApi.md#getmisctrackingdetect) | **GET** /misc/tracking/detect | 识别快递公司
*MiscApi* | [**getMiscTrackingQuery**](docs/Api/MiscApi.md#getmisctrackingquery) | **GET** /misc/tracking/query | 查询快递物流信息
*MiscApi* | [**getMiscWeather**](docs/Api/MiscApi.md#getmiscweather) | **GET** /misc/weather | 查询天气
*MiscApi* | [**getMiscWorldtime**](docs/Api/MiscApi.md#getmiscworldtime) | **GET** /misc/worldtime | 查询世界时间
*MiscApi* | [**postMiscDateDiff**](docs/Api/MiscApi.md#postmiscdatediff) | **POST** /misc/date-diff | 计算两个日期之间的时间差值
*NetworkApi* | [**getNetworkDns**](docs/Api/NetworkApi.md#getnetworkdns) | **GET** /network/dns | 执行DNS解析查询
*NetworkApi* | [**getNetworkIcp**](docs/Api/NetworkApi.md#getnetworkicp) | **GET** /network/icp | 查询域名ICP备案信息
*NetworkApi* | [**getNetworkIpinfo**](docs/Api/NetworkApi.md#getnetworkipinfo) | **GET** /network/ipinfo | 查询 IP
*NetworkApi* | [**getNetworkMyip**](docs/Api/NetworkApi.md#getnetworkmyip) | **GET** /network/myip | 查询我的 IP
*NetworkApi* | [**getNetworkPing**](docs/Api/NetworkApi.md#getnetworkping) | **GET** /network/ping | Ping 主机
*NetworkApi* | [**getNetworkPingmyip**](docs/Api/NetworkApi.md#getnetworkpingmyip) | **GET** /network/pingmyip | Ping 我的 IP
*NetworkApi* | [**getNetworkPortscan**](docs/Api/NetworkApi.md#getnetworkportscan) | **GET** /network/portscan | 端口扫描
*NetworkApi* | [**getNetworkUrlstatus**](docs/Api/NetworkApi.md#getnetworkurlstatus) | **GET** /network/urlstatus | 检查URL的可访问性状态
*NetworkApi* | [**getNetworkWhois**](docs/Api/NetworkApi.md#getnetworkwhois) | **GET** /network/whois | 查询域名的WHOIS注册信息
*NetworkApi* | [**getNetworkWxdomain**](docs/Api/NetworkApi.md#getnetworkwxdomain) | **GET** /network/wxdomain | 检查域名在微信中的访问状态
*PoemApi* | [**getSaying**](docs/Api/PoemApi.md#getsaying) | **GET** /saying | 一言
*RandomApi* | [**getAnswerbookAsk**](docs/Api/RandomApi.md#getanswerbookask) | **GET** /answerbook/ask | 答案之书
*RandomApi* | [**getRandomImage**](docs/Api/RandomApi.md#getrandomimage) | **GET** /random/image | 随机图片
*RandomApi* | [**getRandomString**](docs/Api/RandomApi.md#getrandomstring) | **GET** /random/string | 随机字符串
*RandomApi* | [**postAnswerbookAsk**](docs/Api/RandomApi.md#postanswerbookask) | **POST** /answerbook/ask | 答案之书 (POST)
*SocialApi* | [**getGithubRepo**](docs/Api/SocialApi.md#getgithubrepo) | **GET** /github/repo | 查询 GitHub 仓库
*SocialApi* | [**getSocialBilibiliArchives**](docs/Api/SocialApi.md#getsocialbilibiliarchives) | **GET** /social/bilibili/archives | 查询 B站投稿
*SocialApi* | [**getSocialBilibiliLiveroom**](docs/Api/SocialApi.md#getsocialbilibililiveroom) | **GET** /social/bilibili/liveroom | 查询 B站直播间
*SocialApi* | [**getSocialBilibiliReplies**](docs/Api/SocialApi.md#getsocialbilibilireplies) | **GET** /social/bilibili/replies | 查询 B站评论
*SocialApi* | [**getSocialBilibiliUserinfo**](docs/Api/SocialApi.md#getsocialbilibiliuserinfo) | **GET** /social/bilibili/userinfo | 查询 B站用户
*SocialApi* | [**getSocialBilibiliVideoinfo**](docs/Api/SocialApi.md#getsocialbilibilivideoinfo) | **GET** /social/bilibili/videoinfo | 查询 B站视频
*SocialApi* | [**getSocialQqGroupinfo**](docs/Api/SocialApi.md#getsocialqqgroupinfo) | **GET** /social/qq/groupinfo | 查询 QQ 群信息
*SocialApi* | [**getSocialQqUserinfo**](docs/Api/SocialApi.md#getsocialqquserinfo) | **GET** /social/qq/userinfo | 查询 QQ 信息
*StatusApi* | [**getStatusRatelimit**](docs/Api/StatusApi.md#getstatusratelimit) | **GET** /status/ratelimit | 限流状态
*StatusApi* | [**getStatusUsage**](docs/Api/StatusApi.md#getstatususage) | **GET** /status/usage | 获取API端点使用统计
*TextApi* | [**getTextMd5**](docs/Api/TextApi.md#gettextmd5) | **GET** /text/md5 | MD5 哈希
*TextApi* | [**postTextAesDecrypt**](docs/Api/TextApi.md#posttextaesdecrypt) | **POST** /text/aes/decrypt | AES 解密
*TextApi* | [**postTextAesDecryptAdvanced**](docs/Api/TextApi.md#posttextaesdecryptadvanced) | **POST** /text/aes/decrypt-advanced | AES高级解密
*TextApi* | [**postTextAesEncrypt**](docs/Api/TextApi.md#posttextaesencrypt) | **POST** /text/aes/encrypt | AES 加密
*TextApi* | [**postTextAesEncryptAdvanced**](docs/Api/TextApi.md#posttextaesencryptadvanced) | **POST** /text/aes/encrypt-advanced | AES高级加密
*TextApi* | [**postTextAnalyze**](docs/Api/TextApi.md#posttextanalyze) | **POST** /text/analyze | 文本分析
*TextApi* | [**postTextBase64Decode**](docs/Api/TextApi.md#posttextbase64decode) | **POST** /text/base64/decode | Base64 解码
*TextApi* | [**postTextBase64Encode**](docs/Api/TextApi.md#posttextbase64encode) | **POST** /text/base64/encode | Base64 编码
*TextApi* | [**postTextConvert**](docs/Api/TextApi.md#posttextconvert) | **POST** /text/convert | 格式转换
*TextApi* | [**postTextMd5**](docs/Api/TextApi.md#posttextmd5) | **POST** /text/md5 | MD5 哈希 (POST)
*TextApi* | [**postTextMd5Verify**](docs/Api/TextApi.md#posttextmd5verify) | **POST** /text/md5/verify | MD5 校验
*TranslateApi* | [**getAiTranslateLanguages**](docs/Api/TranslateApi.md#getaitranslatelanguages) | **GET** /ai/translate/languages | AI翻译配置
*TranslateApi* | [**postAiTranslate**](docs/Api/TranslateApi.md#postaitranslate) | **POST** /ai/translate | AI智能翻译
*TranslateApi* | [**postTranslateStream**](docs/Api/TranslateApi.md#posttranslatestream) | **POST** /translate/stream | 流式翻译（中英互译）
*TranslateApi* | [**postTranslateText**](docs/Api/TranslateApi.md#posttranslatetext) | **POST** /translate/text | 翻译
*WebParseApi* | [**getWebTomarkdownAsyncStatus**](docs/Api/WebParseApi.md#getwebtomarkdownasyncstatus) | **GET** /web/tomarkdown/async/{task_id} | 转换任务状态
*WebParseApi* | [**getWebparseExtractimages**](docs/Api/WebParseApi.md#getwebparseextractimages) | **GET** /webparse/extractimages | 提取网页图片
*WebParseApi* | [**getWebparseMetadata**](docs/Api/WebParseApi.md#getwebparsemetadata) | **GET** /webparse/metadata | 提取网页元数据
*WebParseApi* | [**postWebTomarkdownAsync**](docs/Api/WebParseApi.md#postwebtomarkdownasync) | **POST** /web/tomarkdown/async | 网页转 Markdown

## Models

- [GetAiTranslateLanguages200Response](docs/Model/GetAiTranslateLanguages200Response.md)
- [GetAiTranslateLanguages200ResponseData](docs/Model/GetAiTranslateLanguages200ResponseData.md)
- [GetAiTranslateLanguages200ResponseDataContextsInner](docs/Model/GetAiTranslateLanguages200ResponseDataContextsInner.md)
- [GetAiTranslateLanguages200ResponseDataLanguagesInner](docs/Model/GetAiTranslateLanguages200ResponseDataLanguagesInner.md)
- [GetAiTranslateLanguages200ResponseDataStylesInner](docs/Model/GetAiTranslateLanguages200ResponseDataStylesInner.md)
- [GetAiTranslateLanguages200ResponsePerformance](docs/Model/GetAiTranslateLanguages200ResponsePerformance.md)
- [GetAnswerbookAsk200Response](docs/Model/GetAnswerbookAsk200Response.md)
- [GetAnswerbookAsk400Response](docs/Model/GetAnswerbookAsk400Response.md)
- [GetAnswerbookAsk500Response](docs/Model/GetAnswerbookAsk500Response.md)
- [GetAvatarGravatar400Response](docs/Model/GetAvatarGravatar400Response.md)
- [GetAvatarGravatar404Response](docs/Model/GetAvatarGravatar404Response.md)
- [GetClipzyGet200Response](docs/Model/GetClipzyGet200Response.md)
- [GetClipzyGet400Response](docs/Model/GetClipzyGet400Response.md)
- [GetClipzyGet404Response](docs/Model/GetClipzyGet404Response.md)
- [GetClipzyRaw400Response](docs/Model/GetClipzyRaw400Response.md)
- [GetClipzyRaw403Response](docs/Model/GetClipzyRaw403Response.md)
- [GetConvertUnixtime200Response](docs/Model/GetConvertUnixtime200Response.md)
- [GetConvertUnixtime400Response](docs/Model/GetConvertUnixtime400Response.md)
- [GetDailyNewsImage500Response](docs/Model/GetDailyNewsImage500Response.md)
- [GetDailyNewsImage502Response](docs/Model/GetDailyNewsImage502Response.md)
- [GetGameEpicFree200Response](docs/Model/GetGameEpicFree200Response.md)
- [GetGameEpicFree200ResponseDataInner](docs/Model/GetGameEpicFree200ResponseDataInner.md)
- [GetGameEpicFree500Response](docs/Model/GetGameEpicFree500Response.md)
- [GetGameMinecraftHistoryid200Response](docs/Model/GetGameMinecraftHistoryid200Response.md)
- [GetGameMinecraftHistoryid200ResponseHistoryInner](docs/Model/GetGameMinecraftHistoryid200ResponseHistoryInner.md)
- [GetGameMinecraftHistoryid200ResponseResultsInner](docs/Model/GetGameMinecraftHistoryid200ResponseResultsInner.md)
- [GetGameMinecraftHistoryid200ResponseResultsInnerHistoryInner](docs/Model/GetGameMinecraftHistoryid200ResponseResultsInnerHistoryInner.md)
- [GetGameMinecraftHistoryid400Response](docs/Model/GetGameMinecraftHistoryid400Response.md)
- [GetGameMinecraftHistoryid404Response](docs/Model/GetGameMinecraftHistoryid404Response.md)
- [GetGameMinecraftHistoryid502Response](docs/Model/GetGameMinecraftHistoryid502Response.md)
- [GetGameMinecraftServerstatus200Response](docs/Model/GetGameMinecraftServerstatus200Response.md)
- [GetGameMinecraftServerstatus400Response](docs/Model/GetGameMinecraftServerstatus400Response.md)
- [GetGameMinecraftServerstatus404Response](docs/Model/GetGameMinecraftServerstatus404Response.md)
- [GetGameMinecraftServerstatus502Response](docs/Model/GetGameMinecraftServerstatus502Response.md)
- [GetGameMinecraftUserinfo200Response](docs/Model/GetGameMinecraftUserinfo200Response.md)
- [GetGameMinecraftUserinfo400Response](docs/Model/GetGameMinecraftUserinfo400Response.md)
- [GetGameMinecraftUserinfo404Response](docs/Model/GetGameMinecraftUserinfo404Response.md)
- [GetGameMinecraftUserinfo502Response](docs/Model/GetGameMinecraftUserinfo502Response.md)
- [GetGameSteamSummary200Response](docs/Model/GetGameSteamSummary200Response.md)
- [GetGameSteamSummary400Response](docs/Model/GetGameSteamSummary400Response.md)
- [GetGameSteamSummary401Response](docs/Model/GetGameSteamSummary401Response.md)
- [GetGameSteamSummary404Response](docs/Model/GetGameSteamSummary404Response.md)
- [GetGameSteamSummary502Response](docs/Model/GetGameSteamSummary502Response.md)
- [GetGithubRepo200Response](docs/Model/GetGithubRepo200Response.md)
- [GetGithubRepo200ResponseCollaboratorsInner](docs/Model/GetGithubRepo200ResponseCollaboratorsInner.md)
- [GetGithubRepo200ResponseLatestRelease](docs/Model/GetGithubRepo200ResponseLatestRelease.md)
- [GetGithubRepo400Response](docs/Model/GetGithubRepo400Response.md)
- [GetGithubRepo502Response](docs/Model/GetGithubRepo502Response.md)
- [GetHistoryProgrammer200Response](docs/Model/GetHistoryProgrammer200Response.md)
- [GetHistoryProgrammer200ResponseEventsInner](docs/Model/GetHistoryProgrammer200ResponseEventsInner.md)
- [GetHistoryProgrammer400Response](docs/Model/GetHistoryProgrammer400Response.md)
- [GetHistoryProgrammerToday200Response](docs/Model/GetHistoryProgrammerToday200Response.md)
- [GetHistoryProgrammerToday200ResponseEventsInner](docs/Model/GetHistoryProgrammerToday200ResponseEventsInner.md)
- [GetHistoryProgrammerToday500Response](docs/Model/GetHistoryProgrammerToday500Response.md)
- [GetImageBingDaily502Response](docs/Model/GetImageBingDaily502Response.md)
- [GetImageMotou400Response](docs/Model/GetImageMotou400Response.md)
- [GetImageMotou500Response](docs/Model/GetImageMotou500Response.md)
- [GetImageQrcode200Response](docs/Model/GetImageQrcode200Response.md)
- [GetImageQrcode400Response](docs/Model/GetImageQrcode400Response.md)
- [GetImageQrcode500Response](docs/Model/GetImageQrcode500Response.md)
- [GetImageTobase64200Response](docs/Model/GetImageTobase64200Response.md)
- [GetImageTobase64400Response](docs/Model/GetImageTobase64400Response.md)
- [GetImageTobase64502Response](docs/Model/GetImageTobase64502Response.md)
- [GetMiscDistrict200Response](docs/Model/GetMiscDistrict200Response.md)
- [GetMiscDistrict200ResponseResultsInner](docs/Model/GetMiscDistrict200ResponseResultsInner.md)
- [GetMiscDistrict200ResponseResultsInnerCenter](docs/Model/GetMiscDistrict200ResponseResultsInnerCenter.md)
- [GetMiscDistrict400Response](docs/Model/GetMiscDistrict400Response.md)
- [GetMiscHolidayCalendar200Response](docs/Model/GetMiscHolidayCalendar200Response.md)
- [GetMiscHolidayCalendar200ResponseDaysInner](docs/Model/GetMiscHolidayCalendar200ResponseDaysInner.md)
- [GetMiscHolidayCalendar200ResponseHolidaysInner](docs/Model/GetMiscHolidayCalendar200ResponseHolidaysInner.md)
- [GetMiscHolidayCalendar200ResponseNearby](docs/Model/GetMiscHolidayCalendar200ResponseNearby.md)
- [GetMiscHolidayCalendar200ResponseNearbyNextInner](docs/Model/GetMiscHolidayCalendar200ResponseNearbyNextInner.md)
- [GetMiscHolidayCalendar200ResponseNearbyNextInnerEventsInner](docs/Model/GetMiscHolidayCalendar200ResponseNearbyNextInnerEventsInner.md)
- [GetMiscHolidayCalendar200ResponseNearbyPreviousInner](docs/Model/GetMiscHolidayCalendar200ResponseNearbyPreviousInner.md)
- [GetMiscHolidayCalendar200ResponseNearbyPreviousInnerEventsInner](docs/Model/GetMiscHolidayCalendar200ResponseNearbyPreviousInnerEventsInner.md)
- [GetMiscHolidayCalendar200ResponseQuery](docs/Model/GetMiscHolidayCalendar200ResponseQuery.md)
- [GetMiscHolidayCalendar200ResponseSummary](docs/Model/GetMiscHolidayCalendar200ResponseSummary.md)
- [GetMiscHolidayCalendar400Response](docs/Model/GetMiscHolidayCalendar400Response.md)
- [GetMiscHotboard200Response](docs/Model/GetMiscHotboard200Response.md)
- [GetMiscHotboard200ResponseOneOf](docs/Model/GetMiscHotboard200ResponseOneOf.md)
- [GetMiscHotboard200ResponseOneOf1](docs/Model/GetMiscHotboard200ResponseOneOf1.md)
- [GetMiscHotboard200ResponseOneOf1ResultsInner](docs/Model/GetMiscHotboard200ResponseOneOf1ResultsInner.md)
- [GetMiscHotboard200ResponseOneOf2](docs/Model/GetMiscHotboard200ResponseOneOf2.md)
- [GetMiscHotboard200ResponseOneOfListInner](docs/Model/GetMiscHotboard200ResponseOneOfListInner.md)
- [GetMiscHotboard400Response](docs/Model/GetMiscHotboard400Response.md)
- [GetMiscHotboard500Response](docs/Model/GetMiscHotboard500Response.md)
- [GetMiscHotboard502Response](docs/Model/GetMiscHotboard502Response.md)
- [GetMiscLunartime200Response](docs/Model/GetMiscLunartime200Response.md)
- [GetMiscLunartime400Response](docs/Model/GetMiscLunartime400Response.md)
- [GetMiscPhoneinfo200Response](docs/Model/GetMiscPhoneinfo200Response.md)
- [GetMiscPhoneinfo400Response](docs/Model/GetMiscPhoneinfo400Response.md)
- [GetMiscPhoneinfo500Response](docs/Model/GetMiscPhoneinfo500Response.md)
- [GetMiscRandomnumber200Response](docs/Model/GetMiscRandomnumber200Response.md)
- [GetMiscRandomnumber400Response](docs/Model/GetMiscRandomnumber400Response.md)
- [GetMiscTimestamp200Response](docs/Model/GetMiscTimestamp200Response.md)
- [GetMiscTimestamp400Response](docs/Model/GetMiscTimestamp400Response.md)
- [GetMiscTrackingCarriers200Response](docs/Model/GetMiscTrackingCarriers200Response.md)
- [GetMiscTrackingCarriers200ResponseCarriersInner](docs/Model/GetMiscTrackingCarriers200ResponseCarriersInner.md)
- [GetMiscTrackingDetect200Response](docs/Model/GetMiscTrackingDetect200Response.md)
- [GetMiscTrackingDetect200ResponseAlternativesInner](docs/Model/GetMiscTrackingDetect200ResponseAlternativesInner.md)
- [GetMiscTrackingDetect404Response](docs/Model/GetMiscTrackingDetect404Response.md)
- [GetMiscTrackingQuery200Response](docs/Model/GetMiscTrackingQuery200Response.md)
- [GetMiscTrackingQuery200ResponseTracksInner](docs/Model/GetMiscTrackingQuery200ResponseTracksInner.md)
- [GetMiscTrackingQuery400Response](docs/Model/GetMiscTrackingQuery400Response.md)
- [GetMiscTrackingQuery404Response](docs/Model/GetMiscTrackingQuery404Response.md)
- [GetMiscWeather200Response](docs/Model/GetMiscWeather200Response.md)
- [GetMiscWeather200ResponseAirPollutants](docs/Model/GetMiscWeather200ResponseAirPollutants.md)
- [GetMiscWeather200ResponseForecastInner](docs/Model/GetMiscWeather200ResponseForecastInner.md)
- [GetMiscWeather200ResponseHourlyForecastInner](docs/Model/GetMiscWeather200ResponseHourlyForecastInner.md)
- [GetMiscWeather200ResponseLifeIndices](docs/Model/GetMiscWeather200ResponseLifeIndices.md)
- [GetMiscWeather200ResponseLifeIndicesAirConditioner](docs/Model/GetMiscWeather200ResponseLifeIndicesAirConditioner.md)
- [GetMiscWeather200ResponseLifeIndicesAirPurifier](docs/Model/GetMiscWeather200ResponseLifeIndicesAirPurifier.md)
- [GetMiscWeather200ResponseLifeIndicesAllergy](docs/Model/GetMiscWeather200ResponseLifeIndicesAllergy.md)
- [GetMiscWeather200ResponseLifeIndicesBeer](docs/Model/GetMiscWeather200ResponseLifeIndicesBeer.md)
- [GetMiscWeather200ResponseLifeIndicesCarWash](docs/Model/GetMiscWeather200ResponseLifeIndicesCarWash.md)
- [GetMiscWeather200ResponseLifeIndicesClothing](docs/Model/GetMiscWeather200ResponseLifeIndicesClothing.md)
- [GetMiscWeather200ResponseLifeIndicesColdRisk](docs/Model/GetMiscWeather200ResponseLifeIndicesColdRisk.md)
- [GetMiscWeather200ResponseLifeIndicesComfort](docs/Model/GetMiscWeather200ResponseLifeIndicesComfort.md)
- [GetMiscWeather200ResponseLifeIndicesDrying](docs/Model/GetMiscWeather200ResponseLifeIndicesDrying.md)
- [GetMiscWeather200ResponseLifeIndicesExercise](docs/Model/GetMiscWeather200ResponseLifeIndicesExercise.md)
- [GetMiscWeather200ResponseLifeIndicesFishing](docs/Model/GetMiscWeather200ResponseLifeIndicesFishing.md)
- [GetMiscWeather200ResponseLifeIndicesMood](docs/Model/GetMiscWeather200ResponseLifeIndicesMood.md)
- [GetMiscWeather200ResponseLifeIndicesPollen](docs/Model/GetMiscWeather200ResponseLifeIndicesPollen.md)
- [GetMiscWeather200ResponseLifeIndicesSunscreen](docs/Model/GetMiscWeather200ResponseLifeIndicesSunscreen.md)
- [GetMiscWeather200ResponseLifeIndicesTraffic](docs/Model/GetMiscWeather200ResponseLifeIndicesTraffic.md)
- [GetMiscWeather200ResponseLifeIndicesTravel](docs/Model/GetMiscWeather200ResponseLifeIndicesTravel.md)
- [GetMiscWeather200ResponseLifeIndicesUmbrella](docs/Model/GetMiscWeather200ResponseLifeIndicesUmbrella.md)
- [GetMiscWeather200ResponseLifeIndicesUv](docs/Model/GetMiscWeather200ResponseLifeIndicesUv.md)
- [GetMiscWeather200ResponseMinutelyPrecip](docs/Model/GetMiscWeather200ResponseMinutelyPrecip.md)
- [GetMiscWeather200ResponseMinutelyPrecipDataInner](docs/Model/GetMiscWeather200ResponseMinutelyPrecipDataInner.md)
- [GetMiscWeather400Response](docs/Model/GetMiscWeather400Response.md)
- [GetMiscWeather404Response](docs/Model/GetMiscWeather404Response.md)
- [GetMiscWeather500Response](docs/Model/GetMiscWeather500Response.md)
- [GetMiscWeather503Response](docs/Model/GetMiscWeather503Response.md)
- [GetMiscWorldtime200Response](docs/Model/GetMiscWorldtime200Response.md)
- [GetMiscWorldtime400Response](docs/Model/GetMiscWorldtime400Response.md)
- [GetMiscWorldtime404Response](docs/Model/GetMiscWorldtime404Response.md)
- [GetNetworkDns200Response](docs/Model/GetNetworkDns200Response.md)
- [GetNetworkDns200ResponseRecordsInner](docs/Model/GetNetworkDns200ResponseRecordsInner.md)
- [GetNetworkDns400Response](docs/Model/GetNetworkDns400Response.md)
- [GetNetworkDns404Response](docs/Model/GetNetworkDns404Response.md)
- [GetNetworkIcp200Response](docs/Model/GetNetworkIcp200Response.md)
- [GetNetworkIcp404Response](docs/Model/GetNetworkIcp404Response.md)
- [GetNetworkIpinfo200Response](docs/Model/GetNetworkIpinfo200Response.md)
- [GetNetworkIpinfo400Response](docs/Model/GetNetworkIpinfo400Response.md)
- [GetNetworkIpinfo404Response](docs/Model/GetNetworkIpinfo404Response.md)
- [GetNetworkIpinfo500Response](docs/Model/GetNetworkIpinfo500Response.md)
- [GetNetworkMyip200Response](docs/Model/GetNetworkMyip200Response.md)
- [GetNetworkMyip400Response](docs/Model/GetNetworkMyip400Response.md)
- [GetNetworkMyip500Response](docs/Model/GetNetworkMyip500Response.md)
- [GetNetworkPing200Response](docs/Model/GetNetworkPing200Response.md)
- [GetNetworkPing400Response](docs/Model/GetNetworkPing400Response.md)
- [GetNetworkPing429Response](docs/Model/GetNetworkPing429Response.md)
- [GetNetworkPingmyip200Response](docs/Model/GetNetworkPingmyip200Response.md)
- [GetNetworkPingmyip404Response](docs/Model/GetNetworkPingmyip404Response.md)
- [GetNetworkPortscan200Response](docs/Model/GetNetworkPortscan200Response.md)
- [GetNetworkPortscan400Response](docs/Model/GetNetworkPortscan400Response.md)
- [GetNetworkPortscan500Response](docs/Model/GetNetworkPortscan500Response.md)
- [GetNetworkUrlstatus200Response](docs/Model/GetNetworkUrlstatus200Response.md)
- [GetNetworkUrlstatus200ResponseOneOf](docs/Model/GetNetworkUrlstatus200ResponseOneOf.md)
- [GetNetworkUrlstatus200ResponseOneOf1](docs/Model/GetNetworkUrlstatus200ResponseOneOf1.md)
- [GetNetworkUrlstatus502Response](docs/Model/GetNetworkUrlstatus502Response.md)
- [GetNetworkWhois200Response](docs/Model/GetNetworkWhois200Response.md)
- [GetNetworkWhois200ResponseOneOf](docs/Model/GetNetworkWhois200ResponseOneOf.md)
- [GetNetworkWhois200ResponseOneOf1](docs/Model/GetNetworkWhois200ResponseOneOf1.md)
- [GetNetworkWhois404Response](docs/Model/GetNetworkWhois404Response.md)
- [GetNetworkWxdomain200Response](docs/Model/GetNetworkWxdomain200Response.md)
- [GetNetworkWxdomain502Response](docs/Model/GetNetworkWxdomain502Response.md)
- [GetRandomImage404Response](docs/Model/GetRandomImage404Response.md)
- [GetRandomImage500Response](docs/Model/GetRandomImage500Response.md)
- [GetRandomString200Response](docs/Model/GetRandomString200Response.md)
- [GetRandomString400Response](docs/Model/GetRandomString400Response.md)
- [GetRandomString500Response](docs/Model/GetRandomString500Response.md)
- [GetSaying200Response](docs/Model/GetSaying200Response.md)
- [GetSaying500Response](docs/Model/GetSaying500Response.md)
- [GetSearchEngines200Response](docs/Model/GetSearchEngines200Response.md)
- [GetSearchEngines200ResponseEngine](docs/Model/GetSearchEngines200ResponseEngine.md)
- [GetSearchEngines200ResponseLimits](docs/Model/GetSearchEngines200ResponseLimits.md)
- [GetSensitiveWordAnalyzeQuery400Response](docs/Model/GetSensitiveWordAnalyzeQuery400Response.md)
- [GetSocialBilibiliArchives200Response](docs/Model/GetSocialBilibiliArchives200Response.md)
- [GetSocialBilibiliArchives200ResponseVideosInner](docs/Model/GetSocialBilibiliArchives200ResponseVideosInner.md)
- [GetSocialBilibiliArchives400Response](docs/Model/GetSocialBilibiliArchives400Response.md)
- [GetSocialBilibiliArchives404Response](docs/Model/GetSocialBilibiliArchives404Response.md)
- [GetSocialBilibiliArchives500Response](docs/Model/GetSocialBilibiliArchives500Response.md)
- [GetSocialBilibiliLiveroom200Response](docs/Model/GetSocialBilibiliLiveroom200Response.md)
- [GetSocialBilibiliLiveroom200ResponseNewPendants](docs/Model/GetSocialBilibiliLiveroom200ResponseNewPendants.md)
- [GetSocialBilibiliLiveroom200ResponseNewPendantsBadge](docs/Model/GetSocialBilibiliLiveroom200ResponseNewPendantsBadge.md)
- [GetSocialBilibiliLiveroom200ResponseNewPendantsFrame](docs/Model/GetSocialBilibiliLiveroom200ResponseNewPendantsFrame.md)
- [GetSocialBilibiliReplies200Response](docs/Model/GetSocialBilibiliReplies200Response.md)
- [GetSocialBilibiliReplies200ResponsePage](docs/Model/GetSocialBilibiliReplies200ResponsePage.md)
- [GetSocialBilibiliReplies200ResponseRepliesInner](docs/Model/GetSocialBilibiliReplies200ResponseRepliesInner.md)
- [GetSocialBilibiliReplies200ResponseRepliesInnerContent](docs/Model/GetSocialBilibiliReplies200ResponseRepliesInnerContent.md)
- [GetSocialBilibiliReplies200ResponseRepliesInnerMember](docs/Model/GetSocialBilibiliReplies200ResponseRepliesInnerMember.md)
- [GetSocialBilibiliReplies200ResponseRepliesInnerMemberLevelInfo](docs/Model/GetSocialBilibiliReplies200ResponseRepliesInnerMemberLevelInfo.md)
- [GetSocialBilibiliUserinfo200Response](docs/Model/GetSocialBilibiliUserinfo200Response.md)
- [GetSocialBilibiliUserinfo400Response](docs/Model/GetSocialBilibiliUserinfo400Response.md)
- [GetSocialBilibiliUserinfo404Response](docs/Model/GetSocialBilibiliUserinfo404Response.md)
- [GetSocialBilibiliUserinfo502Response](docs/Model/GetSocialBilibiliUserinfo502Response.md)
- [GetSocialBilibiliVideoinfo200Response](docs/Model/GetSocialBilibiliVideoinfo200Response.md)
- [GetSocialBilibiliVideoinfo200ResponseDescV2Inner](docs/Model/GetSocialBilibiliVideoinfo200ResponseDescV2Inner.md)
- [GetSocialBilibiliVideoinfo200ResponseDimension](docs/Model/GetSocialBilibiliVideoinfo200ResponseDimension.md)
- [GetSocialBilibiliVideoinfo200ResponseHonorReply](docs/Model/GetSocialBilibiliVideoinfo200ResponseHonorReply.md)
- [GetSocialBilibiliVideoinfo200ResponseHonorReplyHonorInner](docs/Model/GetSocialBilibiliVideoinfo200ResponseHonorReplyHonorInner.md)
- [GetSocialBilibiliVideoinfo200ResponseOwner](docs/Model/GetSocialBilibiliVideoinfo200ResponseOwner.md)
- [GetSocialBilibiliVideoinfo200ResponsePagesInner](docs/Model/GetSocialBilibiliVideoinfo200ResponsePagesInner.md)
- [GetSocialBilibiliVideoinfo200ResponsePagesInnerDimension](docs/Model/GetSocialBilibiliVideoinfo200ResponsePagesInnerDimension.md)
- [GetSocialBilibiliVideoinfo200ResponseRights](docs/Model/GetSocialBilibiliVideoinfo200ResponseRights.md)
- [GetSocialBilibiliVideoinfo200ResponseStaffInner](docs/Model/GetSocialBilibiliVideoinfo200ResponseStaffInner.md)
- [GetSocialBilibiliVideoinfo200ResponseStat](docs/Model/GetSocialBilibiliVideoinfo200ResponseStat.md)
- [GetSocialBilibiliVideoinfo200ResponseSubtitle](docs/Model/GetSocialBilibiliVideoinfo200ResponseSubtitle.md)
- [GetSocialBilibiliVideoinfo200ResponseSubtitleListInner](docs/Model/GetSocialBilibiliVideoinfo200ResponseSubtitleListInner.md)
- [GetSocialBilibiliVideoinfo200ResponseSubtitleListInnerAuthor](docs/Model/GetSocialBilibiliVideoinfo200ResponseSubtitleListInnerAuthor.md)
- [GetSocialBilibiliVideoinfo200ResponseUgcSeason](docs/Model/GetSocialBilibiliVideoinfo200ResponseUgcSeason.md)
- [GetSocialQqGroupinfo200Response](docs/Model/GetSocialQqGroupinfo200Response.md)
- [GetSocialQqGroupinfo400Response](docs/Model/GetSocialQqGroupinfo400Response.md)
- [GetSocialQqGroupinfo404Response](docs/Model/GetSocialQqGroupinfo404Response.md)
- [GetSocialQqUserinfo200Response](docs/Model/GetSocialQqUserinfo200Response.md)
- [GetSocialQqUserinfo400Response](docs/Model/GetSocialQqUserinfo400Response.md)
- [GetSocialQqUserinfo404Response](docs/Model/GetSocialQqUserinfo404Response.md)
- [GetStatusRatelimit200Response](docs/Model/GetStatusRatelimit200Response.md)
- [GetStatusRatelimit401Response](docs/Model/GetStatusRatelimit401Response.md)
- [GetStatusUsage200Response](docs/Model/GetStatusUsage200Response.md)
- [GetStatusUsage200ResponseAnyOf](docs/Model/GetStatusUsage200ResponseAnyOf.md)
- [GetStatusUsage200ResponseAnyOf1](docs/Model/GetStatusUsage200ResponseAnyOf1.md)
- [GetStatusUsage200ResponseAnyOfEndpointsInner](docs/Model/GetStatusUsage200ResponseAnyOfEndpointsInner.md)
- [GetStatusUsage200ResponseAnyOfUnaggregated](docs/Model/GetStatusUsage200ResponseAnyOfUnaggregated.md)
- [GetStatusUsage404Response](docs/Model/GetStatusUsage404Response.md)
- [GetTextMd5200Response](docs/Model/GetTextMd5200Response.md)
- [GetTextMd5400Response](docs/Model/GetTextMd5400Response.md)
- [GetWebTomarkdownAsyncStatus200Response](docs/Model/GetWebTomarkdownAsyncStatus200Response.md)
- [GetWebTomarkdownAsyncStatus200ResponseAnyOf](docs/Model/GetWebTomarkdownAsyncStatus200ResponseAnyOf.md)
- [GetWebTomarkdownAsyncStatus200ResponseAnyOf1](docs/Model/GetWebTomarkdownAsyncStatus200ResponseAnyOf1.md)
- [GetWebTomarkdownAsyncStatus200ResponseAnyOf2](docs/Model/GetWebTomarkdownAsyncStatus200ResponseAnyOf2.md)
- [GetWebTomarkdownAsyncStatus200ResponseAnyOf2Result](docs/Model/GetWebTomarkdownAsyncStatus200ResponseAnyOf2Result.md)
- [GetWebTomarkdownAsyncStatus200ResponseAnyOf3](docs/Model/GetWebTomarkdownAsyncStatus200ResponseAnyOf3.md)
- [GetWebTomarkdownAsyncStatus404Response](docs/Model/GetWebTomarkdownAsyncStatus404Response.md)
- [GetWebparseExtractimages200Response](docs/Model/GetWebparseExtractimages200Response.md)
- [GetWebparseExtractimages500Response](docs/Model/GetWebparseExtractimages500Response.md)
- [GetWebparseMetadata200Response](docs/Model/GetWebparseMetadata200Response.md)
- [GetWebparseMetadata500Response](docs/Model/GetWebparseMetadata500Response.md)
- [PostAiTranslate200Response](docs/Model/PostAiTranslate200Response.md)
- [PostAiTranslate200ResponseData](docs/Model/PostAiTranslate200ResponseData.md)
- [PostAiTranslate200ResponsePerformance](docs/Model/PostAiTranslate200ResponsePerformance.md)
- [PostAiTranslate400Response](docs/Model/PostAiTranslate400Response.md)
- [PostAiTranslate401Response](docs/Model/PostAiTranslate401Response.md)
- [PostAiTranslate429Response](docs/Model/PostAiTranslate429Response.md)
- [PostAiTranslate500Response](docs/Model/PostAiTranslate500Response.md)
- [PostAiTranslateRequest](docs/Model/PostAiTranslateRequest.md)
- [PostAnswerbookAsk200Response](docs/Model/PostAnswerbookAsk200Response.md)
- [PostAnswerbookAskRequest](docs/Model/PostAnswerbookAskRequest.md)
- [PostClipzyStore200Response](docs/Model/PostClipzyStore200Response.md)
- [PostClipzyStore400Response](docs/Model/PostClipzyStore400Response.md)
- [PostClipzyStore413Response](docs/Model/PostClipzyStore413Response.md)
- [PostClipzyStoreRequest](docs/Model/PostClipzyStoreRequest.md)
- [PostConvertJson200Response](docs/Model/PostConvertJson200Response.md)
- [PostConvertJson400Response](docs/Model/PostConvertJson400Response.md)
- [PostConvertJsonRequest](docs/Model/PostConvertJsonRequest.md)
- [PostImageCompress400Response](docs/Model/PostImageCompress400Response.md)
- [PostImageCompress500Response](docs/Model/PostImageCompress500Response.md)
- [PostImageFrombase64200Response](docs/Model/PostImageFrombase64200Response.md)
- [PostImageFrombase64400Response](docs/Model/PostImageFrombase64400Response.md)
- [PostImageFrombase64500Response](docs/Model/PostImageFrombase64500Response.md)
- [PostImageFrombase64Request](docs/Model/PostImageFrombase64Request.md)
- [PostImageMotou400Response](docs/Model/PostImageMotou400Response.md)
- [PostImageMotou500Response](docs/Model/PostImageMotou500Response.md)
- [PostImageNsfw200Response](docs/Model/PostImageNsfw200Response.md)
- [PostImageNsfw400Response](docs/Model/PostImageNsfw400Response.md)
- [PostImageNsfw413Response](docs/Model/PostImageNsfw413Response.md)
- [PostImageNsfw500Response](docs/Model/PostImageNsfw500Response.md)
- [PostImageSpeechless400Response](docs/Model/PostImageSpeechless400Response.md)
- [PostImageSpeechless500Response](docs/Model/PostImageSpeechless500Response.md)
- [PostImageSpeechlessRequest](docs/Model/PostImageSpeechlessRequest.md)
- [PostImageSvg400Response](docs/Model/PostImageSvg400Response.md)
- [PostImageSvg500Response](docs/Model/PostImageSvg500Response.md)
- [PostMiscDateDiff200Response](docs/Model/PostMiscDateDiff200Response.md)
- [PostMiscDateDiff400Response](docs/Model/PostMiscDateDiff400Response.md)
- [PostMiscDateDiffRequest](docs/Model/PostMiscDateDiffRequest.md)
- [PostSearchAggregate200Response](docs/Model/PostSearchAggregate200Response.md)
- [PostSearchAggregate200ResponseResultsInner](docs/Model/PostSearchAggregate200ResponseResultsInner.md)
- [PostSearchAggregate200ResponseSourcesInner](docs/Model/PostSearchAggregate200ResponseSourcesInner.md)
- [PostSearchAggregate400Response](docs/Model/PostSearchAggregate400Response.md)
- [PostSearchAggregate401Response](docs/Model/PostSearchAggregate401Response.md)
- [PostSearchAggregate429Response](docs/Model/PostSearchAggregate429Response.md)
- [PostSearchAggregate500Response](docs/Model/PostSearchAggregate500Response.md)
- [PostSearchAggregateRequest](docs/Model/PostSearchAggregateRequest.md)
- [PostSensitiveWordAnalyze200Response](docs/Model/PostSensitiveWordAnalyze200Response.md)
- [PostSensitiveWordAnalyze200ResponseResultsInner](docs/Model/PostSensitiveWordAnalyze200ResponseResultsInner.md)
- [PostSensitiveWordAnalyze400Response](docs/Model/PostSensitiveWordAnalyze400Response.md)
- [PostSensitiveWordAnalyze401Response](docs/Model/PostSensitiveWordAnalyze401Response.md)
- [PostSensitiveWordAnalyze429Response](docs/Model/PostSensitiveWordAnalyze429Response.md)
- [PostSensitiveWordAnalyzeRequest](docs/Model/PostSensitiveWordAnalyzeRequest.md)
- [PostSensitiveWordQuickCheck200Response](docs/Model/PostSensitiveWordQuickCheck200Response.md)
- [PostSensitiveWordQuickCheckRequest](docs/Model/PostSensitiveWordQuickCheckRequest.md)
- [PostTextAesDecrypt200Response](docs/Model/PostTextAesDecrypt200Response.md)
- [PostTextAesDecrypt400Response](docs/Model/PostTextAesDecrypt400Response.md)
- [PostTextAesDecrypt500Response](docs/Model/PostTextAesDecrypt500Response.md)
- [PostTextAesDecryptAdvanced200Response](docs/Model/PostTextAesDecryptAdvanced200Response.md)
- [PostTextAesDecryptAdvanced400Response](docs/Model/PostTextAesDecryptAdvanced400Response.md)
- [PostTextAesDecryptAdvancedRequest](docs/Model/PostTextAesDecryptAdvancedRequest.md)
- [PostTextAesDecryptRequest](docs/Model/PostTextAesDecryptRequest.md)
- [PostTextAesEncrypt200Response](docs/Model/PostTextAesEncrypt200Response.md)
- [PostTextAesEncrypt400Response](docs/Model/PostTextAesEncrypt400Response.md)
- [PostTextAesEncrypt500Response](docs/Model/PostTextAesEncrypt500Response.md)
- [PostTextAesEncryptAdvanced200Response](docs/Model/PostTextAesEncryptAdvanced200Response.md)
- [PostTextAesEncryptAdvanced400Response](docs/Model/PostTextAesEncryptAdvanced400Response.md)
- [PostTextAesEncryptAdvancedRequest](docs/Model/PostTextAesEncryptAdvancedRequest.md)
- [PostTextAesEncryptRequest](docs/Model/PostTextAesEncryptRequest.md)
- [PostTextAnalyze200Response](docs/Model/PostTextAnalyze200Response.md)
- [PostTextAnalyze400Response](docs/Model/PostTextAnalyze400Response.md)
- [PostTextAnalyzeRequest](docs/Model/PostTextAnalyzeRequest.md)
- [PostTextBase64Decode200Response](docs/Model/PostTextBase64Decode200Response.md)
- [PostTextBase64Decode400Response](docs/Model/PostTextBase64Decode400Response.md)
- [PostTextBase64DecodeRequest](docs/Model/PostTextBase64DecodeRequest.md)
- [PostTextBase64Encode200Response](docs/Model/PostTextBase64Encode200Response.md)
- [PostTextBase64Encode400Response](docs/Model/PostTextBase64Encode400Response.md)
- [PostTextBase64EncodeRequest](docs/Model/PostTextBase64EncodeRequest.md)
- [PostTextConvert200Response](docs/Model/PostTextConvert200Response.md)
- [PostTextConvert400Response](docs/Model/PostTextConvert400Response.md)
- [PostTextConvertRequest](docs/Model/PostTextConvertRequest.md)
- [PostTextMd5400Response](docs/Model/PostTextMd5400Response.md)
- [PostTextMd5Request](docs/Model/PostTextMd5Request.md)
- [PostTextMd5Verify200Response](docs/Model/PostTextMd5Verify200Response.md)
- [PostTextMd5Verify400Response](docs/Model/PostTextMd5Verify400Response.md)
- [PostTextMd5VerifyRequest](docs/Model/PostTextMd5VerifyRequest.md)
- [PostTranslateStream400Response](docs/Model/PostTranslateStream400Response.md)
- [PostTranslateStream500Response](docs/Model/PostTranslateStream500Response.md)
- [PostTranslateStreamRequest](docs/Model/PostTranslateStreamRequest.md)
- [PostTranslateText200Response](docs/Model/PostTranslateText200Response.md)
- [PostTranslateText400Response](docs/Model/PostTranslateText400Response.md)
- [PostTranslateText500Response](docs/Model/PostTranslateText500Response.md)
- [PostTranslateTextRequest](docs/Model/PostTranslateTextRequest.md)
- [PostWebTomarkdownAsync202Response](docs/Model/PostWebTomarkdownAsync202Response.md)
- [PostWebTomarkdownAsync400Response](docs/Model/PostWebTomarkdownAsync400Response.md)

## Authorization
Endpoints do not require authorization.

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0.0`
    - Generator version: `7.17.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
