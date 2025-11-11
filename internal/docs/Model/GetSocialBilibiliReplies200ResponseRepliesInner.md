# # GetSocialBilibiliReplies200ResponseRepliesInner

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**rpid** | **float** | 评论的唯一ID (Reply ID)。 | [optional]
**oid** | **float** | 评论区对象ID，即视频的aid。 | [optional]
**mid** | **float** | 发表评论的用户的mid。 | [optional]
**root** | **float** | 根评论的rpid。如果为0，表示这条评论是根评论。 | [optional]
**parent** | **float** | 回复的父级评论的rpid。如果为0，表示是根评论。 | [optional]
**count** | **float** | 这条评论下的回复（楼中楼）数量。 | [optional]
**ctime** | **float** | 评论发送时间的Unix时间戳（秒）。 | [optional]
**like** | **float** | 该评论获得的点赞数。 | [optional]
**member** | [**\OpenAPI\Client\Model\GetSocialBilibiliReplies200ResponseRepliesInnerMember**](GetSocialBilibiliReplies200ResponseRepliesInnerMember.md) |  | [optional]
**content** | [**\OpenAPI\Client\Model\GetSocialBilibiliReplies200ResponseRepliesInnerContent**](GetSocialBilibiliReplies200ResponseRepliesInnerContent.md) |  | [optional]
**replies** | **object[]** | 楼中楼回复列表。结构与顶层评论对象一致，但通常此数组为空，需要单独请求。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
