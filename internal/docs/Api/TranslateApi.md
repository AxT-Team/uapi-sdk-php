# OpenAPI\Client\TranslateApi

提供文本翻译服务，打破语言的壁垒。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAiTranslateLanguages()**](TranslateApi.md#getAiTranslateLanguages) | **GET** /ai/translate/languages | AI翻译配置 |
| [**postAiTranslate()**](TranslateApi.md#postAiTranslate) | **POST** /ai/translate | AI智能翻译 |
| [**postTranslateStream()**](TranslateApi.md#postTranslateStream) | **POST** /translate/stream | 流式翻译（中英互译） |
| [**postTranslateText()**](TranslateApi.md#postTranslateText) | **POST** /translate/text | 翻译 |


## `getAiTranslateLanguages()`

```php
getAiTranslateLanguages(): \OpenAPI\Client\Model\GetAiTranslateLanguages200Response
```

AI翻译配置

获取AI智能翻译服务支持的完整语言列表、翻译风格选项、上下文场景选项以及性能指标信息。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TranslateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getAiTranslateLanguages();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TranslateApi->getAiTranslateLanguages: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\GetAiTranslateLanguages200Response**](../Model/GetAiTranslateLanguages200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postAiTranslate()`

```php
postAiTranslate($target_lang, $post_ai_translate_request): \OpenAPI\Client\Model\PostAiTranslate200Response
```

AI智能翻译

这是一个商业级的AI智能翻译服务，采用最新的神经网络翻译技术和大语言模型，提供远超传统机器翻译的质量。  ## 功能概述  - **单文本翻译**: 专注处理单条文本翻译，适合需要高质量译文的业务场景。 - **多风格适配**: 提供随意口语化、专业商务、学术正式、文学艺术四种翻译风格，能够根据不同场景需求调整翻译的语言风格和表达方式。 - **上下文感知**: 支持通用、商务、技术、医疗、法律、市场营销、娱乐、教育、新闻等九种专业领域的上下文翻译，确保术语准确性和表达地道性。 - **格式保留**: 智能识别并保持原文的格式结构，包括换行、缩进、特殊符号等，确保翻译后的文本保持良好的可读性。  ## 支持的语言  我们支持超过100种语言的互译，详见下方参数列表。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TranslateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$target_lang = zh; // string | 目标语言代码。请从[支持的语言列表](#enum-list)中选择一个语言代码。
$post_ai_translate_request = new \OpenAPI\Client\Model\PostAiTranslateRequest(); // \OpenAPI\Client\Model\PostAiTranslateRequest | 

try {
    $result = $apiInstance->postAiTranslate($target_lang, $post_ai_translate_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TranslateApi->postAiTranslate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **target_lang** | **string**| 目标语言代码。请从[支持的语言列表](#enum-list)中选择一个语言代码。 | |
| **post_ai_translate_request** | [**\OpenAPI\Client\Model\PostAiTranslateRequest**](../Model/PostAiTranslateRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\PostAiTranslate200Response**](../Model/PostAiTranslate200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postTranslateStream()`

```php
postTranslateStream($post_translate_stream_request): string
```

流式翻译（中英互译）

想让翻译结果像打字机一样逐字显示出来？这个流式翻译接口能实现这种效果。  ## 功能概述 不同于传统翻译API一次性返回完整结果，这个接口会实时地、一个字一个字地把翻译内容推给你（就像ChatGPT回复消息那样），非常适合用在聊天应用、直播字幕等需要即时反馈的场景。  ## 它能做什么 - **中英互译**：支持中文和英文之间的双向翻译 - **自动识别**：不确定源语言？设置为 `auto` 让我们自动检测 - **逐字返回**：翻译结果会像打字机一样逐字流式返回，用户体验更流畅 - **音频朗读**：部分翻译结果会附带音频链接，方便朗读  ## 支持的语言 目前专注于中英互译，支持以下选项： - `中文`（简体/繁体） - `英文` - `auto`（自动检测）

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TranslateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_translate_stream_request = new \OpenAPI\Client\Model\PostTranslateStreamRequest(); // \OpenAPI\Client\Model\PostTranslateStreamRequest | 

try {
    $result = $apiInstance->postTranslateStream($post_translate_stream_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TranslateApi->postTranslateStream: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_translate_stream_request** | [**\OpenAPI\Client\Model\PostTranslateStreamRequest**](../Model/PostTranslateStreamRequest.md)|  | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postTranslateText()`

```php
postTranslateText($to_lang, $post_translate_text_request): \OpenAPI\Client\Model\PostTranslateText200Response
```

翻译

需要跨越语言的鸿沟进行交流？这个翻译接口是你可靠的'同声传译'。  ## 功能概述 你可以将一段源语言文本（我们能自动检测源语言）翻译成你指定的任何目标语言。无论是中译英、日译法，都不在话下。  ## 支持的语言 我们支持超过100种语言的互译，包括但不限于：中文（简体/繁体）、英语、日语、韩语、法语、德语、西班牙语、俄语、阿拉伯语等主流语言，以及各种小语种。详见下方参数列表。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TranslateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$to_lang = zh; // string | 目标语言代码。请从[支持的语言列表](#enum-list)中选择一个语言代码。
$post_translate_text_request = new \OpenAPI\Client\Model\PostTranslateTextRequest(); // \OpenAPI\Client\Model\PostTranslateTextRequest | 

try {
    $result = $apiInstance->postTranslateText($to_lang, $post_translate_text_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TranslateApi->postTranslateText: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **to_lang** | **string**| 目标语言代码。请从[支持的语言列表](#enum-list)中选择一个语言代码。 | |
| **post_translate_text_request** | [**\OpenAPI\Client\Model\PostTranslateTextRequest**](../Model/PostTranslateTextRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\PostTranslateText200Response**](../Model/PostTranslateText200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
