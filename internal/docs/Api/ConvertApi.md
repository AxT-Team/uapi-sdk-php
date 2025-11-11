# OpenAPI\Client\ConvertApi

提供一系列便捷的数据格式转换工具，帮你处理开发中常见的数据转换任务。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getConvertUnixtime()**](ConvertApi.md#getConvertUnixtime) | **GET** /convert/unixtime | Unix时间戳与日期字符串双向转换 |
| [**postConvertJson()**](ConvertApi.md#postConvertJson) | **POST** /convert/json | 美化并格式化JSON字符串 |


## `getConvertUnixtime()`

```php
getConvertUnixtime($time): \OpenAPI\Client\Model\GetConvertUnixtime200Response
```

Unix时间戳与日期字符串双向转换

时间戳和日期字符串，哪个用着更顺手？别纠结了，这个接口让你轻松拥有两种格式！  ## 功能概述 这是一个非常智能的转换器。你给它一个 Unix 时间戳，它还你一个人类可读的日期时间；你给它一个日期时间字符串，它还你一个 Unix 时间戳。它会自动识别你输入的是哪种格式。  ## 使用须知 这个接口非常智能，能够自动识别输入格式：  - **输入时间戳**：支持10位秒级（如 `1672531200`）和13位毫秒级（如 `1672531200000`）。 - **输入日期字符串**：为了确保准确性，推荐使用 `YYYY-MM-DD HH:mm:ss` 标准格式（如 `2023-01-01 08:00:00`）。  > [!TIP] > 无论你输入哪种格式，响应中都会同时包含标准日期字符串和秒级Unix时间戳，方便你按需取用。  ## 错误处理指南 - **400 Bad Request**: 如果你提供的 `time` 参数既不是有效的时间戳，也不是我们支持的日期格式，就会收到这个错误。请检查你的输入值。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ConvertApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$time = 1698380645; // string | 一个智能时间参数，可传入Unix时间戳（10位或13位）或标准日期字符串（如 '2023-10-27 10:30:00'），系统将自动识别并转换。

try {
    $result = $apiInstance->getConvertUnixtime($time);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConvertApi->getConvertUnixtime: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **time** | **string**| 一个智能时间参数，可传入Unix时间戳（10位或13位）或标准日期字符串（如 &#39;2023-10-27 10:30:00&#39;），系统将自动识别并转换。 | |

### Return type

[**\OpenAPI\Client\Model\GetConvertUnixtime200Response**](../Model/GetConvertUnixtime200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postConvertJson()`

```php
postConvertJson($post_convert_json_request): \OpenAPI\Client\Model\PostConvertJson200Response
```

美化并格式化JSON字符串

还在为一团乱麻的 JSON 字符串头疼吗？这个接口能瞬间让它变得井井有条，赏心悦目。  ## 功能概述 你只需要提供一个原始的、可能是压缩过的或者格式混乱的 JSON 字符串，这个 API 就会返回一个经过美化（带标准缩进和换行）的版本。这在调试 API 响应、或者需要在前端界面清晰展示 JSON 数据时非常有用。  ## 使用须知 > [!NOTE] > **请求格式** > 请注意，待格式化的 JSON 字符串需要被包裹在另一个 JSON 对象中，作为 `content` 字段的值提交。具体格式请参考请求体示例。  ## 错误处理指南 - **400 Bad Request**: 最常见的原因是你提供的 `content` 字符串本身不是一个有效的 JSON。请仔细检查括号、引号是否正确闭合，或者有没有多余的逗号等语法错误。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ConvertApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_convert_json_request = new \OpenAPI\Client\Model\PostConvertJsonRequest(); // \OpenAPI\Client\Model\PostConvertJsonRequest | 这是一个JSON对象，里面必须包含一个名为 `content` 的字段。这个字段的值，就是你希望格式化的、原始的JSON字符串。

try {
    $result = $apiInstance->postConvertJson($post_convert_json_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConvertApi->postConvertJson: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_convert_json_request** | [**\OpenAPI\Client\Model\PostConvertJsonRequest**](../Model/PostConvertJsonRequest.md)| 这是一个JSON对象，里面必须包含一个名为 &#x60;content&#x60; 的字段。这个字段的值，就是你希望格式化的、原始的JSON字符串。 | |

### Return type

[**\OpenAPI\Client\Model\PostConvertJson200Response**](../Model/PostConvertJson200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
