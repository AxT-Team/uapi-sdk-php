# OpenAPI\Client\RandomApi

提供各种随机内容生成器，从随机字符串到随机图片。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAnswerbookAsk()**](RandomApi.md#getAnswerbookAsk) | **GET** /answerbook/ask | 获取答案之书的神秘答案 (GET) |
| [**getRandomImage()**](RandomApi.md#getRandomImage) | **GET** /random/image | 随机二次元、风景、动漫图片壁纸 |
| [**getRandomString()**](RandomApi.md#getRandomString) | **GET** /random/string | 生成高度可定制的随机字符串 |
| [**postAnswerbookAsk()**](RandomApi.md#postAnswerbookAsk) | **POST** /answerbook/ask | 获取答案之书的神秘答案 (POST) |


## `getAnswerbookAsk()`

```php
getAnswerbookAsk($question): \OpenAPI\Client\Model\GetAnswerbookAsk200Response
```

获取答案之书的神秘答案 (GET)

想要获得人生问题的神秘答案吗？答案之书API提供了一个神奇8球风格的问答服务，你可以提问并获得随机的神秘答案。  ## 功能概述 通过向答案之书提问，你将获得一个充满智慧（或许）的随机答案。这个API支持通过查询参数或POST请求体两种方式提问。  ## 使用须知  > [!TIP] > **提问技巧** > - 提出明确的问题会获得更好的体验 > - 问题不能为空 > - 支持中文问题 > - 答案具有随机性，仅供娱乐参考

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RandomApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$question = 我今天会有好运吗？; // string | 你想要提问的问题。问题不能为空。

try {
    $result = $apiInstance->getAnswerbookAsk($question);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RandomApi->getAnswerbookAsk: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **question** | **string**| 你想要提问的问题。问题不能为空。 | |

### Return type

[**\OpenAPI\Client\Model\GetAnswerbookAsk200Response**](../Model/GetAnswerbookAsk200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getRandomImage()`

```php
getRandomImage($category, $type): \SplFileObject
```

随机二次元、风景、动漫图片壁纸

需要一张随机图片作为占位符或者背景吗？这个接口是你的不二之选。  ## 功能概述 这是一个非常简单的接口，它会从我们庞大的图库和精选外部图床中随机挑选一张图片，然后通过 302 重定向让你直接访问到它。这使得它可以非常方便地直接用在 HTML 的 `<img>` 标签中。  你可以通过 `/api/v1/random/image?category=acg&type=4k` 这样的请求获取由UapiPro服务器提供的图片，也可以通过 `/api/v1/random/image?category=ai_drawing` 获取由外部图床精选的图片。  如果你不提供任何 category 参数，程序会从所有图片（包括本地的和URL的）中随机抽取一张（**全局随机图片不包含ikun和AI绘画**）。  > [!TIP] > 如果你需要更精确地控制图片类型，请使用 `/image/random/{category}/{type}` 接口。  ### 支持的主类别与子类别 - **UapiPro服务器图片**   - **furry**（福瑞）     - z4k     - szs8k     - s4k     - 4k   - **bq**（表情包/趣图）     - youshou     - xiongmao     - waiguoren     - maomao     - ikun     - eciyuan   - **acg**（二次元动漫）     - pc     - mb - **外部图床精选图片**   - **ai_drawing**: AI绘画。   - **general_anime**: 动漫图。   - **landscape**: 风景图。   - **mobile_wallpaper**: 手机壁纸。   - **pc_wallpaper**: 电脑壁纸。 - **混合动漫**   - **anime**: 混合了UapiPro服务器的acg和外部图床的general_anime分类下的图片。  > [!NOTE] > 默认全局随机（未指定category参数）时，不会包含ikun和AI绘画（ai_drawing）类别的图片。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RandomApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$category = acg; // string | （可选）指定图片主类别。  **支持的主类别：** - `furry`（福瑞，UapiPro服务器） - `bq`（表情包/趣图，UapiPro服务器） - `acg`（二次元动漫，UapiPro服务器） - `ai_drawing`（AI绘画，外部图床） - `general_anime`（动漫图，外部图床） - `landscape`（风景图，外部图床） - `mobile_wallpaper`（手机壁纸，外部图床） - `pc_wallpaper`（电脑壁纸，外部图床） - `anime`（混合动漫，UapiPro服务器acg + 外部图床general_anime）  > [!TIP] > 如果不指定，将从所有图片中随机抽取（不包含 `ikun` 和 `ai_drawing`）。
$type = pc; // string | （可选，仅UapiPro服务器图片支持）指定图片子类别。  - **furry**: `z4k`, `szs8k`, `s4k`, `4k` - **bq**: `youshou`, `xiongmao`, `waiguoren`, `maomao`, `ikun`, `eciyuan` - **acg**: `pc`, `mb`  > [!TIP] > 外部图床类别和 `anime` 混合类别不支持 `type` 参数。

try {
    $result = $apiInstance->getRandomImage($category, $type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RandomApi->getRandomImage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **category** | **string**| （可选）指定图片主类别。  **支持的主类别：** - &#x60;furry&#x60;（福瑞，UapiPro服务器） - &#x60;bq&#x60;（表情包/趣图，UapiPro服务器） - &#x60;acg&#x60;（二次元动漫，UapiPro服务器） - &#x60;ai_drawing&#x60;（AI绘画，外部图床） - &#x60;general_anime&#x60;（动漫图，外部图床） - &#x60;landscape&#x60;（风景图，外部图床） - &#x60;mobile_wallpaper&#x60;（手机壁纸，外部图床） - &#x60;pc_wallpaper&#x60;（电脑壁纸，外部图床） - &#x60;anime&#x60;（混合动漫，UapiPro服务器acg + 外部图床general_anime）  &gt; [!TIP] &gt; 如果不指定，将从所有图片中随机抽取（不包含 &#x60;ikun&#x60; 和 &#x60;ai_drawing&#x60;）。 | [optional] |
| **type** | **string**| （可选，仅UapiPro服务器图片支持）指定图片子类别。  - **furry**: &#x60;z4k&#x60;, &#x60;szs8k&#x60;, &#x60;s4k&#x60;, &#x60;4k&#x60; - **bq**: &#x60;youshou&#x60;, &#x60;xiongmao&#x60;, &#x60;waiguoren&#x60;, &#x60;maomao&#x60;, &#x60;ikun&#x60;, &#x60;eciyuan&#x60; - **acg**: &#x60;pc&#x60;, &#x60;mb&#x60;  &gt; [!TIP] &gt; 外部图床类别和 &#x60;anime&#x60; 混合类别不支持 &#x60;type&#x60; 参数。 | [optional] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `image/jpeg`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getRandomString()`

```php
getRandomString($length, $type): \OpenAPI\Client\Model\GetRandomString200Response
```

生成高度可定制的随机字符串

无论是需要生成一个安全的随机密码、一个唯一的Token，还是一个简单的随机ID，这个接口都能满足你。  ## 功能概述 你可以精确地控制生成字符串的长度和字符集类型，非常灵活。  ## 使用须知  > [!TIP] > **字符集类型 `type` 详解** > 你可以通过 `type` 参数精确控制生成的字符集： > - **`numeric`**: 纯数字 (0-9) > - **`lower`**: 纯小写字母 (a-z) > - **`upper`**: 纯大写字母 (A-Z) > - **`alpha`**: 大小写字母 (a-zA-Z) > - **`alphanumeric`** (默认): 数字和大小写字母 (0-9a-zA-Z) > - **`hex`**: 十六进制字符 (0-9a-f)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RandomApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$length = 32; // int | 你希望生成的字符串的长度。有效范围是 1 到 1024。
$type = alphanumeric; // string | 指定构成字符串的字符类型。

try {
    $result = $apiInstance->getRandomString($length, $type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RandomApi->getRandomString: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **length** | **int**| 你希望生成的字符串的长度。有效范围是 1 到 1024。 | [optional] [default to 16] |
| **type** | **string**| 指定构成字符串的字符类型。 | [optional] [default to &#39;alphanumeric&#39;] |

### Return type

[**\OpenAPI\Client\Model\GetRandomString200Response**](../Model/GetRandomString200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postAnswerbookAsk()`

```php
postAnswerbookAsk($post_answerbook_ask_request): \OpenAPI\Client\Model\PostAnswerbookAsk200Response
```

获取答案之书的神秘答案 (POST)

通过POST请求向答案之书提问并获得神秘答案。  ## 功能概述 与GET方式相同，但通过JSON请求体发送问题，适合在需要发送较长问题或希望避免URL编码问题的场景中使用。  ## 请求体格式 请求体必须是有效的JSON格式，包含question字段。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\RandomApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_answerbook_ask_request = new \OpenAPI\Client\Model\PostAnswerbookAskRequest(); // \OpenAPI\Client\Model\PostAnswerbookAskRequest | 包含问题的JSON对象

try {
    $result = $apiInstance->postAnswerbookAsk($post_answerbook_ask_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RandomApi->postAnswerbookAsk: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_answerbook_ask_request** | [**\OpenAPI\Client\Model\PostAnswerbookAskRequest**](../Model/PostAnswerbookAskRequest.md)| 包含问题的JSON对象 | |

### Return type

[**\OpenAPI\Client\Model\PostAnswerbookAsk200Response**](../Model/PostAnswerbookAsk200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
