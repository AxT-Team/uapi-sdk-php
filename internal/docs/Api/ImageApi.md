# OpenAPI\Client\ImageApi

提供一系列与图片处理和获取相关的功能，从生成二维码到获取壁纸，应有尽有。

All URIs are relative to https://uapis.cn/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAvatarGravatar()**](ImageApi.md#getAvatarGravatar) | **GET** /avatar/gravatar | 获取Gravatar头像 |
| [**getImageBingDaily()**](ImageApi.md#getImageBingDaily) | **GET** /image/bing-daily | 获取必应每日壁纸 |
| [**getImageMotou()**](ImageApi.md#getImageMotou) | **GET** /image/motou | 生成摸摸头GIF (QQ号方式) |
| [**getImageQrcode()**](ImageApi.md#getImageQrcode) | **GET** /image/qrcode | 动态生成二维码 |
| [**getImageTobase64()**](ImageApi.md#getImageTobase64) | **GET** /image/tobase64 | 将在线图片转换为Base64 |
| [**postImageCompress()**](ImageApi.md#postImageCompress) | **POST** /image/compress | 无损压缩图片 |
| [**postImageFrombase64()**](ImageApi.md#postImageFrombase64) | **POST** /image/frombase64 | 通过Base64编码上传图片 |
| [**postImageMotou()**](ImageApi.md#postImageMotou) | **POST** /image/motou | 生成摸摸头GIF (图片上传或URL方式) |
| [**postImageSpeechless()**](ImageApi.md#postImageSpeechless) | **POST** /image/speechless | 生成你们怎么不说话了表情包 |
| [**postImageSvg()**](ImageApi.md#postImageSvg) | **POST** /image/svg | SVG转图片 |


## `getAvatarGravatar()`

```php
getAvatarGravatar($email, $hash, $s, $d, $r): \SplFileObject
```

获取Gravatar头像

提供一个超高速、高可用的Gravatar头像代理服务。内置了强大的ETag条件缓存，确保用户在更新Gravatar头像后能几乎立刻看到变化，同时最大化地利用缓存。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$email = shuakami@sdjz.wiki; // string | 用户的 Email 地址。如果未提供 `hash` 参数，则此参数为必需。
$hash = 'hash_example'; // string | 用户 Email 地址的小写 MD5 哈希值。如果提供此参数，将忽略 `email` 参数。
$s = 80; // int | 头像的尺寸，单位为像素。有效范围是 1 到 2048。
$d = 'mp'; // string | 当用户没有自己的 Gravatar 头像时，显示的默认头像类型。可选值包括 `mp`, `identicon`, `monsterid`, `wavatar`, `retro`, `robohash`, `blank`, `404`。
$r = 'g'; // string | 头像分级。可选值：`g`, `pg`, `r`, `x`。

try {
    $result = $apiInstance->getAvatarGravatar($email, $hash, $s, $d, $r);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getAvatarGravatar: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **email** | **string**| 用户的 Email 地址。如果未提供 &#x60;hash&#x60; 参数，则此参数为必需。 | [optional] |
| **hash** | **string**| 用户 Email 地址的小写 MD5 哈希值。如果提供此参数，将忽略 &#x60;email&#x60; 参数。 | [optional] |
| **s** | **int**| 头像的尺寸，单位为像素。有效范围是 1 到 2048。 | [optional] [default to 80] |
| **d** | **string**| 当用户没有自己的 Gravatar 头像时，显示的默认头像类型。可选值包括 &#x60;mp&#x60;, &#x60;identicon&#x60;, &#x60;monsterid&#x60;, &#x60;wavatar&#x60;, &#x60;retro&#x60;, &#x60;robohash&#x60;, &#x60;blank&#x60;, &#x60;404&#x60;。 | [optional] [default to &#39;mp&#39;] |
| **r** | **string**| 头像分级。可选值：&#x60;g&#x60;, &#x60;pg&#x60;, &#x60;r&#x60;, &#x60;x&#x60;。 | [optional] [default to &#39;g&#39;] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `image/*`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageBingDaily()`

```php
getImageBingDaily(): \SplFileObject
```

获取必应每日壁纸

每天都想换张新壁纸？让必应的美图点亮你的一天吧！  ## 功能概述 这个接口会获取 Bing 搜索引擎当天全球同步的每日壁纸，并直接以图片形式返回。你可以用它来做应用的启动页、网站背景，或者任何需要每日更新精美图片的地方。  ## 使用须知  > [!NOTE] > **响应格式是图片** > 请注意，此接口成功时直接返回图片二进制数据（通常为 `image/jpeg`），而非 JSON 格式。请确保客户端能够正确处理。  我们内置了备用方案：如果从必应官方获取图片失败，系统会尝试返回一张预存的高质量风景图，以保证服务的稳定性。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->getImageBingDaily();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageBingDaily: ', $e->getMessage(), PHP_EOL;
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
- **Accept**: `image/*`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageMotou()`

```php
getImageMotou($qq, $bg_color): \SplFileObject
```

生成摸摸头GIF (QQ号方式)

想在线rua一下好友的头像吗？这个趣味接口可以满足你。  ## 功能概述 此接口通过GET方法，专门用于通过QQ号生成摸摸头GIF。你只需要提供一个QQ号码，我们就会自动获取其公开头像，并制作成一个可爱的动图。  ## 使用须知 - **响应格式**：接口成功时直接返回 `image/gif` 格式的二进制数据。 - **背景颜色**：你可以通过 `bg_color` 参数来控制GIF的背景。使用 `transparent` 选项可以让它更好地融入各种聊天背景中。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$qq = 10001; // string | 你想要摸头的对象的QQ号码。
$bg_color = transparent; // string | GIF的背景颜色。留空则由后端服务决定默认值。

try {
    $result = $apiInstance->getImageMotou($qq, $bg_color);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageMotou: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **qq** | **string**| 你想要摸头的对象的QQ号码。 | |
| **bg_color** | **string**| GIF的背景颜色。留空则由后端服务决定默认值。 | [optional] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `image/gif`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageQrcode()`

```php
getImageQrcode($text, $size, $format): \SplFileObject
```

动态生成二维码

无论是网址、文本还是联系方式，通通可以变成一个二维码！这是一个非常灵活的二维码生成工具。  ## 功能概述 你提供一段文本内容，我们为你生成对应的二维码图片。你可以自定义尺寸，并选择不同的返回格式以适应不同场景。  ## 使用须知  > [!IMPORTANT] > **关键参数 `format`** > 此参数决定了成功响应的内容类型和结构，请务必根据你的需求选择并正确处理响应： > - **`image`** (默认): 直接返回 `image/png` 格式的图片二进制数据，适合在 `<img>` 标签中直接使用。 > - **`json`**: 返回一个包含 Base64 Data URI 的 JSON 对象，适合需要在前端直接嵌入CSS或HTML的场景。 > - **`json_url`**: 返回一个包含图片临时URL的JSON对象，适合需要图片链接的场景。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$text = https://www.bilibili.com/video/BV1uT4y1P7CX/; // string | 你希望编码到二维码中的任何文本内容，比如一个URL、一段话或者一个JSON字符串。
$size = 512; // int | 二维码图片的边长（正方形），单位是像素。有效范围是 256 到 1024 之间。
$format = image; // string | 指定响应内容的格式。可选值为 `image`, `json`, `json_url`。

try {
    $result = $apiInstance->getImageQrcode($text, $size, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageQrcode: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **text** | **string**| 你希望编码到二维码中的任何文本内容，比如一个URL、一段话或者一个JSON字符串。 | |
| **size** | **int**| 二维码图片的边长（正方形），单位是像素。有效范围是 256 到 1024 之间。 | [optional] [default to 256] |
| **format** | **string**| 指定响应内容的格式。可选值为 &#x60;image&#x60;, &#x60;json&#x60;, &#x60;json_url&#x60;。 | [optional] [default to &#39;image&#39;] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `image/png`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageTobase64()`

```php
getImageTobase64($url): \OpenAPI\Client\Model\GetImageTobase64200Response
```

将在线图片转换为Base64

看到一张网上的图片，想把它转换成 Base64 编码以便嵌入到你的 HTML 或 CSS 中？用这个接口就对了。  ## 功能概述 你提供一个公开可访问的图片 URL，我们帮你把它下载下来，并转换成包含 MIME 类型的 Base64 Data URI 字符串返回给你。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$url = https://ts3.tc.mm.bing.net/th?id=ORMS.44196851bb1757ec3f66572811fe8e07&pid=Wdp&w=612&h=304&qlt=90&c=1&rs=1&dpr=1.25&p=0; // string | 需要转换为Base64的、可公开访问的图片URL地址。

try {
    $result = $apiInstance->getImageTobase64($url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageTobase64: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **url** | **string**| 需要转换为Base64的、可公开访问的图片URL地址。 | |

### Return type

[**\OpenAPI\Client\Model\GetImageTobase64200Response**](../Model/GetImageTobase64200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageCompress()`

```php
postImageCompress($file, $level, $format): \SplFileObject
```

无损压缩图片

还在为图片体积和加载速度发愁吗？体验一下我们强大的**无损压缩服务**，它能在几乎不牺牲任何肉眼可感知的画质的前提下，将图片体积压缩到极致。  ## 功能概述 你只需要上传一张常见的图片（如 PNG, JPG），选择一个压缩等级，就能获得一个体积小到惊人的压缩文件。这对于需要大量展示高清图片的网站、App 或小程序来说，是优化用户体验、节省带宽和存储成本的利器。  ## 使用须知 > [!TIP] > 为了给您最好的压缩效果，我们的算法需要进行复杂计算，处理时间可能会稍长一些，请耐心等待。  > [!WARNING] > **服务排队提醒** > 这是一个计算密集型服务。在高并发时，您的请求可能会被排队等待处理。如果您需要将其集成到对延迟敏感的生产服务中，请注意这一点。  ### 请求与响应格式 - 请求必须使用 `multipart/form-data` 格式上传文件。 - 成功响应将直接返回压缩后的文件二进制流 (`application/octet-stream`)，并附带 `Content-Disposition` 头，建议客户端根据此头信息保存文件。  ## 参数详解 ### `level` (压缩等级) 这是一个从 `1` 到 `5` 的整数，它决定了压缩的强度和策略，数字越小，压缩率越高。所有等级都经过精心调校，以在最大化压缩率的同时保证出色的视觉质量。 - `1`: **极限压缩** (推荐，体积最小，画质优异) - `2`: **高效压缩** - `3`: **智能均衡** (默认选项) - `4`: **画质优先** - `5`: **专业保真** (压缩率稍低，保留最多图像信息)  ## 错误处理指南 - **400 Bad Request**: 通常因为没有上传文件，或者 `level` 参数不在 1-5 的范围内。 - **500 Internal Server Error**: 如果在压缩过程中服务器发生内部错误，会返回此状态码。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$file = '/path/to/file.txt'; // \SplFileObject | 支持PNG, JPG, JPEG等常见图片格式。文件大小不超过15MB。
$level = 3; // int | 压缩强度 (1-5)，默认为 3。数字越小，压缩率越高。
$format = png; // string | 输出图片格式，可以是 'png' 或 'jpeg'。

try {
    $result = $apiInstance->postImageCompress($file, $level, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageCompress: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **file** | **\SplFileObject****\SplFileObject**| 支持PNG, JPG, JPEG等常见图片格式。文件大小不超过15MB。 | |
| **level** | **int**| 压缩强度 (1-5)，默认为 3。数字越小，压缩率越高。 | [optional] [default to 3] |
| **format** | **string**| 输出图片格式，可以是 &#39;png&#39; 或 &#39;jpeg&#39;。 | [optional] [default to &#39;png&#39;] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `image/*`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageFrombase64()`

```php
postImageFrombase64($post_image_frombase64_request): \OpenAPI\Client\Model\PostImageFrombase64200Response
```

通过Base64编码上传图片

当你需要在前端处理完图片（比如裁剪、加滤镜后），不通过传统表单，而是直接上传图片的场景，这个接口就派上用场了。  ## 功能概述 你只需要将图片的 Base64 编码字符串发送过来，我们就会把它解码、保存为图片文件，并返回一个可供访问的公开 URL。  ## 使用须知  > [!IMPORTANT] > **关于 `imageData` 格式** > 你发送的 `imageData` 字符串必须是完整的 Base64 Data URI 格式，它需要包含 MIME 类型信息，例如 `data:image/png;base64,iVBORw0KGgo...`。缺少 `data:image/...;base64,` 前缀将导致解码失败。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_image_frombase64_request = new \OpenAPI\Client\Model\PostImageFrombase64Request(); // \OpenAPI\Client\Model\PostImageFrombase64Request | 一个JSON对象，包含 `imageData` 字段，其值为你想要上传图片的完整Base64 Data URI。

try {
    $result = $apiInstance->postImageFrombase64($post_image_frombase64_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageFrombase64: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_image_frombase64_request** | [**\OpenAPI\Client\Model\PostImageFrombase64Request**](../Model/PostImageFrombase64Request.md)| 一个JSON对象，包含 &#x60;imageData&#x60; 字段，其值为你想要上传图片的完整Base64 Data URI。 | |

### Return type

[**\OpenAPI\Client\Model\PostImageFrombase64200Response**](../Model/PostImageFrombase64200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageMotou()`

```php
postImageMotou($image_url, $file, $bg_color): \SplFileObject
```

生成摸摸头GIF (图片上传或URL方式)

除了使用QQ头像，你还可以通过上传自己的图片或提供图片URL来制作独一无二的摸摸头GIF。  ## 功能概述 此接口通过POST方法，支持两种方式生成GIF： 1.  **图片URL**：在表单中提供 `image_url` 字段。 2.  **上传图片**：在表单中上传 `file` 文件。  ## 使用须知 - **响应格式**：接口成功时直接返回 `image/gif` 格式的二进制数据。 - **参数优先级**：如果同时提供了 `image_url` 和上传的 `file` 文件，系统将 **优先使用 `image_url`**。 - **背景颜色**：同样支持 `bg_color` 表单字段来控制GIF背景。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$image_url = 'image_url_example'; // string | 图片的URL地址。如果提供此项，将优先使用该URL的图片。
$file = '/path/to/file.txt'; // \SplFileObject | 上传的图片文件。支持JPG、PNG、GIF等常见格式。
$bg_color = 'bg_color_example'; // string | GIF的背景颜色。可选值为 'white', 'black', 'transparent'。

try {
    $result = $apiInstance->postImageMotou($image_url, $file, $bg_color);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageMotou: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **image_url** | **string**| 图片的URL地址。如果提供此项，将优先使用该URL的图片。 | [optional] |
| **file** | **\SplFileObject****\SplFileObject**| 上传的图片文件。支持JPG、PNG、GIF等常见格式。 | [optional] |
| **bg_color** | **string**| GIF的背景颜色。可选值为 &#39;white&#39;, &#39;black&#39;, &#39;transparent&#39;。 | [optional] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `image/gif`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageSpeechless()`

```php
postImageSpeechless($post_image_speechless_request): \SplFileObject
```

生成你们怎么不说话了表情包

你们怎么不说话了？是不是都在偷偷玩Uapi，求求你们不要玩Uapi了  ## 效果展示 ![示例](https://uapis.cn/static/uploads/33580466897f1e5815296f235b582815.png)  ## 使用须知 - **响应格式**：接口成功时直接返回 `image/jpeg` 格式的二进制数据。 - **文字内容**：至少需要提供 `top_text`（上方文字）或 `bottom_text`（下方文字）之一。 - **梗图逻辑**：上方描述某个行为，下方通常以「们」开头表示劝阻，形成戏谑的对比效果。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$post_image_speechless_request = new \OpenAPI\Client\Model\PostImageSpeechlessRequest(); // \OpenAPI\Client\Model\PostImageSpeechlessRequest | 包含表情包文字内容的JSON对象。至少需要提供上方或下方文字之一。

try {
    $result = $apiInstance->postImageSpeechless($post_image_speechless_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageSpeechless: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **post_image_speechless_request** | [**\OpenAPI\Client\Model\PostImageSpeechlessRequest**](../Model/PostImageSpeechlessRequest.md)| 包含表情包文字内容的JSON对象。至少需要提供上方或下方文字之一。 | |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `image/png`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageSvg()`

```php
postImageSvg($format, $width, $height, $quality, $file): \SplFileObject
```

SVG转图片

需要将灵活的 SVG 矢量图形转换为常见的光栅图像格式吗？这个接口可以帮你轻松实现。  ## 功能概述 上传一个 SVG 文件，并指定目标格式（如 PNG、JPEG 等），接口将返回转换后的图像。你还可以调整输出图像的尺寸和（对于JPEG）压缩质量，以满足不同场景的需求。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$format = 'png'; // string | 输出图像的目标格式。支持的值：`png`, `jpeg`, `jpg`, `gif`, `tiff`, `bmp`。
$width = 56; // int | 输出图像的宽度（像素）。如果省略，将根据 `height` 保持宽高比，或者使用 SVG 的原始宽度。
$height = 56; // int | 输出图像的高度（像素）。如果省略，将根据 `width` 保持宽高比，或者使用 SVG 的原始高度。
$quality = 90; // int | JPEG 图像的压缩质量（1-100）。仅当 `format` 为 `jpeg` 或 `jpg` 时有效。
$file = '/path/to/file.txt'; // \SplFileObject | 支持SVG文件

try {
    $result = $apiInstance->postImageSvg($format, $width, $height, $quality, $file);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageSvg: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **format** | **string**| 输出图像的目标格式。支持的值：&#x60;png&#x60;, &#x60;jpeg&#x60;, &#x60;jpg&#x60;, &#x60;gif&#x60;, &#x60;tiff&#x60;, &#x60;bmp&#x60;。 | [optional] [default to &#39;png&#39;] |
| **width** | **int**| 输出图像的宽度（像素）。如果省略，将根据 &#x60;height&#x60; 保持宽高比，或者使用 SVG 的原始宽度。 | [optional] |
| **height** | **int**| 输出图像的高度（像素）。如果省略，将根据 &#x60;width&#x60; 保持宽高比，或者使用 SVG 的原始高度。 | [optional] |
| **quality** | **int**| JPEG 图像的压缩质量（1-100）。仅当 &#x60;format&#x60; 为 &#x60;jpeg&#x60; 或 &#x60;jpg&#x60; 时有效。 | [optional] [default to 90] |
| **file** | **\SplFileObject****\SplFileObject**| 支持SVG文件 | [optional] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `image/*`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
