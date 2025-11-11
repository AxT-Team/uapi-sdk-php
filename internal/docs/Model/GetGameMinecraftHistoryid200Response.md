# # GetGameMinecraftHistoryid200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**code** | **int** | 状态码，200代表成功。 | [optional]
**history** | [**\OpenAPI\Client\Model\GetGameMinecraftHistoryid200ResponseHistoryInner[]**](GetGameMinecraftHistoryid200ResponseHistoryInner.md) | 一个包含所有历史用户名的数组，按时间倒序排列。 | [optional]
**id** | **string** | 玩家当前的用户名。 | [optional]
**name_num** | **int** | 历史名称的总数（包含当前名称）。 | [optional]
**uuid** | **string** | 被查询玩家的32位无破折号UUID。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
