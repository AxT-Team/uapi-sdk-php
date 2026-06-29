# # PostWatermarkLabel200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**applied** | **string[]** | 本次实际注入成功的标识层级，可能包含 &#39;watermark&#39;、&#39;explicit&#39;、&#39;metadata&#39;。 | [optional]
**capacity_chars** | **int** | 当前配置下的隐形水印最大容量（若开启）。 | [optional]
**content_producer** | **string** | 成功写入的服务提供者编码。 | [optional]
**format** | **string** | 实际输出的图片格式。 | [optional]
**image_base64** | **string** | 处理完成后的图片 Base64 编码。 | [optional]
**image_name** | **string** | 原始图片文件名（若请求中包含则返回）。 | [optional]
**watermark_payload** | **string** | 成功嵌入的隐形水印内容（若开启）。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
