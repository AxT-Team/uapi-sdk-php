# # GetGithubUser200ResponseActivity

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**contribution_calendar** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseActivityContributionCalendar**](GetGithubUser200ResponseActivityContributionCalendar.md) |  | [optional]
**from** | **string** | 统计开始日期。 | [optional]
**organization** | **string** | 按组织过滤时对应的组织登录名。 | [optional]
**scope** | **string** | 活动统计范围，常见值为 all 或 organization。 | [optional]
**timeline** | [**\OpenAPI\Client\Model\GetGithubUser200ResponseActivityTimelineInner[]**](GetGithubUser200ResponseActivityTimelineInner.md) | 按月份聚合后的贡献时间线。 | [optional]
**to** | **string** | 统计结束日期。 | [optional]
**total_commit_contributions** | **int** | Commit 贡献总数。 | [optional]
**total_contributions** | **int** | 统计范围内的总贡献数。 | [optional]
**total_issue_contributions** | **int** | Issue 贡献总数。 | [optional]
**total_pull_request_contributions** | **int** | Pull Request 贡献总数。 | [optional]
**total_pull_request_review_contributions** | **int** | Pull Request Review 贡献总数。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
