# # GetMiscHotboard200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | **string** |  | [optional]
**update_time** | **string** | 热榜更新时间。时光机无匹配快照时可能为空字符串。 | [optional]
**snapshot_time** | **int** | 时光机模式返回的快照实际时间戳（毫秒）。当前热榜模式下通常不返回。 | [optional]
**list** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseOneOfListInner[]**](GetMiscHotboard200ResponseOneOfListInner.md) | 热榜条目列表。 | [optional]
**keyword** | **string** | 搜索关键词。 | [optional]
**count** | **int** | 匹配到的结果数量。 | [optional]
**results** | [**\OpenAPI\Client\Model\GetMiscHotboard200ResponseOneOf1ResultsInner[]**](GetMiscHotboard200ResponseOneOf1ResultsInner.md) | 搜索结果数组。 | [optional]
**sources** | **string[]** | 支持历史数据的平台列表。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
