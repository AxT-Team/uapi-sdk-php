# # GetMiscHotboard200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**list** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseOneOfListInner[]**](GetMiscHotboard200ResponseOneOfListInner.md) | 热榜条目列表。 | [optional]
**snapshot_time** | **int** | 时光机模式返回的快照实际时间戳（毫秒）。当前热榜模式下通常不返回。 | [optional]
**type** | **string** |  | [optional]
**update_time** | **string** | 热榜更新时间。时光机模式下对应返回快照的更新时间。 | [optional]
**count** | **int** | 匹配到的结果数量。 | [optional]
**keyword** | **string** | 搜索关键词。 | [optional]
**results** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseOneOf1ResultsInner[]**](GetMiscHotboard200ResponseOneOf1ResultsInner.md) | 搜索结果数组。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
