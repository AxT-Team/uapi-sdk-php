# OpenAPI\Client\WebParseApi

提供网页内容解析和提取的工具。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getWebTomarkdownAsyncStatus()**](WebParseApi.md#getWebTomarkdownAsyncStatus) | **GET** /web/tomarkdown/async/{task_id} | 转换任务状态 |
| [**getWebparseExtractimages()**](WebParseApi.md#getWebparseExtractimages) | **GET** /webparse/extractimages | 提取网页图片 |
| [**getWebparseMetadata()**](WebParseApi.md#getWebparseMetadata) | **GET** /webparse/metadata | 提取网页元数据 |
| [**postWebTomarkdownAsync()**](WebParseApi.md#postWebTomarkdownAsync) | **POST** /web/tomarkdown/async | 网页转 Markdown |


## `getWebTomarkdownAsyncStatus()`

```php
getWebTomarkdownAsyncStatus($task_id): \OpenAPI\Client\Model\GetWebTomarkdownAsyncStatus200Response
```

转换任务状态

提交了网页转 Markdown 任务后，想知道处理进度和结果？用这个接口来查询。  ## 功能概述 通过任务 ID 查询转换任务的当前状态、处理进度和最终结果。任务结果缓存 30 分钟，期间可重复查询。  ## 任务状态  | 状态 | 说明 | |------|------| | `pending` | 等待处理 | | `processing` | 处理中 | | `completed` | 已完成，可获取结果 | | `failed` | 失败 | | `timeout` | 超时（超过 60 秒） |  > [!NOTE] > 建议每 2-5 秒轮询一次，当状态为 `completed`、`failed` 或 `timeout` 时停止轮询。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebParseApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$task_id = a1b2c3d4-e5f6-47a8-b9c0-d1e2f3a4b5c6; // string | 任务ID（由提交接口返回）

try {
    $result = $apiInstance->getWebTomarkdownAsyncStatus($task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebParseApi->getWebTomarkdownAsyncStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **task_id** | **string**| 任务ID（由提交接口返回） | |

### Return type

[**\OpenAPI\Client\Model\GetWebTomarkdownAsyncStatus200Response**](../Model/GetWebTomarkdownAsyncStatus200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getWebparseExtractimages()`

```php
getWebparseExtractimages($url): \OpenAPI\Client\Model\GetWebparseExtractimages200Response
```

提取网页图片

想批量获取一个网页上的所有图片链接？这个接口帮你搞定。  ## 功能概述 提供一个网页 URL，返回该页面中所有图片的链接列表。适合用于图片采集、素材下载等场景。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebParseApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$url = https://cn.bing.com/; // string | 需要提取图片的网页URL

try {
    $result = $apiInstance->getWebparseExtractimages($url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebParseApi->getWebparseExtractimages: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **url** | **string**| 需要提取图片的网页URL | |

### Return type

[**\OpenAPI\Client\Model\GetWebparseExtractimages200Response**](../Model/GetWebparseExtractimages200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getWebparseMetadata()`

```php
getWebparseMetadata($url): \OpenAPI\Client\Model\GetWebparseMetadata200Response
```

提取网页元数据

想在应用里做链接预览卡片？这个接口帮你一键获取网页的标题、描述、图标等信息。  ## 功能概述 提供一个网页 URL，返回该页面的元数据，包括标题、描述、关键词、Favicon、Open Graph 信息等。非常适合用于生成链接预览卡片或做 SEO 分析。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebParseApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$url = https://www.bilibili.com; // string | 需要提取元数据的网页URL

try {
    $result = $apiInstance->getWebparseMetadata($url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebParseApi->getWebparseMetadata: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **url** | **string**| 需要提取元数据的网页URL | |

### Return type

[**\OpenAPI\Client\Model\GetWebparseMetadata200Response**](../Model/GetWebparseMetadata200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postWebTomarkdownAsync()`

```php
postWebTomarkdownAsync($url): \OpenAPI\Client\Model\PostWebTomarkdownAsync202Response
```

网页转 Markdown

想把一个网页的内容转成干净的 Markdown 文本？这个异步接口可以帮你搞定，特别适合处理大型或复杂的网页。  ## 功能概述  > [!VIP] > 本 API 目前处于**限时免费**阶段，未来将转为付费服务。  提交一个网页 URL，我们会自动抓取主体内容，剔除广告、导航栏等干扰元素，并转换为 Markdown 格式。同时会提取标题、作者、发布日期等元数据，生成 YAML Front Matter。  任务提交后会立即返回任务 ID，你可以用它来查询处理进度和结果。单个任务最长处理 60 秒，结果缓存 30 分钟。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\WebParseApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$url = https://example.com; // string | 需要转换的网页URL。URL必须经过编码。

try {
    $result = $apiInstance->postWebTomarkdownAsync($url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebParseApi->postWebTomarkdownAsync: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **url** | **string**| 需要转换的网页URL。URL必须经过编码。 | |

### Return type

[**\OpenAPI\Client\Model\PostWebTomarkdownAsync202Response**](../Model/PostWebTomarkdownAsync202Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
