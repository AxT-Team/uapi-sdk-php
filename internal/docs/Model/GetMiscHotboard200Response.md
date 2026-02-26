# # GetMiscHotboard200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**list** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseListInner[]**](GetMiscHotboard200ResponseListInner.md) | 热榜条目列表。 | [optional]
**type** | **string** |  | [optional]
**update_time** | **string** |  | [optional]
**snapshot_time** | **int** | 时光机模式返回的快照实际时间戳（毫秒）。 | [optional]
**keyword** | **string** | 搜索模式返回的搜索关键词。 | [optional]
**count** | **int** | 搜索模式返回的结果数量。 | [optional]
**results** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseResultsInner[]**](GetMiscHotboard200ResponseResultsInner.md) | 搜索模式返回的结果数组。 | [optional]
**sources** | **string[]** | 数据源列表模式返回的可用历史数据源数组。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
