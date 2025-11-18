# OpenAPI\Client\TranslateApi

提供文本翻译服务，打破语言的壁垒。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAiTranslateLanguages()**](TranslateApi.md#getAiTranslateLanguages) | **GET** /ai/translate/languages | 获取AI翻译支持的语言和配置 |
| [**postAiTranslate()**](TranslateApi.md#postAiTranslate) | **POST** /ai/translate | AI智能翻译 |
| [**postTranslateStream()**](TranslateApi.md#postTranslateStream) | **POST** /translate/stream | 流式翻译（中英互译） |
| [**postTranslateText()**](TranslateApi.md#postTranslateText) | **POST** /translate/text | 多语言文本翻译 |


## `getAiTranslateLanguages()`

```php
getAiTranslateLanguages(): \OpenAPI\Client\Model\GetAiTranslateLanguages200Response
```

获取AI翻译支持的语言和配置

获取AI智能翻译服务支持的完整语言列表、翻译风格选项、上下文场景选项以及性能指标信息。这个接口对于需要在前端动态展示翻译配置选项的应用非常有用，它会返回当前AI翻译服务所支持的所有语言代码、原生名称、翻译风格说明、上下文场景描述，以及服务的性能特征和限制信息。通过此接口，开发者可以构建用户友好的翻译界面，让用户选择合适的翻译参数。

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

这是一个商业级的AI智能翻译服务，采用最新的神经网络翻译技术和大语言模型，提供远超传统机器翻译的质量。它不仅能够智能处理单个文本翻译，还支持高效的批量文本翻译，并且具备上下文感知、风格适配、格式保留等高级功能。  > [!VIP] > 本API目前处于**限时免费**阶段，我们鼓励开发者深度集成和测试。未来，它将转为付费API，为用户提供更稳定、更智能的翻译服务。  ## 功能概述  - **智能双模式**: 支持单个文本翻译和批量文本翻译的统一接口设计，自动识别请求类型并提供相应的翻译服务。系统会根据输入自动判断是处理单条文本还是批量文本，无需使用不同的接口。 - **多风格适配**: 提供随意口语化、专业商务、学术正式、文学艺术四种翻译风格，能够根据不同场景需求调整翻译的语言风格和表达方式。 - **上下文感知**: 支持通用、商务、技术、医疗、法律、市场营销、娱乐、教育、新闻等九种专业领域的上下文翻译，确保术语准确性和表达地道性。 - **高质量保证**: 内置质量评估系统，对每次翻译结果进行流畅度、准确度、完整性评分，并提供置信度分数和替代翻译建议。 - **智能解释**: 提供关键词组翻译注释、文化背景说明和语法结构分析，帮助用户理解翻译逻辑和文化差异。 - **高效批量**: 批量翻译支持最多50条文本，总计10万字符，配备智能并发控制（1-10并发）和失败重试机制。 - **快速模式**: 提供快速模式选项，在保证95%+准确率的前提下，响应时间缩短至800ms内，适合实时翻译和聊天应用。 - **格式保留**: 智能识别并保持原文的格式结构，包括换行、缩进、特殊符号等，确保翻译后的文本保持良好的可读性。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\TranslateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$target_lang = zh-CHS; // string | 目标语言代码。请从支持的语言列表中选择一个语言代码。
$post_ai_translate_request = new \OpenAPI\Client\Model\PostAiTranslateRequest(); // \OpenAPI\Client\Model\PostAiTranslateRequest | 包含翻译参数的JSON对象，支持单个文本或批量文本翻译

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
| **target_lang** | **string**| 目标语言代码。请从支持的语言列表中选择一个语言代码。 | |
| **post_ai_translate_request** | [**\OpenAPI\Client\Model\PostAiTranslateRequest**](../Model/PostAiTranslateRequest.md)| 包含翻译参数的JSON对象，支持单个文本或批量文本翻译 | |

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
$post_translate_stream_request = new \OpenAPI\Client\Model\PostTranslateStreamRequest(); // \OpenAPI\Client\Model\PostTranslateStreamRequest | 包含翻译参数的JSON对象

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
| **post_translate_stream_request** | [**\OpenAPI\Client\Model\PostTranslateStreamRequest**](../Model/PostTranslateStreamRequest.md)| 包含翻译参数的JSON对象 | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `text/event-stream`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postTranslateText()`

```php
postTranslateText($to_lang, $post_translate_text_request): \OpenAPI\Client\Model\PostTranslateText200Response
```

多语言文本翻译

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
$to_lang = zh-CHS; // string | 目标语言代码。请从支持的语言列表中选择一个语言代码。
$post_translate_text_request = new \OpenAPI\Client\Model\PostTranslateTextRequest(); // \OpenAPI\Client\Model\PostTranslateTextRequest | 包含待翻译文本的JSON对象

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
| **to_lang** | **string**| 目标语言代码。请从支持的语言列表中选择一个语言代码。 | |
| **post_translate_text_request** | [**\OpenAPI\Client\Model\PostTranslateTextRequest**](../Model/PostTranslateTextRequest.md)| 包含待翻译文本的JSON对象 | |

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
