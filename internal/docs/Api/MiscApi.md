# OpenAPI\Client\MiscApi

一个“百宝箱”，集合了各种实用但不好归类的API，从查天气到查热榜，应有尽有。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getHistoryProgrammer()**](MiscApi.md#getHistoryProgrammer) | **GET** /history/programmer | 程序员历史事件 |
| [**getHistoryProgrammerToday()**](MiscApi.md#getHistoryProgrammerToday) | **GET** /history/programmer/today | 程序员历史上的今天 |
| [**getMiscDistrict()**](MiscApi.md#getMiscDistrict) | **GET** /misc/district | Adcode 国内外行政区域查询 |
| [**getMiscHolidayCalendar()**](MiscApi.md#getMiscHolidayCalendar) | **GET** /misc/holiday-calendar | 查询节假日与万年历 |
| [**getMiscHotboard()**](MiscApi.md#getMiscHotboard) | **GET** /misc/hotboard | 查询热榜 |
| [**getMiscLunartime()**](MiscApi.md#getMiscLunartime) | **GET** /misc/lunartime | 查询农历时间 |
| [**getMiscPhoneinfo()**](MiscApi.md#getMiscPhoneinfo) | **GET** /misc/phoneinfo | 查询手机归属地 |
| [**getMiscRandomnumber()**](MiscApi.md#getMiscRandomnumber) | **GET** /misc/randomnumber | 随机数生成 |
| [**getMiscTimestamp()**](MiscApi.md#getMiscTimestamp) | **GET** /misc/timestamp | 转换时间戳 (旧版，推荐使用/convert/unixtime) |
| [**getMiscTrackingCarriers()**](MiscApi.md#getMiscTrackingCarriers) | **GET** /misc/tracking/carriers | 获取支持的快递公司列表 |
| [**getMiscTrackingDetect()**](MiscApi.md#getMiscTrackingDetect) | **GET** /misc/tracking/detect | 识别快递公司 |
| [**getMiscTrackingQuery()**](MiscApi.md#getMiscTrackingQuery) | **GET** /misc/tracking/query | 查询快递物流信息 |
| [**getMiscWeather()**](MiscApi.md#getMiscWeather) | **GET** /misc/weather | 查询天气 |
| [**getMiscWorldtime()**](MiscApi.md#getMiscWorldtime) | **GET** /misc/worldtime | 查询世界时间 |
| [**postMiscDateDiff()**](MiscApi.md#postMiscDateDiff) | **POST** /misc/date-diff | 计算两个日期之间的时间差值 |


## `getHistoryProgrammer()`

```php
getHistoryProgrammer($month, $day): \OpenAPI\Client\Model\GetHistoryProgrammer200Response
```

程序员历史事件

想查看程序员历史上某个特定日期发生的大事件？指定月份和日期，我们就能告诉你！  ## 功能概述 通过指定月份和日期，获取该日发生的程序员相关历史事件。同样使用AI智能筛选，确保事件的相关性和重要性。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$month = 4; // int | 月份，1-12之间的整数。
$day = 4; // int | 日期，1-31之间的整数。

try {
    $result = $apiInstance->getHistoryProgrammer($month, $day);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getHistoryProgrammer: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **month** | **int**| 月份，1-12之间的整数。 | |
| **day** | **int**| 日期，1-31之间的整数。 | |

### Return type

[**\OpenAPI\Client\Model\GetHistoryProgrammer200Response**](../Model/GetHistoryProgrammer200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getHistoryProgrammerToday()`

```php
getHistoryProgrammerToday(): \OpenAPI\Client\Model\GetHistoryProgrammerToday200Response
```

程序员历史上的今天

想知道程序员历史上的今天发生了什么大事吗？这个接口告诉你答案！  ## 功能概述 我们使用AI智能筛选从海量历史事件中挑选出与程序员、计算机科学相关的重要事件。每个事件都经过重要性评分和相关性评分，确保内容质量。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getHistoryProgrammerToday();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getHistoryProgrammerToday: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetHistoryProgrammerToday200Response**](../Model/GetHistoryProgrammerToday200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscDistrict()`

```php
getMiscDistrict($keywords, $adcode, $lat, $lng, $level, $country, $limit): \OpenAPI\Client\Model\GetMiscDistrict200Response
```

Adcode 国内外行政区域查询

一个接口，覆盖全球 243 个国家、中国省/市/区/街道四级行政区划，支持关键词搜索、行政编码查询、坐标反查三种查询模式（必须至少传入一种查询参数）。  ## 功能概述 根据用户输入的搜索条件快速查找行政区域信息。例如：中国 > 山东省 > 济南市 > 历下区 > 舜华路街道。  无需注册、无需密钥，直接调用即可获取结构化的行政区域数据。支持三种查询方式： - 传 `adcode`，按行政编码精确查询，同时返回下级区划列表 - 传 `lat` + `lng`，坐标反查附近地点 - 传 `keywords`，按关键词搜索，支持中英文  ## 中国与国际数据差异 中国数据包含 `adcode`、`citycode` 等字段，支持省/市/区/街道四级逐级查询；国际城市数据不含这些字段，但额外提供 `population`（人口）和 `timezone`（时区）。  > [!NOTE] > 部分城市（如东莞、文昌）没有区县层级，市级下方直接显示街道。街道级别的 `adcode` 返回的是所属区县的 `adcode`。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$keywords = 上海; // string | 关键词搜索（城市名、区县名，支持中英文）。
$adcode = 110000; // string | 中国行政区划代码精确查询（如 `110000`），同时返回下级行政区。
$lat = 39.9; // float | 纬度，与 `lng` 配合使用，坐标反查附近地点。
$lng = 116.4; // float | 经度，与 `lat` 配合使用。
$level = 'level_example'; // string | 过滤行政级别。
$country = CN; // string | 过滤国家代码（ISO 3166-1 alpha-2），如 `CN`、`JP`、`US`、`GB`。
$limit = 20; // int | 返回数量上限，默认 `20`，最大 `100`。

try {
    $result = $apiInstance->getMiscDistrict($keywords, $adcode, $lat, $lng, $level, $country, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscDistrict: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **keywords** | **string**| 关键词搜索（城市名、区县名，支持中英文）。 | [optional] |
| **adcode** | **string**| 中国行政区划代码精确查询（如 &#x60;110000&#x60;），同时返回下级行政区。 | [optional] |
| **lat** | **float**| 纬度，与 &#x60;lng&#x60; 配合使用，坐标反查附近地点。 | [optional] |
| **lng** | **float**| 经度，与 &#x60;lat&#x60; 配合使用。 | [optional] |
| **level** | **string**| 过滤行政级别。 | [optional] |
| **country** | **string**| 过滤国家代码（ISO 3166-1 alpha-2），如 &#x60;CN&#x60;、&#x60;JP&#x60;、&#x60;US&#x60;、&#x60;GB&#x60;。 | [optional] |
| **limit** | **int**| 返回数量上限，默认 &#x60;20&#x60;，最大 &#x60;100&#x60;。 | [optional] [default to 20] |

### Return type

[**\OpenAPI\Client\Model\GetMiscDistrict200Response**](../Model/GetMiscDistrict200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscHolidayCalendar()`

```php
getMiscHolidayCalendar($date, $month, $year, $timezone, $holiday_type, $include_nearby, $nearby_limit): \OpenAPI\Client\Model\GetMiscHolidayCalendar200Response
```

查询节假日与万年历

查询指定日期、月份或年份的万年历与节假日信息。  ## 功能概述 这个接口支持三种查询方式：按天（`date`）、按月（`month`）和按年（`year`）。调用时三者选一个传入即可。  如果你只关心某一类事件，可以通过 `holiday_type` 进行筛选，例如只看法定休假/调休、公历节日、农历节日或节气。  在 `date` 模式下，传 `include_nearby=true` 可以额外返回该日期前后最近的节日；返回数量由 `nearby_limit` 控制，默认 7，最大 30。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$date = 2025-10-01; // string | 按天查询时填写这个参数，例如查某一天。格式：`YYYY-MM-DD`。和 `month`、`year` 三选一。
$month = 'month_example'; // string | 按月查询时填写这个参数，例如查某个月。格式：`YYYY-MM`。和 `date`、`year` 三选一。
$year = 'year_example'; // string | 按年查询时填写这个参数，例如查某一年。格式：`YYYY`。和 `date`、`month` 三选一。
$timezone = Asia/Shanghai; // string | 时区名称，默认 Asia/Shanghai。
$holiday_type = legal; // string | 节日筛选类型，默认 all。
$include_nearby = true; // bool | 是否返回前后最近节日，仅 date 模式生效，默认 false。month/year 模式会忽略此参数。
$nearby_limit = 7; // int | 返回最近节日数量限制，默认 7，最大 30。仅 date 模式 + include_nearby=true 生效。

try {
    $result = $apiInstance->getMiscHolidayCalendar($date, $month, $year, $timezone, $holiday_type, $include_nearby, $nearby_limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscHolidayCalendar: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **date** | **string**| 按天查询时填写这个参数，例如查某一天。格式：&#x60;YYYY-MM-DD&#x60;。和 &#x60;month&#x60;、&#x60;year&#x60; 三选一。 | [optional] |
| **month** | **string**| 按月查询时填写这个参数，例如查某个月。格式：&#x60;YYYY-MM&#x60;。和 &#x60;date&#x60;、&#x60;year&#x60; 三选一。 | [optional] |
| **year** | **string**| 按年查询时填写这个参数，例如查某一年。格式：&#x60;YYYY&#x60;。和 &#x60;date&#x60;、&#x60;month&#x60; 三选一。 | [optional] |
| **timezone** | **string**| 时区名称，默认 Asia/Shanghai。 | [optional] [default to &#39;Asia/Shanghai&#39;] |
| **holiday_type** | **string**| 节日筛选类型，默认 all。 | [optional] [default to &#39;all&#39;] |
| **include_nearby** | **bool**| 是否返回前后最近节日，仅 date 模式生效，默认 false。month/year 模式会忽略此参数。 | [optional] [default to false] |
| **nearby_limit** | **int**| 返回最近节日数量限制，默认 7，最大 30。仅 date 模式 + include_nearby&#x3D;true 生效。 | [optional] [default to 7] |

### Return type

[**\OpenAPI\Client\Model\GetMiscHolidayCalendar200Response**](../Model/GetMiscHolidayCalendar200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscHotboard()`

```php
getMiscHotboard($type, $time, $keyword, $time_start, $time_end, $limit, $sources): \OpenAPI\Client\Model\GetMiscHotboard200Response
```

查询热榜

想快速跟上网络热点？这个接口让你一网打尽各大主流平台的实时热榜/热搜！  ## 功能概述 你只需要指定一个平台类型，就能获取到该平台当前的热榜数据列表。每个热榜条目都包含标题、热度值和原始链接。非常适合用于制作信息聚合类应用或看板。  ## 三种使用模式  ### 默认模式 只传 `type` 参数，返回该平台当前的实时热榜。  ### 时光机模式 传 `type` + `time` 参数，返回最接近指定时间的热榜快照。如果不可用或无数据，会返回空。  ### 搜索模式 传 `type` + `keyword` + `time_start` + `time_end` 参数，在指定时间范围内搜索包含关键词的热榜条目。可选传 `limit` 限制返回数量。  ### 数据源列表 传 `sources=true`，返回所有支持历史数据的平台列表。  ## 可选值 `type` 参数接受多种不同的值，每种值对应一个不同的热榜来源。以下是目前支持的所有值：  | 分类       | 支持的 type 值 | |------------|-----------------------------------------------------------------------------------------------------------------------------------| | 视频/社区  | bilibili（哔哩哔哩弹幕网）, acfun（A站弹幕视频网站）, weibo（新浪微博热搜）, zhihu（知乎热榜）, zhihu-daily（知乎日报热榜）, douyin（抖音热榜）, kuaishou（快手热榜）, douban-movie（豆瓣电影榜单）, douban-group（豆瓣小组话题）, tieba（百度贴吧热帖）, hupu（虎扑热帖）, ngabbs（NGA游戏论坛热帖）, v2ex（V2EX技术社区热帖）, 52pojie（吾爱破解热帖）, hostloc（全球主机交流论坛）, coolapk（酷安热榜） | | 新闻/资讯  | baidu（百度热搜）, thepaper（澎湃新闻热榜）, toutiao（今日头条热榜）, qq-news（腾讯新闻热榜）, sina（新浪热搜）, sina-news（新浪新闻热榜）, netease-news（网易新闻热榜）, huxiu（虎嗅网热榜）, ifanr（爱范儿热榜） | | 技术/IT    | sspai（少数派热榜）, ithome（IT之家热榜）, ithome-xijiayi（IT之家·喜加一栏目）, juejin（掘金社区热榜）, jianshu（简书热榜）, guokr（果壳热榜）, 36kr（36氪热榜）, 51cto（51CTO热榜）, csdn（CSDN博客热榜）, nodeseek（NodeSeek 技术社区）, hellogithub（HelloGitHub 项目推荐） | | 游戏       | lol（英雄联盟热帖）, genshin（原神热榜）, honkai（崩坏3热榜）, starrail（星穹铁道热榜） | | 音乐       | netease-music（网易云音乐热歌榜）, qq-music（QQ音乐热歌榜） | | 其他       | weread（微信读书热门书籍）, weatheralarm（天气预警信息）, earthquake（地震速报）, history（历史上的今天） |

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$type = weibo; // string | 你想要查询的热榜平台。支持多种主流平台类型，详见下方[可选值](#可选值)表格。
$time = 1700000000000; // int | 时光机模式：毫秒时间戳，返回最接近该时间的热榜快照。不传则返回当前实时热榜。
$keyword = AI; // string | 搜索模式：搜索关键词，在历史热榜中搜索包含该关键词的条目。需配合 time_start 和 time_end 使用。
$time_start = 1699900000000; // int | 搜索模式必填：搜索起始时间戳（毫秒）。
$time_end = 1700100000000; // int | 搜索模式必填：搜索结束时间戳（毫秒）。
$limit = 50; // int | 搜索模式下最大返回条数，默认 50，最大 200。
$sources = true; // bool | 设为 true 时列出所有可用的历史数据源，忽略其他参数。

try {
    $result = $apiInstance->getMiscHotboard($type, $time, $keyword, $time_start, $time_end, $limit, $sources);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscHotboard: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **type** | **string**| 你想要查询的热榜平台。支持多种主流平台类型，详见下方[可选值](#可选值)表格。 | |
| **time** | **int**| 时光机模式：毫秒时间戳，返回最接近该时间的热榜快照。不传则返回当前实时热榜。 | [optional] |
| **keyword** | **string**| 搜索模式：搜索关键词，在历史热榜中搜索包含该关键词的条目。需配合 time_start 和 time_end 使用。 | [optional] |
| **time_start** | **int**| 搜索模式必填：搜索起始时间戳（毫秒）。 | [optional] |
| **time_end** | **int**| 搜索模式必填：搜索结束时间戳（毫秒）。 | [optional] |
| **limit** | **int**| 搜索模式下最大返回条数，默认 50，最大 200。 | [optional] [default to 50] |
| **sources** | **bool**| 设为 true 时列出所有可用的历史数据源，忽略其他参数。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetMiscHotboard200Response**](../Model/GetMiscHotboard200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscLunartime()`

```php
getMiscLunartime($ts, $timezone): \OpenAPI\Client\Model\GetMiscLunartime200Response
```

查询农历时间

需要在指定时区下查看某个时间点的农历信息？这个接口可以直接返回完整结果。  ## 功能概述 支持传入 Unix 时间戳（秒或毫秒）和 IANA 时区名，返回公历时间、星期、农历年月日、干支、生肖、节气与节日信息。不传 `ts` 时默认使用当前时间，不传 `timezone` 时默认 `Asia/Shanghai`。  ## 时区说明 - 支持标准 IANA 时区，例如 `Asia/Shanghai`、`Asia/Tokyo` - 也支持别名：`Shanghai`、`Beijing` - 时区非法时返回 400 并提示 `invalid timezone: xxx`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$ts = 1707537600; // string | Unix 时间戳，支持 10 位秒级或 13 位毫秒级。不传则默认当前时间。
$timezone = Asia/Shanghai; // string | 时区名称。支持 IANA 时区（如 Asia/Shanghai）和别名（Shanghai、Beijing）。默认 Asia/Shanghai。

try {
    $result = $apiInstance->getMiscLunartime($ts, $timezone);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscLunartime: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **ts** | **string**| Unix 时间戳，支持 10 位秒级或 13 位毫秒级。不传则默认当前时间。 | [optional] |
| **timezone** | **string**| 时区名称。支持 IANA 时区（如 Asia/Shanghai）和别名（Shanghai、Beijing）。默认 Asia/Shanghai。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetMiscLunartime200Response**](../Model/GetMiscLunartime200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscPhoneinfo()`

```php
getMiscPhoneinfo($phone): \OpenAPI\Client\Model\GetMiscPhoneinfo200Response
```

查询手机归属地

想知道一个手机号码来自哪里？是移动、联通还是电信？这个接口可以告诉你答案。  ## 功能概述 提供一个国内的手机号码，我们会查询并返回它的归属地（省份和城市）以及所属的运营商信息。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$phone = 13800138000; // string | 需要查询的11位中国大陆手机号码。

try {
    $result = $apiInstance->getMiscPhoneinfo($phone);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscPhoneinfo: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **phone** | **string**| 需要查询的11位中国大陆手机号码。 | |

### Return type

[**\OpenAPI\Client\Model\GetMiscPhoneinfo200Response**](../Model/GetMiscPhoneinfo200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscRandomnumber()`

```php
getMiscRandomnumber($min, $max, $count, $allow_repeat, $allow_decimal, $decimal_places): \OpenAPI\Client\Model\GetMiscRandomnumber200Response
```

随机数生成

需要一个简单的随机数，还是需要一串不重复的、带小数的随机数？这个接口都能满足你！  ## 功能概述 这是一个强大的随机数生成器。你可以指定生成的范围（最大/最小值）、数量、是否允许重复、以及是否生成小数（并指定小数位数）。  ## 流程图 ```mermaid graph TD     A[开始] --> B{参数校验};     B --> |通过| C{是否允许小数?};     C --> |是| D[生成随机小数];     C --> |否| E[生成随机整数];     D --> F{是否允许重复?};     E --> F;     F --> |是| G[直接生成指定数量];     F --> |否| H[生成不重复的数字];     G --> I[返回结果];     H --> I;     B --> |失败| J[返回 400 错误]; ``` ## 使用须知 > [!WARNING] > **不重复生成的逻辑限制** > 当设置 `allow_repeat=false` 时，请确保取值范围 `(max - min + 1)` 大于或等于你请求的数量 `count`。否则，系统将无法生成足够的不重复数字，请求会失败并返回 400 错误。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$min = 10; // int | 生成随机数的最小值（包含）。
$max = 50; // int | 生成随机数的最大值（包含）。
$count = 5; // int | 需要生成的随机数的数量。
$allow_repeat = true; // bool | 是否允许生成的多个数字中出现重复值。
$allow_decimal = true; // bool | 是否生成小（浮点）数。如果为 false，则只生成整数。
$decimal_places = 2; // int | 如果 `allow_decimal=true`，这里可以指定小数的位数。

try {
    $result = $apiInstance->getMiscRandomnumber($min, $max, $count, $allow_repeat, $allow_decimal, $decimal_places);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscRandomnumber: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **min** | **int**| 生成随机数的最小值（包含）。 | [optional] [default to 1] |
| **max** | **int**| 生成随机数的最大值（包含）。 | [optional] [default to 100] |
| **count** | **int**| 需要生成的随机数的数量。 | [optional] [default to 1] |
| **allow_repeat** | **bool**| 是否允许生成的多个数字中出现重复值。 | [optional] [default to false] |
| **allow_decimal** | **bool**| 是否生成小（浮点）数。如果为 false，则只生成整数。 | [optional] [default to false] |
| **decimal_places** | **int**| 如果 &#x60;allow_decimal&#x3D;true&#x60;，这里可以指定小数的位数。 | [optional] [default to 2] |

### Return type

[**\OpenAPI\Client\Model\GetMiscRandomnumber200Response**](../Model/GetMiscRandomnumber200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscTimestamp()`

```php
getMiscTimestamp($ts): \OpenAPI\Client\Model\GetMiscTimestamp200Response
```

转换时间戳 (旧版，推荐使用/convert/unixtime)

这是一个用于将Unix时间戳转换为人类可读日期时间的旧版接口。  ## 功能概述 输入一个秒级或毫秒级的时间戳，返回其对应的本地时间和UTC时间。  > [!WARNING] > **接口已过时**：这个接口已被新的 `/convert/unixtime` 取代。新接口功能更强大，支持双向转换。我们建议你迁移到新接口。  [➡️ 前往新版接口文档](/docs/api-reference/get-convert-unixtime)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$ts = 1672531200; // string | 需要转换的Unix时间戳，支持10位（秒）或13位（毫秒）。

try {
    $result = $apiInstance->getMiscTimestamp($ts);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscTimestamp: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **ts** | **string**| 需要转换的Unix时间戳，支持10位（秒）或13位（毫秒）。 | |

### Return type

[**\OpenAPI\Client\Model\GetMiscTimestamp200Response**](../Model/GetMiscTimestamp200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscTrackingCarriers()`

```php
getMiscTrackingCarriers(): \OpenAPI\Client\Model\GetMiscTrackingCarriers200Response
```

获取支持的快递公司列表

不确定系统支持哪些快递公司？这个接口返回完整的支持列表。  > [!VIP] > 本API目前处于**限时免费**阶段，我们鼓励开发者集成和测试。未来，它将转为付费API，为用户提供更稳定和强大的服务。  ## 功能概述 获取系统当前支持的所有快递公司列表，包括每家公司的标准编码（code）和中文名称（name）。  ## 使用建议 - **推荐缓存**：这个列表基本不会频繁变动，建议在应用启动时调用一次并缓存到本地 - **应用场景**：适合用于构建快递公司选择器、下拉菜单等UI组件 - **缓存时长**：建议缓存24小时或更久

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getMiscTrackingCarriers();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscTrackingCarriers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetMiscTrackingCarriers200Response**](../Model/GetMiscTrackingCarriers200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscTrackingDetect()`

```php
getMiscTrackingDetect($tracking_number): \OpenAPI\Client\Model\GetMiscTrackingDetect200Response
```

识别快递公司

不确定手里的快递单号属于哪家快递公司？这个接口专门做识别，不查物流。  > [!VIP] > 本API目前处于**限时免费**阶段，我们鼓励开发者集成和测试。未来，它将转为付费API，为用户提供更稳定和强大的服务。  ## 功能概述 输入快递单号，系统会根据单号规则快速识别出最可能的快递公司。如果存在多个可能的匹配结果，还会在 `alternatives` 字段中返回备选项，供你参考选择。  ## 使用须知 - **识别速度快**：只做规则匹配，不查询物流信息，响应速度通常在100ms内 - **准确率高**：基于各快递公司的单号规则进行智能识别，准确率超过95% - **备选方案**：当单号规则可能匹配多家快递公司时，会提供所有可能的选项

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$tracking_number = 'tracking_number_example'; // string | 需要识别的快递单号。

try {
    $result = $apiInstance->getMiscTrackingDetect($tracking_number);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscTrackingDetect: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tracking_number** | **string**| 需要识别的快递单号。 | |

### Return type

[**\OpenAPI\Client\Model\GetMiscTrackingDetect200Response**](../Model/GetMiscTrackingDetect200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscTrackingQuery()`

```php
getMiscTrackingQuery($tracking_number, $carrier_code, $phone): \OpenAPI\Client\Model\GetMiscTrackingQuery200Response
```

查询快递物流信息

买了东西想知道快递到哪儿了？这个接口帮你实时追踪物流状态。  > [!VIP] > 本API目前处于**限时免费**阶段，我们鼓励开发者集成和测试。未来，它将转为付费API，为用户提供更稳定和强大的服务。  ## 功能概述 提供一个快递单号，系统会自动识别快递公司并返回完整的物流轨迹信息。支持中通、圆通、韵达、申通、极兔、顺丰、京东、EMS、德邦等60+国内外主流快递公司。  ## 使用须知 - **自动识别**：不知道是哪家快递？系统会根据单号规则自动识别快递公司（推荐使用） - **手动指定**：如果已知快递公司，可以传递 `carrier_code` 参数，查询速度会更快 - **手机尾号验证**：部分快递公司需要验证收件人手机尾号才能查询详细物流，如果返回「暂无物流信息」，建议尝试传入 `phone` 参数 - **查询时效**：物流信息实时查询，响应时间通常在1-2秒内

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$tracking_number = 'tracking_number_example'; // string | 快递单号，通常是一串10-20位的数字或字母数字组合。
$carrier_code = 'carrier_code_example'; // string | 快递公司编码（可选）。不填写时系统会自动识别，填写后可加快查询速度。
$phone = 'phone_example'; // string | 收件人手机尾号，4位数字（可选）。部分快递公司需要验证手机尾号才能查询详细物流信息。

try {
    $result = $apiInstance->getMiscTrackingQuery($tracking_number, $carrier_code, $phone);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscTrackingQuery: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tracking_number** | **string**| 快递单号，通常是一串10-20位的数字或字母数字组合。 | |
| **carrier_code** | **string**| 快递公司编码（可选）。不填写时系统会自动识别，填写后可加快查询速度。 | [optional] |
| **phone** | **string**| 收件人手机尾号，4位数字（可选）。部分快递公司需要验证手机尾号才能查询详细物流信息。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetMiscTrackingQuery200Response**](../Model/GetMiscTrackingQuery200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscWeather()`

```php
getMiscWeather($city, $adcode, $extended, $forecast, $hourly, $minutely, $indices, $lang): \OpenAPI\Client\Model\GetMiscWeather200Response
```

查询天气

出门前，查一下天气总是个好习惯。这个接口为你提供精准、实时的天气数据，支持国内和国际城市。  ## 功能概述 这个接口支持三种查询方式： - 可以传 `adcode`，按行政区编码查询（优先级最高） - 可以传 `city`，按城市名称查询，支持中文（`北京`）和英文（`Tokyo`） - 两个都不传时，按客户端 IP 自动定位查询  支持 `lang` 参数，可选 `zh`（默认）和 `en`，城市名翻译覆盖 7000+ 城市。  ## 可选功能模块 - `extended=true`：扩展气象字段（体感温度、能见度、气压、紫外线、空气质量及污染物分项数据） - `forecast=true`：多天预报（最多7天，含日出日落、风速等详细数据） - `hourly=true`：逐小时预报（24小时） - `minutely=true`：分钟级降水预报（仅国内城市） - `indices=true`：18项生活指数（穿衣、紫外线、洗车、运动、花粉等）  ## 天气字段说明 `weather` 是天气现象文本，不是固定枚举。  常见值包括：晴、多云、阴、小雨、中雨、大雨、雷阵雨、小雪、中雪、大雪、雨夹雪、雾、霾、沙尘。  如果你的业务需要稳定分类，建议结合 `weather_code` 做自己的映射归类。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$city = 北京; // string | 城市名称，支持中文（`北京`）和英文（`Tokyo`）。可选参数，不传时会尝试 IP 自动定位。
$adcode = 'adcode_example'; // string | 城市行政区划代码（如 `110000`），优先级高于 city。可选参数，不传时会尝试 IP 自动定位。
$extended = True; // bool | 返回扩展气象字段（体感温度、能见度、气压、紫外线、降水量、云量、空气质量指数及污染物分项数据）。
$forecast = True; // bool | 返回多天预报数据（最多7天），含白天夜间天气、风向风力、日出日落等。
$hourly = True; // bool | 返回逐小时预报（24小时），含温度、天气、风向风速、湿度、降水概率等。
$minutely = True; // bool | 返回分钟级降水预报（仅国内城市），每5分钟一个数据点，共24个。
$indices = True; // bool | 返回18项生活指数（穿衣、紫外线、洗车、晾晒、空调、感冒、运动、舒适度、出行、钓鱼、过敏、防晒、心情、啤酒、雨伞、交通、空气净化器、花粉）。
$lang = 'zh'; // string | 返回语言。`zh` 返回中文（默认），`en` 返回英文。城市名翻译覆盖 7000+ 城市。生活指数（`indices`）目前仅支持中文。

try {
    $result = $apiInstance->getMiscWeather($city, $adcode, $extended, $forecast, $hourly, $minutely, $indices, $lang);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscWeather: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **city** | **string**| 城市名称，支持中文（&#x60;北京&#x60;）和英文（&#x60;Tokyo&#x60;）。可选参数，不传时会尝试 IP 自动定位。 | [optional] |
| **adcode** | **string**| 城市行政区划代码（如 &#x60;110000&#x60;），优先级高于 city。可选参数，不传时会尝试 IP 自动定位。 | [optional] |
| **extended** | **bool**| 返回扩展气象字段（体感温度、能见度、气压、紫外线、降水量、云量、空气质量指数及污染物分项数据）。 | [optional] |
| **forecast** | **bool**| 返回多天预报数据（最多7天），含白天夜间天气、风向风力、日出日落等。 | [optional] |
| **hourly** | **bool**| 返回逐小时预报（24小时），含温度、天气、风向风速、湿度、降水概率等。 | [optional] |
| **minutely** | **bool**| 返回分钟级降水预报（仅国内城市），每5分钟一个数据点，共24个。 | [optional] |
| **indices** | **bool**| 返回18项生活指数（穿衣、紫外线、洗车、晾晒、空调、感冒、运动、舒适度、出行、钓鱼、过敏、防晒、心情、啤酒、雨伞、交通、空气净化器、花粉）。 | [optional] |
| **lang** | **string**| 返回语言。&#x60;zh&#x60; 返回中文（默认），&#x60;en&#x60; 返回英文。城市名翻译覆盖 7000+ 城市。生活指数（&#x60;indices&#x60;）目前仅支持中文。 | [optional] [default to &#39;zh&#39;] |

### Return type

[**\OpenAPI\Client\Model\GetMiscWeather200Response**](../Model/GetMiscWeather200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMiscWorldtime()`

```php
getMiscWorldtime($city): \OpenAPI\Client\Model\GetMiscWorldtime200Response
```

查询世界时间

需要和国外的朋友开会，想知道他那边现在几点？用这个接口一查便知。  ## 功能概述 根据标准的时区名称（例如 'Asia/Shanghai' 或 'Europe/London'），获取该时区的当前准确时间、UTC偏移量、星期等信息。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$city = Asia/Shanghai; // string | 你需要查询的城市或地区，请使用标准的 IANA 时区数据库名称，例如 'Shanghai', 'Asia/Tokyo', 'America/New_York'。

try {
    $result = $apiInstance->getMiscWorldtime($city);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscWorldtime: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **city** | **string**| 你需要查询的城市或地区，请使用标准的 IANA 时区数据库名称，例如 &#39;Shanghai&#39;, &#39;Asia/Tokyo&#39;, &#39;America/New_York&#39;。 | |

### Return type

[**\OpenAPI\Client\Model\GetMiscWorldtime200Response**](../Model/GetMiscWorldtime200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postMiscDateDiff()`

```php
postMiscDateDiff($post_misc_date_diff_request): \OpenAPI\Client\Model\PostMiscDateDiff200Response
```

计算两个日期之间的时间差值

想知道两个日期之间相差多久？这个接口帮你精确计算时间差值。  ## 功能概述 输入开始日期和结束日期，返回它们之间的时间差，包括总天数、总小时数、总分钟数、总秒数、总周数，以及人性化显示格式（如\"1年2月3天\"）。  ## 日期格式 接口支持自动识别常见日期格式，包括：YYYY-MM-DD、YYYY/MM/DD、DD-MM-YYYY、ISO 8601（带时区）等。也可以通过`format`参数显式指定格式（如DD-MM-YYYY）。  > [!NOTE] > 当结束日期早于开始日期时，返回的数值为负数。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_misc_date_diff_request = new \OpenAPI\Client\Model\PostMiscDateDiffRequest(); // \OpenAPI\Client\Model\PostMiscDateDiffRequest | 包含日期信息的JSON对象

try {
    $result = $apiInstance->postMiscDateDiff($post_misc_date_diff_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->postMiscDateDiff: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_misc_date_diff_request** | [**\OpenAPI\Client\Model\PostMiscDateDiffRequest**](../Model/PostMiscDateDiffRequest.md)| 包含日期信息的JSON对象 | |

### Return type

[**\OpenAPI\Client\Model\PostMiscDateDiff200Response**](../Model/PostMiscDateDiff200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
