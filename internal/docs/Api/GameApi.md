# OpenAPI\Client\GameApi

提供一系列与游戏相关的查询服务，涵盖 Minecraft、Steam 等平台。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getGameEpicFree()**](GameApi.md#getGameEpicFree) | **GET** /game/epic-free | 获取Epic Games免费游戏 |
| [**getGameMinecraftHistoryid()**](GameApi.md#getGameMinecraftHistoryid) | **GET** /game/minecraft/historyid | 查询Minecraft玩家历史用户名 |
| [**getGameMinecraftServerstatus()**](GameApi.md#getGameMinecraftServerstatus) | **GET** /game/minecraft/serverstatus | 查询Minecraft服务器状态 |
| [**getGameMinecraftUserinfo()**](GameApi.md#getGameMinecraftUserinfo) | **GET** /game/minecraft/userinfo | 查询Minecraft玩家信息 |
| [**getGameSteamSummary()**](GameApi.md#getGameSteamSummary) | **GET** /game/steam/summary | 获取Steam用户公开摘要 |


## `getGameEpicFree()`

```php
getGameEpicFree(): \OpenAPI\Client\Model\GetGameEpicFree200Response
```

获取Epic Games免费游戏

白嫖党的福音来了！想第一时间知道Epic商店本周送了哪些游戏大作吗？  ## 功能概述 这个接口帮你实时追踪Epic Games商店的每周免费游戏活动。无需任何参数，调用后即可获得当前所有免费游戏的完整信息，包括游戏封面、原价、剩余时间等，再也不用担心错过心仪的免费游戏了！  ## 使用场景 - 开发游戏资讯应用或网站 - 制作Epic免费游戏推送机器人 - 为用户提供游戏收藏建议 - 构建个人游戏库管理工具  > [!TIP] > **关于时间格式** > 为了方便不同场景的使用，我们同时提供了可读的时间字符串（如 `2025/01/10 00:00:00`）和13位毫秒时间戳。前端显示用字符串，程序逻辑用时间戳

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getGameEpicFree();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameEpicFree: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetGameEpicFree200Response**](../Model/GetGameEpicFree200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGameMinecraftHistoryid()`

```php
getGameMinecraftHistoryid($uuid): \OpenAPI\Client\Model\GetGameMinecraftHistoryid200Response
```

查询Minecraft玩家历史用户名

想知道某个大佬以前叫什么名字吗？这个接口可以帮你追溯一个 Minecraft 玩家的“黑历史”！  ## 功能概述 通过提供一个玩家的 UUID，你可以获取到该玩家所有曾用名及其变更时间的列表。这对于识别回归的老玩家或者社区管理非常有用。  ## 使用须知 > [!NOTE] > **UUID 格式** > 查询时，请务必提供玩家的 **32位无破折号** Minecraft UUID，例如 `ee9b4ed1aac1491eb7611471be374b80`。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$uuid = ee9b4ed1aac1491eb7611471be374b80; // string | 玩家的 Minecraft UUID，请务必使用32位无破折号的格式。

try {
    $result = $apiInstance->getGameMinecraftHistoryid($uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftHistoryid: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **uuid** | **string**| 玩家的 Minecraft UUID，请务必使用32位无破折号的格式。 | |

### Return type

[**\OpenAPI\Client\Model\GetGameMinecraftHistoryid200Response**](../Model/GetGameMinecraftHistoryid200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGameMinecraftServerstatus()`

```php
getGameMinecraftServerstatus($server): \OpenAPI\Client\Model\GetGameMinecraftServerstatus200Response
```

查询Minecraft服务器状态

想在加入服务器前看看有多少人在线？或者检查一下服务器开没开？用这个接口就对了！  ## 功能概述 你可以通过提供服务器地址（域名或IP），来获取一个 Minecraft Java 版服务器的实时状态。返回信息非常丰富，包括服务器是否在线、当前玩家数、最大玩家数、服务器版本、MOTD（每日消息）以及服务器图标等。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$server = hypixel.net; // string | Minecraft服务器的地址，可以是域名（如 `hypixel.net`）或 `IP:端口` 的形式（如 `mc.example.com:25565`）。如果省略端口，将默认使用 `25565`。

try {
    $result = $apiInstance->getGameMinecraftServerstatus($server);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftServerstatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **server** | **string**| Minecraft服务器的地址，可以是域名（如 &#x60;hypixel.net&#x60;）或 &#x60;IP:端口&#x60; 的形式（如 &#x60;mc.example.com:25565&#x60;）。如果省略端口，将默认使用 &#x60;25565&#x60;。 | |

### Return type

[**\OpenAPI\Client\Model\GetGameMinecraftServerstatus200Response**](../Model/GetGameMinecraftServerstatus200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGameMinecraftUserinfo()`

```php
getGameMinecraftUserinfo($username): \OpenAPI\Client\Model\GetGameMinecraftUserinfo200Response
```

查询Minecraft玩家信息

只需要一个玩家的用户名，就能快速获取到他的正版皮肤和独一无二的UUID！  ## 功能概述 这是一个基础但非常实用的接口。通过玩家当前的游戏内名称（Username），你可以查询到他对应的UUID（唯一标识符）和当前皮肤的URL地址。这是构建许多其他玩家相关服务的第一步。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$username = Notch; // string | 玩家的 Minecraft 游戏内名称（正版ID）。

try {
    $result = $apiInstance->getGameMinecraftUserinfo($username);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftUserinfo: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **username** | **string**| 玩家的 Minecraft 游戏内名称（正版ID）。 | |

### Return type

[**\OpenAPI\Client\Model\GetGameMinecraftUserinfo200Response**](../Model/GetGameMinecraftUserinfo200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGameSteamSummary()`

```php
getGameSteamSummary($steamid, $id, $id3, $key): \OpenAPI\Client\Model\GetGameSteamSummary200Response
```

获取Steam用户公开摘要

想在你的网站或应用中展示用户的 Steam 个人资料？这个接口就是为你准备的。  ## 功能概述 通过一个用户的 Steam 标识（支持多种格式），你可以获取到他公开的个人资料摘要，包括昵称、头像、在线状态、真实姓名（如果公开）和个人资料主页URL等信息。  ## 支持的参数格式 接口现在支持以下几种标识符格式： - **`steamid`**: 64位SteamID（如 `76561197960287930`） - **`id`**: 自定义URL名称（如 `gabelogannewell`） - **`id3`**: Steam ID3格式（如 `STEAM_0:0:22202`） - 完整的个人资料链接 - 好友代码  ## 使用须知  > [!IMPORTANT] > **API Key 安全** > 此接口需要一个 Steam Web API Key。我们强烈建议由后端统一配置和调用，以避免在客户端泄露。当然，你也可以通过 `key` 查询参数临时提供一个Key来覆盖后端配置。  在处理响应时，请注意以下数字代码的含义： - **`personastate` (用户状态)**: 0-离线, 1-在线, 2-忙碌, 3-离开, 4-打盹, 5-想交易, 6-想玩。 - **`communityvisibilitystate` (社区可见性)**: 1-私密, 3-公开 (API通常只能查到这两种状态)。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$steamid = 76561197960287930; // string | 用户的 Steam 标识。可以是以下任意一种格式： - 纯数字的 **SteamID64** - 用户的 **自定义 URL 名称** (Vanity URL) - 完整的 **个人资料链接** (包含 SteamID64 或自定义名称) - 好友代码 (如 `22202`)
$id = gabelogannewell; // string | 用户的 Steam 自定义URL名称（Vanity URL）。例如个人资料链接中 `/id/` 后面的部分。
$id3 = STEAM_0:0:22202; // string | 用户的 Steam ID3 格式标识符。传统的 Steam ID 格式，形如 STEAM_X:Y:Z。
$key = 'key_example'; // string | 你的 Steam Web API Key。这是一个可选参数，如果提供，它将覆盖我们在后端配置的全局Key。这为你提供了更大的灵活性，但请务必注意Key的保密，不要在前端暴露。

try {
    $result = $apiInstance->getGameSteamSummary($steamid, $id, $id3, $key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameSteamSummary: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **steamid** | **string**| 用户的 Steam 标识。可以是以下任意一种格式： - 纯数字的 **SteamID64** - 用户的 **自定义 URL 名称** (Vanity URL) - 完整的 **个人资料链接** (包含 SteamID64 或自定义名称) - 好友代码 (如 &#x60;22202&#x60;) | [optional] |
| **id** | **string**| 用户的 Steam 自定义URL名称（Vanity URL）。例如个人资料链接中 &#x60;/id/&#x60; 后面的部分。 | [optional] |
| **id3** | **string**| 用户的 Steam ID3 格式标识符。传统的 Steam ID 格式，形如 STEAM_X:Y:Z。 | [optional] |
| **key** | **string**| 你的 Steam Web API Key。这是一个可选参数，如果提供，它将覆盖我们在后端配置的全局Key。这为你提供了更大的灵活性，但请务必注意Key的保密，不要在前端暴露。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetGameSteamSummary200Response**](../Model/GetGameSteamSummary200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
