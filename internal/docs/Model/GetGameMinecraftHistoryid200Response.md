# # GetGameMinecraftHistoryid200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**query** | **string** | 【name 查询时返回】查询的用户名。 | [optional]
**count** | **int** | 【name 查询时返回】匹配到的用户数量，为 0 时表示未找到。 | [optional]
**results** | [**\OpenAPI\Client\Model\GetGameMinecraftHistoryid200ResponseResultsInner[]**](GetGameMinecraftHistoryid200ResponseResultsInner.md) | 【name 查询时返回】匹配用户列表，包含当前用户名或曾用名匹配的所有玩家。 | [optional]
**id** | **string** | 【uuid 查询时返回】玩家当前的用户名。 | [optional]
**uuid** | **string** | 【uuid 查询时返回】被查询玩家的UUID（带连字符格式）。 | [optional]
**name_num** | **int** | 【uuid 查询时返回】历史名称的总数（包含当前名称）。 | [optional]
**history** | [**\OpenAPI\Client\Model\GetGameMinecraftHistoryid200ResponseHistoryInner[]**](GetGameMinecraftHistoryid200ResponseHistoryInner.md) | 【uuid 查询时返回】包含所有历史用户名的数组，按时间倒序排列。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
