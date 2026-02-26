# # PostImageNsfw200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**nsfw_score** | **float** | NSFW 内容的置信度分数，范围 0-1，越高表示越可能是敏感内容。 | [optional]
**normal_score** | **float** | 正常内容的置信度分数，范围 0-1。 | [optional]
**is_nsfw** | **bool** | 是否判定为 NSFW 内容。 | [optional]
**label** | **string** | 内容标签，&#39;nsfw&#39; 或 &#39;normal&#39;。 | [optional]
**suggestion** | **string** | 处理建议：&#39;pass&#39;（通过）、&#39;review&#39;（人工复核）、&#39;block&#39;（拦截）。 | [optional]
**risk_level** | **string** | 风险等级：&#39;low&#39;、&#39;medium&#39;、&#39;high&#39;。 | [optional]
**confidence** | **float** | 模型对当前判断的置信度。 | [optional]
**inference_time_ms** | **float** | 模型推理耗时，单位毫秒。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
