# OpenAPI\Client\PoemApi



All URIs are relative to https://uapis.cn, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getSaying()**](PoemApi.md#getSaying) | **GET** /saying | 一言 |
| [**getSayingRandom()**](PoemApi.md#getSayingRandom) | **GET** /saying/random | 一言（随机/每日/场景/此刻） |


## `getSaying()`

```php
getSaying(): \OpenAPI\Client\Model\GetSaying200Response
```

一言

想在你的应用里每天展示一句不一样的话，给用户一点小小的惊喜吗？这个“一言”接口就是为此而生。  ## 功能概述 每次调用，它都会从我们精心收集的、包含数千条诗词、动漫台词、名人名言的语料库中，随机返回一条。你可以用它来做网站首页的Slogan、应用的启动语，或者任何需要灵感点缀的地方。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PoemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getSaying();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PoemApi->getSaying: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetSaying200Response**](../Model/GetSaying200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getSayingRandom()`

```php
getSayingRandom($mode, $scene, $source, $category, $tag): \OpenAPI\Client\Model\GetSayingRandom200Response
```

一言（随机/每日/场景/此刻）

一言接口，返回一条随机语录。通过 `mode` 参数切换四种返回方式，并支持按来源、分类、标签过滤。  ## 四种模式（`mode`） - **`random`（默认）**：每次调用随机返回一条语录。 - **`daily`**：同一天内返回固定的同一条，适合每日打卡、签到等场景。 - **`recommend`**：配合 `scene` 参数，返回指定场景（如 `night`、`morning`）的语录。 - **`moment`**：根据请求时所处时段，自动返回应景语录。  ## 语言控制 语料分中英文两类，可通过 `source` 或 `category` 控制： - 需要中文：`source` 选「综合句子语料库 / 曹星宇句子集」，或 `category` 选中文分类（如 影视、文学、诗词）。 - 需要英文：`source` 选「Quotable / 英文历史名言」。  ## 使用须知 > [!NOTE] > - `source`、`category`、`tag` 支持多值，用英文逗号 `,` 或分号 `;` 分隔。 > - `scene` 仅在 `mode=recommend` 时生效且必填，其他模式下会被忽略。 > - 请求示例： >   - 随机：`GET /api/v1/saying/random` >   - 每日：`GET /api/v1/saying/random?mode=daily` >   - 场景：`GET /api/v1/saying/random?mode=recommend&scene=night` >   - 此刻：`GET /api/v1/saying/random?mode=moment`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\PoemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$mode = 'random'; // string | 运行模式。不传或 random 为随机一言；可选 daily、recommend、moment。
$scene = 'scene_example'; // string | 推荐场景。当 mode=recommend 时必填，例如 night、morning、work 等。请从[支持的场景列表](#enum-list)中选择。
$source = 'source_example'; // string | 语料来源过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的来源列表](#enum-list)中选择。
$category = 'category_example'; // string | 分类过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的分类列表](#enum-list)中选择。
$tag = 'tag_example'; // string | 标签过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的标签列表](#enum-list)中选择。

try {
    $result = $apiInstance->getSayingRandom($mode, $scene, $source, $category, $tag);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PoemApi->getSayingRandom: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **mode** | **string**| 运行模式。不传或 random 为随机一言；可选 daily、recommend、moment。 | [optional] [default to &#39;random&#39;] |
| **scene** | **string**| 推荐场景。当 mode&#x3D;recommend 时必填，例如 night、morning、work 等。请从[支持的场景列表](#enum-list)中选择。 | [optional] |
| **source** | **string**| 语料来源过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的来源列表](#enum-list)中选择。 | [optional] |
| **category** | **string**| 分类过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的分类列表](#enum-list)中选择。 | [optional] |
| **tag** | **string**| 标签过滤。支持重复传参，或使用逗号/分号分隔多个值。请从[支持的标签列表](#enum-list)中选择。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetSayingRandom200Response**](../Model/GetSayingRandom200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
