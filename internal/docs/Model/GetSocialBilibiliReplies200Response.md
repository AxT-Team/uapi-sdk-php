# # GetSocialBilibiliReplies200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**page** | [**\OpenAPI\Client\Model\GetSocialBilibiliReplies200ResponsePage**](GetSocialBilibiliReplies200ResponsePage.md) |  | [optional]
**config** | **object** | 评论区配置。不同视频或不同权限下可能为 null。 | [optional]
**hots** | **object[]** | 热门评论列表。结构与 &#x60;replies&#x60; 中的对象一致。如果当前页是第一页，且有热门评论，则此数组非空。 | [optional]
**replies** | [**\OpenAPI\Client\Model\GetSocialBilibiliReplies200ResponseRepliesInner[]**](GetSocialBilibiliReplies200ResponseRepliesInner.md) | 当前页的评论列表。 | [optional]
**upper** | **object** | UP 主相关信息。无数据时为 null。 | [optional]
**top** | **object** | 置顶评论信息。没有置顶评论时为 null。 | [optional]
**notice** | **object** | 评论区公告信息。没有公告时为 null。 | [optional]
**vote** | **float** | 评论区投票相关状态值。没有投票时通常为 0。 | [optional]
**folder** | **object** | 评论折叠相关信息。没有数据时为 null。 | [optional]
**control** | **object** | 评论区控制信息。没有数据时为 null。 | [optional]
**cursor** | **object** | 游标翻页信息。部分场景下为 null。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
