# # PostImageOcr200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**blocks** | **object[]** | 按块组织的详细识别结果。 | [optional]
**image** | **object** | 图片本身的基础信息。 | [optional]
**lines** | **object[]** | 按行组织的详细识别结果。 | [optional]
**markdown** | **string** | 根据图片中的标题、段落和表格整理出的 Markdown 文本。只有在 &#x60;return_markdown&#x3D;true&#x60; 时才会返回。 | [optional]
**need_location** | **bool** | 本次响应是否包含坐标信息。 | [optional]
**pages** | **object[]** | 按页组织的详细识别结果。 | [optional]
**plain_text** | **string** | 纯文本结果，适合做搜索、索引或直接展示。 | [optional]
**raw** | **object** | 补充识别结果对象，适合需要继续解析更多细节字段的场景。 | [optional]
**summary** | **object** | 识别结果的统计摘要。 | [optional]
**text** | **string** | 按阅读顺序拼接后的识别文本。 | [optional]
**timing** | **object** | 耗时拆分信息，适合做性能统计或排查。 | [optional]
**words_result** | [**\OpenAPI\Client\Model\PostImageOcr200ResponseWordsResultInner[]**](PostImageOcr200ResponseWordsResultInner.md) | 逐段文字结果。适合做高亮、框选和逐项解析。 | [optional]
**words_result_num** | **int** | 识别出的文字片段数量。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
