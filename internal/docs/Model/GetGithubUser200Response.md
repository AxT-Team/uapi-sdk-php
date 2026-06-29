# # GetGithubUser200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**activity** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseActivity**](GetGithubUser200ResponseActivity.md) |  | [optional]
**avatar_url** | **string** | 用户头像图片链接。 | [optional]
**bio** | **string** | 用户个人简介。 | [optional]
**blog** | **string** | 用户填写的网站或博客地址。 | [optional]
**company** | **string** | 用户填写的公司或组织信息。 | [optional]
**created_at** | **\DateTime** | GitHub 账号创建时间（ISO 8601）。 | [optional]
**email** | **string** | 用户公开可见的邮箱地址。 | [optional]
**followers** | **int** | 关注该用户的人数。 | [optional]
**following** | **int** | 该用户正在关注的人数。 | [optional]
**html_url** | **string** | GitHub 个人主页链接。 | [optional]
**location** | **string** | 用户公开展示的地理位置。 | [optional]
**login** | **string** | GitHub 登录名。 | [optional]
**name** | **string** | 用户公开显示的名称。 | [optional]
**organizations** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseOrganizationsInner[]**](GetGithubUser200ResponseOrganizationsInner.md) | 用户公开加入的组织列表 | [optional]
**pinned_repositories** | [**\OpenAPI\Client\Model\GetGithubUser200ResponsePinnedRepositoriesInner[]**](GetGithubUser200ResponsePinnedRepositoriesInner.md) | 用户主页展示的 pinned 仓库列表（需开启 pinned&#x3D;true）。 | [optional]
**public_gists** | **int** | 公开 Gist 数量。 | [optional]
**public_repos** | **int** | 公开仓库数量。 | [optional]
**repositories** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseRepositoriesInner[]**](GetGithubUser200ResponseRepositoriesInner.md) | 最近活跃的公开仓库列表（需开启 repos&#x3D;true 或传入 repos_limit）。 | [optional]
**twitter_username** | **string** | 用户绑定的 X（Twitter）用户名。 | [optional]
**type** | **string** | 账号类型，常见值为 User 或 Organization。 | [optional]
**updated_at** | **\DateTime** | 用户资料最近更新时间（ISO 8601）。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
