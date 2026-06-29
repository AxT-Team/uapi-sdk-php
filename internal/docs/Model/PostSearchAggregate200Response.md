# # PostSearchAggregate200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**metadata** | [**\OpenAPI\Client\Model\PostSearchAggregate200ResponseMetadata**](PostSearchAggregate200ResponseMetadata.md) |  | [optional]
**process_time_ms** | **int** | 本次请求总耗时（毫秒） | [optional]
**query** | **string** | 执行的搜索查询 | [optional]
**results** | [**\OpenAPI\Client\Model\PostSearchAggregate200ResponseResultsInner[]**](PostSearchAggregate200ResponseResultsInner.md) | 搜索结果列表 | [optional]
**sources** | [**\OpenAPI\Client\Model\PostSearchAggregate200ResponseSourcesInner[]**](PostSearchAggregate200ResponseSourcesInner.md) | 本次请求实际命中的搜索引擎信息 | [optional]
**total_results** | **int** | 返回的搜索结果总数 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
