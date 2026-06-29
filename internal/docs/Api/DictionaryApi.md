# OpenAPI\Client\DictionaryApi



All URIs are relative to https://uapis.cn, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getDictionaryAudio()**](DictionaryApi.md#getDictionaryAudio) | **GET** /dictionary/audio | 单词发音 |
| [**getDictionaryLookup()**](DictionaryApi.md#getDictionaryLookup) | **GET** /dictionary/lookup | 单词查询 |


## `getDictionaryAudio()`

```php
getDictionaryAudio($word, $accent): \SplFileObject
```

单词发音

光看音标不知道怎么读？用这个接口为单词配上纯正的真人发音，并且支持英式与美式两种口音自由切换。  ## 功能概述 只需传入单词文本和所需的口音类型，接口就会直接响应 `.mp3` 格式的二进制音频流。你可以直接把接口地址塞进前端的 `<audio>` 标签里播放，或者将其下载保存为本地音频文件。另外，“单词查询”接口中返回的 `audio` 字段，实际上也就是直接拼装好的本接口地址。  ## 使用须知 > [!NOTE] > 本接口成功调用时返回的是 `audio/mpeg` 格式的二进制音频流，而不是常规的 JSON。如果在代码里使用 Fetch 或 Axios 调用并处理返回数据，请务必以 `blob` 或 `arraybuffer` 的形式接收响应内容。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DictionaryApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$word = present; // string | 要发音的英文单词，长度不超过 64 个字符。
$accent = 'uk'; // string | 口音偏好：uk（英式）或 us（美式），默认 uk。

try {
    $result = $apiInstance->getDictionaryAudio($word, $accent);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionaryApi->getDictionaryAudio: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **word** | **string**| 要发音的英文单词，长度不超过 64 个字符。 | |
| **accent** | **string**| 口音偏好：uk（英式）或 us（美式），默认 uk。 | [optional] [default to &#39;uk&#39;] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `audio/mpeg`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getDictionaryLookup()`

```php
getDictionaryLookup($word, $lang): \OpenAPI\Client\Model\GetDictionaryLookup200Response
```

单词查询

想在自己的背单词应用、阅读插件或聊天机器人里加个查词功能？输入一个英文单词，就能立刻拿到一本详尽的“微型词典”。  ## 功能概述 传入你要查询的英文单词，接口会返回一整份全方位的词条数据。数据结构是高度动态的——如果某个单词没有常见词组或近义词，对应的字段会自动省略，方便前端精简渲染。  ## 返回内容涵盖 - **音标与发音** (`phonetics`)：包含英式（UK）与美式（US）音标，以及可直接在前端播放的发音音频链接。 - **中文释义** (`definitions`)：按词性归类的中文翻译。 - **英英释义** (`english_definitions`)：英文原汁原味的解释及附带的短例句。 - **词形变化** (`word_forms`)：复数、过去式、比较级等形态转换。 - **词组与近义词** (`phrases` / `synonyms`)：常见的搭配词组，以及按词性归类的近义词。 - **双语例句** (`examples`)：真实语境下的中英双语例句。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DictionaryApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$word = present; // string | 要查询的英文单词，长度不超过 64 个字符。
$lang = 'en'; // string | 目标语种。目前仅支持 en（默认）。

try {
    $result = $apiInstance->getDictionaryLookup($word, $lang);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionaryApi->getDictionaryLookup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **word** | **string**| 要查询的英文单词，长度不超过 64 个字符。 | |
| **lang** | **string**| 目标语种。目前仅支持 en（默认）。 | [optional] [default to &#39;en&#39;] |

### Return type

[**\OpenAPI\Client\Model\GetDictionaryLookup200Response**](../Model/GetDictionaryLookup200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
