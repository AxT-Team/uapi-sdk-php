# OpenAPI\Client\PoemApi

提供与诗词、名言相关的API，为你的应用增添一抹人文色彩。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getSaying()**](PoemApi.md#getSaying) | **GET** /saying | 随机获取一句诗词或名言 |


## `getSaying()`

```php
getSaying(): \OpenAPI\Client\Model\GetSaying200Response
```

随机获取一句诗词或名言

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
