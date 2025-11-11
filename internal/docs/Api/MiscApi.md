# OpenAPI\Client\MiscApi

一个“百宝箱”，集合了各种实用但不好归类的API，从查天气到查热榜，应有尽有。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getHistoryProgrammer()**](MiscApi.md#getHistoryProgrammer) | **GET** /history/programmer | 获取指定日期的程序员历史事件 |
| [**getHistoryProgrammerToday()**](MiscApi.md#getHistoryProgrammerToday) | **GET** /history/programmer/today | 获取今天的程序员历史事件 |
| [**getMiscHotboard()**](MiscApi.md#getMiscHotboard) | **GET** /misc/hotboard | 获取多平台实时热榜 |
| [**getMiscPhoneinfo()**](MiscApi.md#getMiscPhoneinfo) | **GET** /misc/phoneinfo | 查询手机号码归属地信息 |
| [**getMiscRandomnumber()**](MiscApi.md#getMiscRandomnumber) | **GET** /misc/randomnumber | 生成高度可定制的随机数 |
| [**getMiscTimestamp()**](MiscApi.md#getMiscTimestamp) | **GET** /misc/timestamp | 转换时间戳 (旧版，推荐使用/convert/unixtime) |
| [**getMiscTrackingCarriers()**](MiscApi.md#getMiscTrackingCarriers) | **GET** /misc/tracking/carriers | 获取支持的快递公司列表 |
| [**getMiscTrackingDetect()**](MiscApi.md#getMiscTrackingDetect) | **GET** /misc/tracking/detect | 识别快递公司 |
| [**getMiscTrackingQuery()**](MiscApi.md#getMiscTrackingQuery) | **GET** /misc/tracking/query | 查询快递物流信息 |
| [**getMiscWeather()**](MiscApi.md#getMiscWeather) | **GET** /misc/weather | 查询实时天气信息 |
| [**getMiscWorldtime()**](MiscApi.md#getMiscWorldtime) | **GET** /misc/worldtime | 查询全球任意时区的时间 |


## `getHistoryProgrammer()`

```php
getHistoryProgrammer($month, $day): \OpenAPI\Client\Model\GetHistoryProgrammer200Response
```

获取指定日期的程序员历史事件

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

获取今天的程序员历史事件

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

## `getMiscHotboard()`

```php
getMiscHotboard($type): \OpenAPI\Client\Model\GetMiscHotboard200Response
```

获取多平台实时热榜

想快速跟上网络热点？这个接口让你一网打尽各大主流平台的实时热榜/热搜！  ## 功能概述 你只需要指定一个平台类型，就能获取到该平台当前的热榜数据列表。每个热榜条目都包含标题、热度值和原始链接。非常适合用于制作信息聚合类应用或看板。  ## 可选值 `type` 参数接受多种不同的值，每种值对应一个不同的热榜来源。以下是目前支持的所有值：  | 分类       | 支持的 type 值 | |------------|-----------------------------------------------------------------------------------------------------------------------------------| | 视频/社区  | bilibili（哔哩哔哩弹幕网）, acfun（A站弹幕视频网站）, weibo（新浪微博热搜）, zhihu（知乎热榜）, zhihu-daily（知乎日报热榜）, douyin（抖音热榜）, kuaishou（快手热榜）, douban-movie（豆瓣电影榜单）, douban-group（豆瓣小组话题）, tieba（百度贴吧热帖）, hupu（虎扑热帖）, miyoushe（米游社话题榜）, ngabbs（NGA游戏论坛热帖）, v2ex（V2EX技术社区热帖）, 52pojie（吾爱破解热帖）, hostloc（全球主机交流论坛）, coolapk（酷安热榜） | | 新闻/资讯  | baidu（百度热搜）, thepaper（澎湃新闻热榜）, toutiao（今日头条热榜）, qq-news（腾讯新闻热榜）, sina（新浪热搜）, sina-news（新浪新闻热榜）, netease-news（网易新闻热榜）, huxiu（虎嗅网热榜）, ifanr（爱范儿热榜） | | 技术/IT    | sspai（少数派热榜）, ithome（IT之家热榜）, ithome-xijiayi（IT之家·喜加一栏目）, juejin（掘金社区热榜）, jianshu（简书热榜）, guokr（果壳热榜）, 36kr（36氪热榜）, 51cto（51CTO热榜）, csdn（CSDN博客热榜）, nodeseek（NodeSeek 技术社区）, hellogithub（HelloGitHub 项目推荐） | | 游戏       | lol（英雄联盟热帖）, genshin（原神热榜）, honkai（崩坏3热榜）, starrail（星穹铁道热榜） | | 其他       | weread（微信读书热门书籍）, weatheralarm（天气预警信息）, earthquake（地震速报）, history（历史上的今天） |

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

try {
    $result = $apiInstance->getMiscHotboard($type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscHotboard: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **type** | **string**| 你想要查询的热榜平台。支持多种主流平台类型，详见下方[可选值](#可选值)表格。 | |

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

## `getMiscPhoneinfo()`

```php
getMiscPhoneinfo($phone): \OpenAPI\Client\Model\GetMiscPhoneinfo200Response
```

查询手机号码归属地信息

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

生成高度可定制的随机数

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

这是一个用于将Unix时间戳转换为人类可读日期时间的旧版接口。  ## 功能概述 输入一个秒级或毫秒级的时间戳，返回其对应的本地时间和UTC时间。  > [!WARNING] > **接口已过时**：这个接口已被新的 `/convert/unixtime` 取代。新接口功能更强大，支持双向转换。我们建议你迁移到新接口。  [👉 前往新版接口文档](/docs/api-reference/get-convert-unixtime)

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
getMiscTrackingQuery($tracking_number, $carrier_code): \OpenAPI\Client\Model\GetMiscTrackingQuery200Response
```

查询快递物流信息

买了东西想知道快递到哪儿了？这个接口帮你实时追踪物流状态。  > [!VIP] > 本API目前处于**限时免费**阶段，我们鼓励开发者集成和测试。未来，它将转为付费API，为用户提供更稳定和强大的服务。  ## 功能概述 提供一个快递单号，系统会自动识别快递公司并返回完整的物流轨迹信息。支持中通、圆通、韵达、申通、极兔、顺丰、京东、EMS、德邦等60+国内外主流快递公司。  ## 使用须知 - **自动识别**：不知道是哪家快递？系统会根据单号规则自动识别快递公司（推荐使用） - **手动指定**：如果已知快递公司，可以传递 `carrier_code` 参数，查询速度会更快 - **查询时效**：物流信息实时查询，响应时间通常在1-2秒内

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

try {
    $result = $apiInstance->getMiscTrackingQuery($tracking_number, $carrier_code);
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
getMiscWeather($city, $adcode): \OpenAPI\Client\Model\GetMiscWeather200Response
```

查询实时天气信息

出门前，查一下天气总是个好习惯。这个接口为你提供精准、实时的天气数据。  ## 功能概述 你可以通过城市名称或高德地图的Adcode来查询指定地区的实时天气状况，包括天气现象、温度、湿度、风向和风力等。  ## 使用须知 - **参数优先级**：当你同时提供了 `city` (城市名) 和 `adcode` (城市编码) 两个参数时，系统会 **优先使用 `adcode`** 进行查询，因为它更精确。 - **查询范围**：为了保证查询的准确性，我们的服务仅支持标准的“省”、“市”、“区/县”级别的行政区划名称查询，不保证能查询到乡镇或具体地点。  ## 错误处理指南 - **410 Gone**: 这个特殊的错误码意味着你查询的地区无效或不受我们支持。比如你输入了“火星”，或者某个我们无法识别的村庄名称。这个状态码告诉你，这个“资源”是永久性地不可用了。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\MiscApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$city = 北京; // string | 标准的城市名称，如 '北京', '上海市', '福田区'。请使用官方的省、市、区县行政区划名称。
$adcode = 110000; // string | 高德地图的6位数字城市编码。例如，北京市的Adcode是 '110000'。使用Adcode查询更准确、更快速。

try {
    $result = $apiInstance->getMiscWeather($city, $adcode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MiscApi->getMiscWeather: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **city** | **string**| 标准的城市名称，如 &#39;北京&#39;, &#39;上海市&#39;, &#39;福田区&#39;。请使用官方的省、市、区县行政区划名称。 | [optional] |
| **adcode** | **string**| 高德地图的6位数字城市编码。例如，北京市的Adcode是 &#39;110000&#39;。使用Adcode查询更准确、更快速。 | [optional] |

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

查询全球任意时区的时间

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
