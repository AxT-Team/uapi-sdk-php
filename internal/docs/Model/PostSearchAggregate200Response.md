# # PostSearchAggregate200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**query** | **string** | 实际执行的搜索查询 | [optional]
**total_results** | **int** | 搜索结果总数 | [optional]
**results** | [**\OpenAPI\Client\Model\PostSearchAggregate200ResponseResultsInner[]**](PostSearchAggregate200ResponseResultsInner.md) | 搜索结果列表 | [optional]
**sources** | [**\OpenAPI\Client\Model\PostSearchAggregate200ResponseSourcesInner[]**](PostSearchAggregate200ResponseSourcesInner.md) | 各搜索引擎的结果数量统计 | [optional]
**process_time_ms** | **int** | 处理耗时（毫秒） | [optional]
**cached** | **bool** | 结果是否来自缓存 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
