# OpenAPI\Client\ImageApi



All URIs are relative to https://uapis.cn, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAvatarGravatar()**](ImageApi.md#getAvatarGravatar) | **GET** /avatar/gravatar | 获取Gravatar头像 |
| [**getImageBingDaily()**](ImageApi.md#getImageBingDaily) | **GET** /image/bing-daily | 获取必应每日壁纸 |
| [**getImageBingDailyHistory()**](ImageApi.md#getImageBingDailyHistory) | **GET** /image/bing-daily/history | 查询必应壁纸历史 |
| [**getImageMotou()**](ImageApi.md#getImageMotou) | **GET** /image/motou | 生成摸摸头GIF (QQ号) |
| [**getImageQrcode()**](ImageApi.md#getImageQrcode) | **GET** /image/qrcode | 生成二维码 |
| [**getImageTobase64()**](ImageApi.md#getImageTobase64) | **GET** /image/tobase64 | 图片转 Base64 |
| [**postImageCompress()**](ImageApi.md#postImageCompress) | **POST** /image/compress | 无损压缩图片 |
| [**postImageDecode()**](ImageApi.md#postImageDecode) | **POST** /image/decode | 解码并缩放图片 |
| [**postImageFrombase64()**](ImageApi.md#postImageFrombase64) | **POST** /image/frombase64 | 通过Base64编码上传图片 |
| [**postImageMotou()**](ImageApi.md#postImageMotou) | **POST** /image/motou | 生成摸摸头GIF |
| [**postImageNsfw()**](ImageApi.md#postImageNsfw) | **POST** /image/nsfw | 图片敏感检测 |
| [**postImageOcr()**](ImageApi.md#postImageOcr) | **POST** /image/ocr | 通用 OCR 文字识别 |
| [**postImageSpeechless()**](ImageApi.md#postImageSpeechless) | **POST** /image/speechless | 生成你们怎么不说话了表情包 |
| [**postImageSvg()**](ImageApi.md#postImageSvg) | **POST** /image/svg | SVG转图片 |


## `getAvatarGravatar()`

```php
getAvatarGravatar($email, $hash, $s, $d, $r): \SplFileObject
```

获取Gravatar头像

提供稳定、易用的头像获取能力，适合在网页或应用中直接展示头像。

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
- **Accept**: `image/png`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageBingDaily()`

```php
getImageBingDaily($date, $random, $resolution, $format): \SplFileObject
```

获取必应每日壁纸

这个接口可以获取最新或指定日期的必应壁纸。默认直接返回图片，也可以传 `format=json` 获取元数据，或者传 `format=redirect` 直接跳转到最终图片地址。  ## 功能概述 - 不传参数时，默认返回当天壁纸图片二进制 - 可以传 `date` 查询指定日期的壁纸 - 可以传 `resolution` 选择 `4k` 或 `1080` - 可以传 `format` 控制返回图片、JSON 或 302 跳转 - 当传 `format=json` 时，返回的是扁平 JSON 对象，里面会包含标题、副标题、说明文案、版权信息、问答信息和图片地址等字段  ## 参数说明 `resolution` 默认是 `4k`。 `format` 默认是 `image`。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$date = 'date_example'; // string | 壁纸日期，格式是 `YYYY-MM-DD`。不传时返回当天壁纸。
$random = true; // bool | 是否每次请求随机返回一张历史壁纸。传 `true` 时生效；不能和 `date` 同时使用。不传或传 `false` 时保持默认当天/指定日期逻辑。
$resolution = 4k; // string | 返回图片的目标分辨率。可以传 `4k` 或 `1080`，不传时默认是 `4k`。
$format = 'image'; // string | 响应格式。可以传 `image`、`json` 或 `redirect`。不传时默认是 `image`。

try {
    $result = $apiInstance->getImageBingDaily($date, $random, $resolution, $format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageBingDaily: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **date** | **string**| 壁纸日期，格式是 &#x60;YYYY-MM-DD&#x60;。不传时返回当天壁纸。 | [optional] |
| **random** | **bool**| 是否每次请求随机返回一张历史壁纸。传 &#x60;true&#x60; 时生效；不能和 &#x60;date&#x60; 同时使用。不传或传 &#x60;false&#x60; 时保持默认当天/指定日期逻辑。 | [optional] [default to false] |
| **resolution** | **string**| 返回图片的目标分辨率。可以传 &#x60;4k&#x60; 或 &#x60;1080&#x60;，不传时默认是 &#x60;4k&#x60;。 | [optional] [default to &#39;4k&#39;] |
| **format** | **string**| 响应格式。可以传 &#x60;image&#x60;、&#x60;json&#x60; 或 &#x60;redirect&#x60;。不传时默认是 &#x60;image&#x60;。 | [optional] [default to &#39;image&#39;] |

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

## `getImageBingDailyHistory()`

```php
getImageBingDailyHistory($date, $resolution, $page, $page_size): \OpenAPI\Client\Model\GetImageBingDailyHistory200Response
```

查询必应壁纸历史

这个接口用于查询必应壁纸历史列表，也可以按日期精确查询某一天。默认按时间倒序返回 JSON。  ## 功能概述 - 可以传 `date` 精确查询某一天，命中后只返回 1 条数据 - 不传 `date` 时，按时间倒序分页返回历史列表 - 可以传 `resolution` 让 `image_url` 直接对应 `4k` 或 `1080` - 可以传 `page` 和 `page_size` 控制分页 - 每条记录都是扁平 JSON 对象，里面会包含标题、副标题、说明文案、版权信息、问答信息和图片地址等字段  ## 参数说明 `resolution` 默认是 `4k`。 `page` 默认是 `1`，`page_size` 默认是 `30`，最大是 `100`。 当传了 `date` 以后，`page` 和 `page_size` 不生效。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$date = 2026-04-05; // string | 壁纸日期，格式是 `YYYY-MM-DD`。传了以后会按日期精确查询，并且忽略 `page` 和 `page_size`。
$resolution = 1080; // string | 返回图片的目标分辨率。可以传 `4k` 或 `1080`，不传时默认是 `4k`。
$page = 2; // int | 分页页码，必须是正整数。不传时默认是 `1`。只有在不传 `date` 时才生效。
$page_size = 10; // int | 每页条数，必须是正整数。不传时默认是 `30`，最大是 `100`。只有在不传 `date` 时才生效。

try {
    $result = $apiInstance->getImageBingDailyHistory($date, $resolution, $page, $page_size);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageBingDailyHistory: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **date** | **string**| 壁纸日期，格式是 &#x60;YYYY-MM-DD&#x60;。传了以后会按日期精确查询，并且忽略 &#x60;page&#x60; 和 &#x60;page_size&#x60;。 | [optional] |
| **resolution** | **string**| 返回图片的目标分辨率。可以传 &#x60;4k&#x60; 或 &#x60;1080&#x60;，不传时默认是 &#x60;4k&#x60;。 | [optional] [default to &#39;4k&#39;] |
| **page** | **int**| 分页页码，必须是正整数。不传时默认是 &#x60;1&#x60;。只有在不传 &#x60;date&#x60; 时才生效。 | [optional] [default to 1] |
| **page_size** | **int**| 每页条数，必须是正整数。不传时默认是 &#x60;30&#x60;，最大是 &#x60;100&#x60;。只有在不传 &#x60;date&#x60; 时才生效。 | [optional] [default to 30] |

### Return type

[**\OpenAPI\Client\Model\GetImageBingDailyHistory200Response**](../Model/GetImageBingDailyHistory200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getImageMotou()`

```php
getImageMotou($qq, $bg_color): \SplFileObject
```

生成摸摸头GIF (QQ号)

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
getImageQrcode($text, $size, $format, $transparent, $fgcolor, $bgcolor): \SplFileObject
```

生成二维码

无论是网址、文本还是联系方式，通通可以变成一个二维码！这是一个非常灵活的二维码生成工具。  ## 功能概述 你提供一段文本内容，我们为你生成对应的二维码图片。你可以自定义尺寸、前景色、背景色，还支持透明背景，并选择不同的返回格式以适应不同场景。

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
$size = 512; // int | 二维码图片的边长（正方形），单位是像素。有效范围是 256 到 2048 之间。
$format = image; // string | 指定响应内容的格式。可选值为 `image`, `json`, `json_url`。
$transparent = false; // bool | 是否使用透明背景。启用后生成的 PNG 图片将具有 alpha 通道，背景透明。
$fgcolor = '#000000'; // string | 二维码前景色（即二维码本身的颜色），使用十六进制格式。URL 中需要将 `#` 编码为 `%23`。
$bgcolor = '#FFFFFF'; // string | 二维码背景色，使用十六进制格式。当 `transparent=true` 时此参数会被忽略。URL 中需要将 `#` 编码为 `%23`。

try {
    $result = $apiInstance->getImageQrcode($text, $size, $format, $transparent, $fgcolor, $bgcolor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->getImageQrcode: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **text** | **string**| 你希望编码到二维码中的任何文本内容，比如一个URL、一段话或者一个JSON字符串。 | |
| **size** | **int**| 二维码图片的边长（正方形），单位是像素。有效范围是 256 到 2048 之间。 | [optional] [default to 256] |
| **format** | **string**| 指定响应内容的格式。可选值为 &#x60;image&#x60;, &#x60;json&#x60;, &#x60;json_url&#x60;。 | [optional] [default to &#39;image&#39;] |
| **transparent** | **bool**| 是否使用透明背景。启用后生成的 PNG 图片将具有 alpha 通道，背景透明。 | [optional] [default to false] |
| **fgcolor** | **string**| 二维码前景色（即二维码本身的颜色），使用十六进制格式。URL 中需要将 &#x60;#&#x60; 编码为 &#x60;%23&#x60;。 | [optional] [default to &#39;#000000&#39;] |
| **bgcolor** | **string**| 二维码背景色，使用十六进制格式。当 &#x60;transparent&#x3D;true&#x60; 时此参数会被忽略。URL 中需要将 &#x60;#&#x60; 编码为 &#x60;%23&#x60;。 | [optional] [default to &#39;#FFFFFF&#39;] |

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

图片转 Base64

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

还在为图片体积和加载速度发愁吗？体验一下我们强大的**无损压缩服务**，它能在几乎不牺牲任何肉眼可感知的画质的前提下，将图片体积压缩到极致。  ## 功能概述 你只需要上传一张常见的图片（如 PNG, JPG），选择一个压缩等级，就能获得一个体积小到惊人的压缩文件。这对于需要大量展示高清图片的网站、App 或小程序来说，是优化用户体验、节省带宽和存储成本的利器。  ## 使用须知 > [!TIP] > 图片越大或压缩等级越高，处理时间可能越长，请您耐心等待。  > [!WARNING] > **处理时间提醒** > 在访问量较高时，处理时间可能进一步延长。如果您的业务对返回时间比较敏感，建议预留充足的处理时间。  ### 请求与响应格式 - 请求必须使用 `multipart/form-data` 格式上传文件。 - 成功响应将直接返回压缩后的文件二进制流 (`image/_*`)，并附带 `Content-Disposition` 头，建议客户端根据此头信息保存文件。  ## 参数详解 ### `level` (压缩等级) 这是一个从 `1` 到 `5` 的整数，它决定了压缩的强度和策略，数字越小，压缩率越高。所有等级都经过精心调校，以在最大化压缩率的同时保证出色的视觉质量。 - `1`: **极限压缩** (推荐，体积最小，画质优异) - `2`: **高效压缩** - `3`: **智能均衡** (默认选项) - `4`: **画质优先** - `5`: **专业保真** (压缩率稍低，保留最多图像信息)  ## 错误处理指南 - **400 Bad Request**: 通常因为没有上传文件，或者 `level` 参数不在 1-5 的范围内。 - **500 Internal Server Error**: 如果在压缩过程中服务器发生内部错误，会返回此状态码。

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
- **Accept**: `image/png`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageDecode()`

```php
postImageDecode($width, $height, $max_width, $max_height, $format, $color_mode, $fit, $background, $file, $url): \SplFileObject
```

解码并缩放图片

在 RAM 和 Flash 极其有限的设备上解码图片是一项繁重的任务。这个接口专为 IoT 和嵌入式开发设计，将复杂的图像解码和缩放操作转移到云端，直接输出适用于单片机屏幕的二进制像素流。  ## 功能概述 此接口提供了灵活的云端图像预处理能力，帮助硬件开发者跳过繁琐的图像处理逻辑： - **直接推流渲染**：如果选择输出纯像素流（如 RGB565），单片机收到网络数据后无需解析文件头，可直接将其写入显存，实现极低内存占用的边下边播。 - **完美适配屏幕**：无需在设备端编写裁剪或补边代码。只需传入目标屏幕的物理分辨率，接口会自动完成等比缩放、居中补色或铺满裁剪，确保最终显示画面不变形。 - **精准内存分配**：在动态缩放图片的场景下，服务端会在 HTTP 响应头中提前注入 `X-Image-Width` 和 `X-Image-Height`，方便设备在读取真实的二进制数据前进行准确的内存分配。  ## 使用须知 - **请求格式**：无论是上传本地文件还是传递图片链接，请求体都必须使用 `multipart/form-data` 编码格式。 - **网络资源获取**：当您选择传递图片链接时，服务端会自动尝试获取该资源。请确保您提供的图片链接是公网直接可访问的，且不需要任何形式的登录鉴权。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$width = 800; // int | 目标宽度，单位是像素。可以单独传，也可以和 `height` 一起传。与 `max_width`、`max_height` 互斥。
$height = 600; // int | 目标高度，单位是像素。可以单独传，也可以和 `width` 一起传。与 `max_width`、`max_height` 互斥。
$max_width = 56; // int | 最大宽度，单位是像素。只有在不传 `width`、`height` 时才生效，会按原比例缩放。
$max_height = 56; // int | 最大高度，单位是像素。只有在不传 `width`、`height` 时才生效，会按原比例缩放。
$format = 'bmp'; // string | 输出格式。可以传 `bmp`、`rgb565` 或 `rgb888`，不传时默认是 `bmp`。
$color_mode = 'RGB888'; // string | BMP 输出的颜色模式。只有在 `format=bmp` 时才生效，可以传 `RGB565` 或 `RGB888`，不传时默认是 `RGB888`。
$fit = 'contain'; // string | 缩放模式。可以传 `contain`、`cover` 或 `fill`，不传时默认是 `contain`。当传 `cover` 或 `fill` 时，`width` 和 `height` 都要传。
$background = 'black'; // string | 背景色。可以传 `black`、`white` 或 `#RRGGBB`，不传时默认是 `black`。
$file = '/path/to/file.txt'; // \SplFileObject | 要处理的图片文件。这个接口适合直接上传 JPG、JPEG、PNG、WebP、BMP 等常见格式。
$url = 'url_example'; // string | 要处理的图片链接。适合不方便直接上传文件时使用。

try {
    $result = $apiInstance->postImageDecode($width, $height, $max_width, $max_height, $format, $color_mode, $fit, $background, $file, $url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageDecode: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **width** | **int**| 目标宽度，单位是像素。可以单独传，也可以和 &#x60;height&#x60; 一起传。与 &#x60;max_width&#x60;、&#x60;max_height&#x60; 互斥。 | [optional] |
| **height** | **int**| 目标高度，单位是像素。可以单独传，也可以和 &#x60;width&#x60; 一起传。与 &#x60;max_width&#x60;、&#x60;max_height&#x60; 互斥。 | [optional] |
| **max_width** | **int**| 最大宽度，单位是像素。只有在不传 &#x60;width&#x60;、&#x60;height&#x60; 时才生效，会按原比例缩放。 | [optional] |
| **max_height** | **int**| 最大高度，单位是像素。只有在不传 &#x60;width&#x60;、&#x60;height&#x60; 时才生效，会按原比例缩放。 | [optional] |
| **format** | **string**| 输出格式。可以传 &#x60;bmp&#x60;、&#x60;rgb565&#x60; 或 &#x60;rgb888&#x60;，不传时默认是 &#x60;bmp&#x60;。 | [optional] [default to &#39;bmp&#39;] |
| **color_mode** | **string**| BMP 输出的颜色模式。只有在 &#x60;format&#x3D;bmp&#x60; 时才生效，可以传 &#x60;RGB565&#x60; 或 &#x60;RGB888&#x60;，不传时默认是 &#x60;RGB888&#x60;。 | [optional] [default to &#39;RGB888&#39;] |
| **fit** | **string**| 缩放模式。可以传 &#x60;contain&#x60;、&#x60;cover&#x60; 或 &#x60;fill&#x60;，不传时默认是 &#x60;contain&#x60;。当传 &#x60;cover&#x60; 或 &#x60;fill&#x60; 时，&#x60;width&#x60; 和 &#x60;height&#x60; 都要传。 | [optional] [default to &#39;contain&#39;] |
| **background** | **string**| 背景色。可以传 &#x60;black&#x60;、&#x60;white&#x60; 或 &#x60;#RRGGBB&#x60;，不传时默认是 &#x60;black&#x60;。 | [optional] [default to &#39;black&#39;] |
| **file** | **\SplFileObject****\SplFileObject**| 要处理的图片文件。这个接口适合直接上传 JPG、JPEG、PNG、WebP、BMP 等常见格式。 | [optional] |
| **url** | **string**| 要处理的图片链接。适合不方便直接上传文件时使用。 | [optional] |

### Return type

**\SplFileObject**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `image/bmp`, `application/octet-stream`, `application/json`

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
$post_image_frombase64_request = new \OpenAPI\Client\Model\PostImageFrombase64Request(); // \OpenAPI\Client\Model\PostImageFrombase64Request | 

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
| **post_image_frombase64_request** | [**\OpenAPI\Client\Model\PostImageFrombase64Request**](../Model/PostImageFrombase64Request.md)|  | |

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
postImageMotou($bg_color, $file, $image_url): \SplFileObject
```

生成摸摸头GIF

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
$bg_color = 'bg_color_example'; // string | GIF的背景颜色。可选值为 'white', 'black', 'transparent'。
$file = '/path/to/file.txt'; // \SplFileObject | 上传的图片文件。支持JPG、PNG、GIF等常见格式。
$image_url = 'image_url_example'; // string | 图片的URL地址。如果提供此项，将优先使用该URL的图片。

try {
    $result = $apiInstance->postImageMotou($bg_color, $file, $image_url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageMotou: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **bg_color** | **string**| GIF的背景颜色。可选值为 &#39;white&#39;, &#39;black&#39;, &#39;transparent&#39;。 | [optional] |
| **file** | **\SplFileObject****\SplFileObject**| 上传的图片文件。支持JPG、PNG、GIF等常见格式。 | [optional] |
| **image_url** | **string**| 图片的URL地址。如果提供此项，将优先使用该URL的图片。 | [optional] |

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

## `postImageNsfw()`

```php
postImageNsfw($file, $url): \OpenAPI\Client\Model\PostImageNsfw200Response
```

图片敏感检测

这是一个图片内容审核接口，自动识别图片中的违规内容并返回处理建议。  ## 功能概述 上传图片文件或提供图片URL，接口会自动分析图片内容，返回是否违规、风险等级和处理建议。适合对接到用户上传流程中，实现自动化内容审核。  ## 返回字段说明 - **is_nsfw**: 是否判定为违规内容，`true` 表示违规，`false` 表示正常 - **nsfw_score**: 违规内容置信度，0-1 之间，越高表示越可能违规 - **normal_score**: 正常内容置信度，0-1 之间，与 nsfw_score 互补 - **suggestion**: 处理建议   - `pass`: 内容正常，可以直接放行   - `review`: 存在风险，建议转人工复核   - `block`: 高风险内容，建议直接拦截 - **risk_level**: 风险等级   - `low`: 低风险   - `medium`: 中风险   - `high`: 高风险 - **label**: 内容标签，`nsfw` 或 `normal` - **confidence**: 模型对当前判断的整体置信度 - **inference_time_ms**: 模型推理耗时，单位毫秒

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: BearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$file = '/path/to/file.txt'; // \SplFileObject | 要检测的图片文件。支持 JPG、JPEG、PNG、GIF、WebP 格式，最大 20MB。
$url = 'url_example'; // string | 图片的 URL 地址。如果同时提供 file 和 url，将优先使用 file。

try {
    $result = $apiInstance->postImageNsfw($file, $url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageNsfw: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **file** | **\SplFileObject****\SplFileObject**| 要检测的图片文件。支持 JPG、JPEG、PNG、GIF、WebP 格式，最大 20MB。 | [optional] |
| **url** | **string**| 图片的 URL 地址。如果同时提供 file 和 url，将优先使用 file。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\PostImageNsfw200Response**](../Model/PostImageNsfw200Response.md)

### Authorization

[BearerAuth](../../README.md#BearerAuth)

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageOcr()`

```php
postImageOcr($enable_cls, $file, $image_base64, $image_name, $need_location, $return_markdown, $url): \OpenAPI\Client\Model\PostImageOcr200Response
```

通用 OCR 文字识别

无论您是需要实现票据的自动化录入，还是在网页前端对图片上的文字进行坐标框选，这个高精度的 OCR 接口都能为您提供强大的基础能力。  ## 功能概述 > [!IMPORTANT] > 如果您只关心图片上写了什么（例如截图取字或内容安全审核），强烈建议将 `need_location` 设置为 `false`。这会大幅精简返回的 JSON 数据体积，提升网络传输与系统解析效率。  除了常规的图片转文字，这个接口还针对实际开发场景做了一些实用设计： - **前端文字高亮与结构化分析**：默认返回每一段文字的矩形坐标和四个顶点坐标。这非常适合使用 Canvas 在原图上画框高亮，或者在后端根据相对位置提取票据中的键值对信息。 - **复杂拍摄环境下的抗畸变**：针对手机拍摄导致的旋转或倾斜，可以开启 `enable_cls=true`。服务端在识别前会自动进行方向预校正，显著提升识别准确率。 - **灵活的输入与请求要求**：接口支持 `file`、`url` 或 `image_base64` 三种方式输入。请确保请求格式为 `multipart/form-data`，且图片链接在公网可直接访问。

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\ImageApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$enable_cls = 'false'; // string | 是否开启额外的文字方向校正。请传 `true` 或 `false`，不传时默认是 `false`。
$file = '/path/to/file.txt'; // \SplFileObject | 待识别的图片文件。支持 JPG、JPEG、PNG、BMP、GIF、WebP 等常见格式，最大不超过 10MB。请勿与 url 或 image_base64 同时提交。
$image_base64 = 'image_base64_example'; // string | 图片的 Base64 字符串。可以传完整 Data URI，也可以只传纯 Base64 内容。请勿与 file 或 url 同时提交。
$image_name = 'image_name_example'; // string | 自定义图片文件名。传链接或纯 Base64 时建议一起传，便于保留或推断扩展名。
$need_location = 'true'; // string | 是否返回文字坐标信息。请传 `true` 或 `false`，不传时默认是 `true`。
$return_markdown = 'false'; // string | 是否额外返回整理后的 Markdown 文本。请传 `true` 或 `false`，不传时默认是 `false`。
$url = 'url_example'; // string | 公网可直接访问的图片地址。请勿与 file 或 image_base64 同时提交。

try {
    $result = $apiInstance->postImageOcr($enable_cls, $file, $image_base64, $image_name, $need_location, $return_markdown, $url);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ImageApi->postImageOcr: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **enable_cls** | **string**| 是否开启额外的文字方向校正。请传 &#x60;true&#x60; 或 &#x60;false&#x60;，不传时默认是 &#x60;false&#x60;。 | [optional] [default to &#39;false&#39;] |
| **file** | **\SplFileObject****\SplFileObject**| 待识别的图片文件。支持 JPG、JPEG、PNG、BMP、GIF、WebP 等常见格式，最大不超过 10MB。请勿与 url 或 image_base64 同时提交。 | [optional] |
| **image_base64** | **string**| 图片的 Base64 字符串。可以传完整 Data URI，也可以只传纯 Base64 内容。请勿与 file 或 url 同时提交。 | [optional] |
| **image_name** | **string**| 自定义图片文件名。传链接或纯 Base64 时建议一起传，便于保留或推断扩展名。 | [optional] |
| **need_location** | **string**| 是否返回文字坐标信息。请传 &#x60;true&#x60; 或 &#x60;false&#x60;，不传时默认是 &#x60;true&#x60;。 | [optional] [default to &#39;true&#39;] |
| **return_markdown** | **string**| 是否额外返回整理后的 Markdown 文本。请传 &#x60;true&#x60; 或 &#x60;false&#x60;，不传时默认是 &#x60;false&#x60;。 | [optional] [default to &#39;false&#39;] |
| **url** | **string**| 公网可直接访问的图片地址。请勿与 file 或 image_base64 同时提交。 | [optional] |

### Return type

[**\OpenAPI\Client\Model\PostImageOcr200Response**](../Model/PostImageOcr200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `postImageSpeechless()`

```php
postImageSpeechless($post_image_speechless_request): \SplFileObject
```

生成你们怎么不说话了表情包

你们怎么不说话了？是不是都在偷偷玩Uapi，求求你们不要玩Uapi了  ## 使用须知 - **响应格式**：接口成功时直接返回 `image/png` 格式的二进制数据。 - **文字内容**：至少需要提供 `top_text`（上方文字）或 `bottom_text`（下方文字）之一。 - **梗图逻辑**：上方描述某个行为，下方通常以「们」开头表示劝阻，形成戏谑的对比效果。

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
- **Accept**: `image/png`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
