# # GetGithubUser200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**login** | **string** | GitHub 登录名。 | [optional]
**name** | **string** | 用户公开显示的名称。 | [optional]
**bio** | **string** | 用户个人简介。 | [optional]
**company** | **string** | 用户填写的公司或组织信息。 | [optional]
**location** | **string** | 用户公开展示的地理位置。 | [optional]
**blog** | **string** | 用户填写的网站或博客地址。 | [optional]
**twitter_username** | **string** | 用户绑定的 X（Twitter）用户名。 | [optional]
**email** | **string** | 用户公开可见的邮箱地址。 | [optional]
**html_url** | **string** | GitHub 个人主页链接。 | [optional]
**avatar_url** | **string** | 用户头像图片链接。 | [optional]
**type** | **string** | 账号类型，常见值为 User 或 Organization。 | [optional]
**public_repos** | **int** | 公开仓库数量。 | [optional]
**public_gists** | **int** | 公开 Gist 数量。 | [optional]
**followers** | **int** | 关注该用户的人数。 | [optional]
**following** | **int** | 该用户正在关注的人数。 | [optional]
**created_at** | **\DateTime** | GitHub 账号创建时间（ISO 8601）。 | [optional]
**updated_at** | **\DateTime** | 用户资料最近更新时间（ISO 8601）。 | [optional]
**organizations** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseOrganizationsInner[]**](GetGithubUser200ResponseOrganizationsInner.md) | 用户公开加入的组织列表 | [optional]
**activity** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseActivity**](GetGithubUser200ResponseActivity.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
