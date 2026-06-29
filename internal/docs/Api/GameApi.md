# OpenAPI\Client\GameApi



All URIs are relative to https://uapis.cn, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getGameEpicFree()**](GameApi.md#getGameEpicFree) | **GET** /game/epic-free | Epic 免费游戏 |
| [**getGameMinecraftHistoryid()**](GameApi.md#getGameMinecraftHistoryid) | **GET** /game/minecraft/historyid | 查询 MC 曾用名 |
| [**getGameMinecraftMods()**](GameApi.md#getGameMinecraftMods) | **GET** /game/minecraft/mods | 搜索 MC Mod/插件 |
| [**getGameMinecraftServerstatus()**](GameApi.md#getGameMinecraftServerstatus) | **GET** /game/minecraft/serverstatus | 查询 MC 服务器 |
| [**getGameMinecraftUserinfo()**](GameApi.md#getGameMinecraftUserinfo) | **GET** /game/minecraft/userinfo | 查询 MC 玩家 |
| [**getGameMinecraftVersion()**](GameApi.md#getGameMinecraftVersion) | **GET** /game/minecraft/version | Minecraft 最新版本 |
| [**getGameSteamServers()**](GameApi.md#getGameSteamServers) | **GET** /game/steam/servers | 查询 Steam 游戏服务器 |
| [**getGameSteamSummary()**](GameApi.md#getGameSteamSummary) | **GET** /game/steam/summary | 查询 Steam 用户 |


## `getGameEpicFree()`

```php
getGameEpicFree(): \OpenAPI\Client\Model\GetGameEpicFree200Response
```

Epic 免费游戏

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
getGameMinecraftHistoryid($name, $uuid): \OpenAPI\Client\Model\GetGameMinecraftHistoryid200Response
```

查询 MC 曾用名

想知道某个大佬以前叫什么名字吗？这个接口可以帮你追溯一个 Minecraft 玩家的“黑历史”！  ## 功能概述 通过提供玩家的用户名或 UUID，你可以获取到该玩家所有曾用名及其变更时间的列表。这对于识别回归的老玩家或者社区管理非常有用。  ## 使用须知 > [!NOTE] > **参数说明** > - `name` 和 `uuid` 二选一 > - UUID 支持带连字符（如 `ee9b4ed1-aac1-491e-b761-1471be374b80`）或不带连字符格式  > [!IMPORTANT] > **响应结构差异** > - 使用 `uuid` 查询：返回单个用户的历史记录 > - 使用 `name` 查询：返回所有匹配用户的列表（包括当前用户名或曾用名匹配的玩家），需判断响应中是否有 `results` 字段来区分两种模式

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$name = ExamplePlayer; // string | 玩家的 Minecraft 用户名。使用此参数查询时，会返回所有匹配用户的列表（包括当前用户名或曾用名匹配的玩家）。
$uuid = ee9b4ed1-aac1-491e-b761-1471be374b80; // string | 玩家的 Minecraft UUID，支持带连字符或不带连字符格式。

try {
    $result = $apiInstance->getGameMinecraftHistoryid($name, $uuid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftHistoryid: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **name** | **string**| 玩家的 Minecraft 用户名。使用此参数查询时，会返回所有匹配用户的列表（包括当前用户名或曾用名匹配的玩家）。 | [optional] |
| **uuid** | **string**| 玩家的 Minecraft UUID，支持带连字符或不带连字符格式。 | [optional] |

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

## `getGameMinecraftMods()`

```php
getGameMinecraftMods($query, $source, $type, $limit, $enrich): \OpenAPI\Client\Model\GetGameMinecraftMods200Response
```

搜索 MC Mod/插件

想给你的启动器、服务器面板或资源推荐页加上 Mod/插件搜索？这个接口一次帮你检索 Modrinth 与 SpigotMC 上的资源。  ## 功能概述 传入关键词，即可拿到资源名称、简介、作者、下载量、评分、项目页和下载地址。可以用 `source` 指定只搜某个平台，用 `type` 过滤资源类型，用 `limit` 控制每个平台返回的数量。  ## 使用须知 > [!NOTE] > 默认会补全作者名与下载直链。如果只想要更快的基础搜索结果，设置 `enrich=false` 即可降低延迟。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$query = sodium; // string | 搜索关键词，也可使用别名 `q`。
$source = 'all'; // string | 搜索来源，默认 all。
$type = mod; // string | 资源类型过滤，例如 mod 或 plugin。
$limit = 10; // int | 每个来源返回的最大条数，默认 10，最大 50。
$enrich = true; // bool | 是否补全下载直链与作者名，默认 true；传 false 可降低延迟。

try {
    $result = $apiInstance->getGameMinecraftMods($query, $source, $type, $limit, $enrich);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftMods: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **query** | **string**| 搜索关键词，也可使用别名 &#x60;q&#x60;。 | |
| **source** | **string**| 搜索来源，默认 all。 | [optional] [default to &#39;all&#39;] |
| **type** | **string**| 资源类型过滤，例如 mod 或 plugin。 | [optional] |
| **limit** | **int**| 每个来源返回的最大条数，默认 10，最大 50。 | [optional] [default to 10] |
| **enrich** | **bool**| 是否补全下载直链与作者名，默认 true；传 false 可降低延迟。 | [optional] [default to true] |

### Return type

[**\OpenAPI\Client\Model\GetGameMinecraftMods200Response**](../Model/GetGameMinecraftMods200Response.md)

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

查询 MC 服务器

想在加入服务器前看看有多少人在线？或者检查一下服务器开没开？用这个接口就对了！  ## 功能概述 你可以通过提供服务器地址（域名或IP），来获取一个 Minecraft Java 版服务器的实时状态。返回信息包括服务器是否在线、当前玩家数、最大玩家数、服务器版本、MOTD（每日消息）以及服务器图标等。  如果服务器返回当前在线玩家列表，响应里还会带上 `online_players` 字段。这个字段可能省略，部分服务器返回的列表也可能不完整。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$server = play.minedhype.com; // string | Minecraft服务器的地址，可以是域名（如 `hypixel.net`）或 `IP:端口` 的形式（如 `mc.example.com:25565`）。如果省略端口，将默认使用 `25565`。

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

查询 MC 玩家

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

## `getGameMinecraftVersion()`

```php
getGameMinecraftVersion(): \OpenAPI\Client\Model\GetGameMinecraftVersion200Response
```

Minecraft 最新版本

需要在启动器、服务器面板或机器人里实时显示 Minecraft 的最新版本？这个接口帮你一键拿到当前的正式版和快照版。  ## 功能概述 无需任何参数，直接返回最新正式版（latest release）、最新快照版（latest snapshot）以及完整的版本列表。适合做版本提示、更新检测或服务端版本看板。  ## 使用须知 > [!NOTE] > 数据会随新版本发布而更新，建议在客户端适当缓存，无需高频轮询。

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
    $result = $apiInstance->getGameMinecraftVersion();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameMinecraftVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetGameMinecraftVersion200Response**](../Model/GetGameMinecraftVersion200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getGameSteamServers()`

```php
getGameSteamServers($appid, $name, $limit): \OpenAPI\Client\Model\GetGameSteamServers200Response
```

查询 Steam 游戏服务器

想在自己的面板或社区里展示某款游戏的在线服务器？这个接口支持查询使用 A2S/Steam 服务器列表的多人游戏，例如 SCUM、ARK、Rust、CS2 等。  ## 功能概述 传入游戏的 Steam AppID，即可获取当前在线的服务器列表，包含名称、IP、端口、当前/最大人数、地图等信息。你还可以用 `name` 做服务器名称模糊搜索，用 `limit` 控制返回数量。  ## 常见 AppID - SCUM：`513710` - ARK：`346110` - Rust：`252490` - Counter-Strike 2：`730`  ## 使用须知 > [!NOTE] > 不确定游戏的 AppID？可以在 Steam 商店页地址中找到，或参考上面的常见 AppID 列表。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\GameApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$appid = 513710; // int | Steam 游戏 AppID，必须是正整数。
$name = SCUM; // string | 服务器名称关键词，可选，支持模糊搜索。
$limit = 20; // int | 返回数量上限，默认 20，最大 100。

try {
    $result = $apiInstance->getGameSteamServers($appid, $name, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GameApi->getGameSteamServers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **appid** | **int**| Steam 游戏 AppID，必须是正整数。 | |
| **name** | **string**| 服务器名称关键词，可选，支持模糊搜索。 | [optional] |
| **limit** | **int**| 返回数量上限，默认 20，最大 100。 | [optional] [default to 20] |

### Return type

[**\OpenAPI\Client\Model\GetGameSteamServers200Response**](../Model/GetGameSteamServers200Response.md)

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

查询 Steam 用户

想在你的网站或应用中展示用户的 Steam 个人资料？这个接口就是为你准备的。  ## 功能概述 通过一个用户的 Steam 标识（支持多种格式），你可以获取到他公开的个人资料摘要，包括昵称、头像、在线状态、真实姓名（如果公开）和个人资料主页URL等信息。  ## 支持的参数格式 接口现在支持以下几种标识符格式： - **`steamid`**: 64位SteamID（如 `76561197960287930`） - **`id`**: 自定义URL名称（如 `gabelogannewell`） - **`id3`**: Steam ID3格式（如 `STEAM_0:0:22202`） - 完整的个人资料链接 - 好友代码  ## 使用须知  > [!IMPORTANT] > **访问凭证说明** > 这个接口可以传 `key` 使用您自己的访问凭证。如果您选择传入，请注意妥善保管，不要把它写进公开的前端代码中。  在处理响应时，请注意以下数字代码的含义： - **`personastate` (用户状态)**: 0-离线, 1-在线, 2-忙碌, 3-离开, 4-打盹, 5-想交易, 6-想玩。 - **`communityvisibilitystate` (社区可见性)**: 1-私密, 3-公开 (API通常只能查到这两种状态)。

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
$key = 'key_example'; // string | 这个接口可以传的访问凭证。此参数选填，如果传入，将优先使用您提供的值。请注意妥善保管，不要把它写进公开的前端代码中。

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
| **key** | **string**| 这个接口可以传的访问凭证。此参数选填，如果传入，将优先使用您提供的值。请注意妥善保管，不要把它写进公开的前端代码中。 | [optional] |

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
