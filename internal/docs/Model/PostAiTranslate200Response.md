# # PostAiTranslate200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**code** | **int** |  | [optional]
**message** | **string** |  | [optional]
**is_batch** | **bool** | 标识是否为批量翻译请求。 | [optional]
**data** | [**\OpenAPI\Client\Model\PostAiTranslate200ResponseData**](PostAiTranslate200ResponseData.md) |  | [optional]
**batch_data** | [**\OpenAPI\Client\Model\PostAiTranslate200ResponseBatchDataInner[]**](PostAiTranslate200ResponseBatchDataInner.md) | 批量翻译结果列表，仅在批量翻译时返回。 | [optional]
**batch_summary** | [**\OpenAPI\Client\Model\PostAiTranslate200ResponseBatchSummary**](PostAiTranslate200ResponseBatchSummary.md) |  | [optional]
**performance** | [**\OpenAPI\Client\Model\PostAiTranslate200ResponsePerformance**](PostAiTranslate200ResponsePerformance.md) |  | [optional]
**quality_metrics** | [**\OpenAPI\Client\Model\PostAiTranslate200ResponseQualityMetrics**](PostAiTranslate200ResponseQualityMetrics.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
