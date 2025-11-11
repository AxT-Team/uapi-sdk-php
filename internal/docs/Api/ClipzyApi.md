# OpenAPI\Client\ClipzyApi



All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getClipzyGet()**](ClipzyApi.md#getClipzyGet) | **GET** /api/get | 步骤2 (方法一): 获取加密数据 |
| [**getClipzyRaw()**](ClipzyApi.md#getClipzyRaw) | **GET** /api/raw/{id} | 步骤2 (方法二): 获取原始文本 |
| [**postClipzyStore()**](ClipzyApi.md#postClipzyStore) | **POST** /api/store | 步骤1：上传加密数据 |


## `getClipzyGet()`

```php
getClipzyGet($id): \OpenAPI\Client\Model\GetClipzyGet200Response
```
### URI(s):
- https://paste.sdjz.wiki 
步骤2 (方法一): 获取加密数据

**此接口用于“最高安全等级”方法。**  您提供第一步中获得的ID，它会返回存储在服务器上的**加密数据**。您需要在自己的客户端中，使用您自己保管的密钥来解密它。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ClipzyApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = PREF0Zv8Yj; // string | 片段的唯一 ID。

$hostIndex = 0;
$variables = [
];

try {
    $result = $apiInstance->getClipzyGet($id, $hostIndex, $variables);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ClipzyApi->getClipzyGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| 片段的唯一 ID。 | |
| hostIndex | null|int | Host index. Defaults to null. If null, then the library will use $this->hostIndex instead | [optional] |
| variables | array | Associative array of variables to pass to the host. Defaults to empty array. | [optional] |

### Return type

[**\OpenAPI\Client\Model\GetClipzyGet200Response**](../Model/GetClipzyGet200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getClipzyRaw()`

```php
getClipzyRaw($id, $key): string
```
### URI(s):
- https://paste.sdjz.wiki 
步骤2 (方法二): 获取原始文本

**此接口用于“方便自动化”方法。**  您提供第一步获得的ID，并附上您自己保管的**解密密钥**作为 `key` 参数。服务器会直接为您解密，并返回纯文本内容。  > [!IMPORTANT] > 查看文档首页的 **cURL 示例**，了解此接口最典型的用法。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ClipzyApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = PREF0Zv8Yj; // string | 片段的唯一 ID。
$key = ES9tGP0v3e7oqzmAk3vMboxVOOBlvw9RS3DszeW675k=; // string | 用于解密的 Base64 编码的 AES 密钥。

$hostIndex = 0;
$variables = [
];

try {
    $result = $apiInstance->getClipzyRaw($id, $key, $hostIndex, $variables);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ClipzyApi->getClipzyRaw: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| 片段的唯一 ID。 | |
| **key** | **string**| 用于解密的 Base64 编码的 AES 密钥。 | |
| hostIndex | null|int | Host index. Defaults to null. If null, then the library will use $this->hostIndex instead | [optional] |
| variables | array | Associative array of variables to pass to the host. Defaults to empty array. | [optional] |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/plain`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postClipzyStore()`

```php
postClipzyStore($post_clipzy_store_request): \OpenAPI\Client\Model\PostClipzyStore200Response
```
### URI(s):
- https://paste.sdjz.wiki 
步骤1：上传加密数据

这是所有流程的第一步。您的客户端应用需要先在本地准备好 **加密后的数据**，然后调用此接口进行上传。成功后，您会得到一个用于后续操作的唯一ID。  > [!NOTE] > 您发送给此接口的应该是**密文**，而不是原始文本。请参考文档首页的JavaScript示例来了解如何在客户端进行加密。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ClipzyApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_clipzy_store_request = new \OpenAPI\Client\Model\PostClipzyStoreRequest(); // \OpenAPI\Client\Model\PostClipzyStoreRequest | 包含加密数据和可选的TTL。

$hostIndex = 0;
$variables = [
];

try {
    $result = $apiInstance->postClipzyStore($post_clipzy_store_request, $hostIndex, $variables);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ClipzyApi->postClipzyStore: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_clipzy_store_request** | [**\OpenAPI\Client\Model\PostClipzyStoreRequest**](../Model/PostClipzyStoreRequest.md)| 包含加密数据和可选的TTL。 | |
| hostIndex | null|int | Host index. Defaults to null. If null, then the library will use $this->hostIndex instead | [optional] |
| variables | array | Associative array of variables to pass to the host. Defaults to empty array. | [optional] |

### Return type

[**\OpenAPI\Client\Model\PostClipzyStore200Response**](../Model/PostClipzyStore200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
