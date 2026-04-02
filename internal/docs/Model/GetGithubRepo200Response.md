# # GetGithubRepo200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**full_name** | **string** | 仓库完整名称。 | [optional]
**description** | **string** | 仓库简介。 | [optional]
**homepage** | **string** | 仓库主页链接。 | [optional]
**default_branch** | **string** | 默认分支名称。 | [optional]
**primary_branch** | **string** | 主要分支名称（通常与默认分支一致）。 | [optional]
**default_branch_sha** | **string** | 默认分支最新提交的 SHA 哈希。 | [optional]
**visibility** | **string** | 仓库可见性，常见值为 &#x60;public&#x60; 或 &#x60;private&#x60;。 | [optional]
**archived** | **bool** | 仓库是否已归档。 | [optional]
**disabled** | **bool** | 仓库是否被禁用。 | [optional]
**fork** | **bool** | 是否为 Fork 仓库。 | [optional]
**language** | **string** | 主要语言。 | [optional]
**topics** | **string[]** | 话题标签列表。 | [optional]
**license** | **string** | 开源许可证名称。 | [optional]
**stargazers** | **int** | Star 数。 | [optional]
**forks** | **int** | Fork 数。 | [optional]
**open_issues** | **int** | 开放 Issue 数。 | [optional]
**watchers** | **int** | 关注者数量（watchers/subscribers）。 | [optional]
**pushed_at** | **\DateTime** | 最后推送时间（ISO 8601）。 | [optional]
**created_at** | **\DateTime** | 创建时间（ISO 8601）。 | [optional]
**updated_at** | **\DateTime** | 更新时间（ISO 8601）。 | [optional]
**languages** | **array<string,int>** | 语言统计（键为语言名，值为代码字节数）。 | [optional]
**collaborators** | [**\OpenAPI\Client\Model\GetGithubRepo200ResponseCollaboratorsInner[]**](GetGithubRepo200ResponseCollaboratorsInner.md) | 协作者列表。受权限限制时可能为 null 或空数组。 | [optional]
**maintainers** | [**\OpenAPI\Client\Model\GetGithubRepo200ResponseCollaboratorsInner[]**](GetGithubRepo200ResponseCollaboratorsInner.md) | 维护者列表（根据默认分支近期提交推断）。 | [optional]
**latest_release** | [**\OpenAPI\Client\Model\GetGithubRepo200ResponseLatestRelease**](GetGithubRepo200ResponseLatestRelease.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
