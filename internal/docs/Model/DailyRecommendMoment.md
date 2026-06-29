# # DailyRecommendMoment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**current_time** | **string** | 仅 moment 模式返回，服务器当前时间，ISO 8601 格式。 | [optional]
**date** | **string** | 仅 daily 模式返回，对应日期，格式 YYYY-MM-DD。 | [optional]
**item** | [**\OpenAPI\Client\Model\DailyRecommendMomentItem**](DailyRecommendMomentItem.md) |  | [optional]
**mode** | **string** | 当前运行模式。 | [optional]
**scene** | [**\OpenAPI\Client\Model\DailyRecommendMomentScene**](DailyRecommendMomentScene.md) |  | [optional]
**seed** | **string** | 当次结果的确定性种子。 | [optional]
**time_segment** | **string** | 仅 moment 模式返回，命中的时段标识。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
