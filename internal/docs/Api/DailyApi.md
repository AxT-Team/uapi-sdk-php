# OpenAPI\Client\DailyApi



All URIs are relative to https://uapis.cn, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getDailyNewsImage()**](DailyApi.md#getDailyNewsImage) | **GET** /daily/news-image | 每日新闻图 |
| [**getDailyWord()**](DailyApi.md#getDailyWord) | **GET** /daily/word | 每日单词 |


## `getDailyNewsImage()`

```php
getDailyNewsImage(): \SplFileObject
```

每日新闻图

想用一张图快速了解天下大事？这个接口为你一键生成今日新闻摘要，非常适合用在早报、数字看板或应用首页等场景。  ## 功能概述 此接口会实时抓取各大平台的热点新闻，并动态地将它们渲染成一张清晰、美观的摘要图片。你调用接口，直接就能得到一张可以展示的图片。  ## 使用须知 调用此接口时，请务必注意以下两点：  1.  **响应格式是图片**：接口成功时直接返回 `image/jpeg` 格式的二进制数据，而非 JSON。请确保你的客户端能正确处理二进制流，例如直接在 `<img>` 标签中显示，或保存为 `.jpg` 文件。  2.  **设置合理超时**：由于涉及实时新闻抓取和图片渲染，处理过程可能耗时数秒。建议将客户端请求超时时间设置为至少10秒，以防止因等待过久而失败。  > [!IMPORTANT] > 未能正确处理图片响应或超时设置过短，是导致调用失败的最常见原因。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DailyApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getDailyNewsImage();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyApi->getDailyNewsImage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

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

## `getDailyWord()`

```php
getDailyWord($lang, $category, $count, $date, $seed, $example, $phonetic, $define): \OpenAPI\Client\Model\GetDailyWord200Response
```

每日单词

想给你的学习打卡、英语小组件或机器人推送加一个『每日单词』？这个接口每天给你一个稳定的单词，同一天多次请求结果一致。  ## 功能概述 默认返回 1 个英文单词，支持按词库范围筛选，可选择是否附带例句和音标。也可以用 `count` 一次返回多个词，用于词汇复习列表。  ## 词库选项 - `all`：全部英文词库，适合通用每日推荐。 - `cet4`：大学英语四级词汇，适合基础复习。 - `cet6`：大学英语六级词汇，适合进阶复习。 - `ielts`：雅思词汇，适合留学考试准备。 - `toefl`：托福词汇，适合北美考试准备。 - `gre`：GRE 词汇，适合高阶词汇训练。  ## 使用须知 > [!IMPORTANT] > `date` 与 `seed` 用于复现某一天或某个固定的取词结果，二者不能同时传入。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DailyApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$lang = en; // string | 语种，目前支持 en，默认 en。
$category = 'all'; // string | 词库范围：all/cet4/cet6/ielts/toefl/gre，默认 all。
$count = 3; // int | 返回数量，1-20，默认 1。
$date = 'date_example'; // string | 日期，格式 YYYY-MM-DD，作为每日单词的种子基准。
$seed = 56; // int | 固定种子，结果可复现；不可与 date 同时使用。
$example = true; // bool | 是否返回例句，默认 true。
$phonetic = true; // bool | 是否返回音标，默认 true。
$define = false; // bool | 是否为每个单词附带详细释义（音标发音、中英释义、词形、词组、近义词、双语例句），默认 false。

try {
    $result = $apiInstance->getDailyWord($lang, $category, $count, $date, $seed, $example, $phonetic, $define);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyApi->getDailyWord: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **lang** | **string**| 语种，目前支持 en，默认 en。 | [optional] [default to &#39;en&#39;] |
| **category** | **string**| 词库范围：all/cet4/cet6/ielts/toefl/gre，默认 all。 | [optional] [default to &#39;all&#39;] |
| **count** | **int**| 返回数量，1-20，默认 1。 | [optional] [default to 1] |
| **date** | **string**| 日期，格式 YYYY-MM-DD，作为每日单词的种子基准。 | [optional] |
| **seed** | **int**| 固定种子，结果可复现；不可与 date 同时使用。 | [optional] |
| **example** | **bool**| 是否返回例句，默认 true。 | [optional] [default to true] |
| **phonetic** | **bool**| 是否返回音标，默认 true。 | [optional] [default to true] |
| **define** | **bool**| 是否为每个单词附带详细释义（音标发音、中英释义、词形、词组、近义词、双语例句），默认 false。 | [optional] [default to false] |

### Return type

[**\OpenAPI\Client\Model\GetDailyWord200Response**](../Model/GetDailyWord200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
