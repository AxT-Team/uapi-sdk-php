# # GetSocialBilibiliVideoinfo200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**bvid** | **string** | 稿件的BV号。 | [optional]
**aid** | **float** | 稿件的AV号。 | [optional]
**videos** | **float** | 稿件分P总数。如果是单P视频，则为1。 | [optional]
**tid** | **float** | 视频所属的子分区 ID。 | [optional]
**tname** | **string** | 视频所属的子分区名称。 | [optional]
**copyright** | **float** | 视频类型。1代表原创，2代表转载。 | [optional]
**pic** | **string** | 稿件封面图片的URL。这是一个可以直接在网页上展示的链接。 | [optional]
**title** | **string** | 稿件的标题。 | [optional]
**pubdate** | **float** | 稿件发布时间的Unix时间戳（秒）。 | [optional]
**ctime** | **float** | 用户投稿时间的Unix时间戳（秒）。 | [optional]
**desc** | **string** | 视频简介。可能会包含HTML换行符。 | [optional]
**desc_v2** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseDescV2Inner[]**](GetSocialBilibiliVideoinfo200ResponseDescV2Inner.md) | 结构化简介片段。 | [optional]
**state** | **float** | 视频状态码。 | [optional]
**duration** | **float** | 稿件总时长（所有分P累加），单位为秒。 | [optional]
**rights** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseRights**](GetSocialBilibiliVideoinfo200ResponseRights.md) |  | [optional]
**owner** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseOwner**](GetSocialBilibiliVideoinfo200ResponseOwner.md) |  | [optional]
**stat** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseStat**](GetSocialBilibiliVideoinfo200ResponseStat.md) |  | [optional]
**dynamic** | **string** | 投稿时附带的动态文字。 | [optional]
**cid** | **float** | 主分P的 CID（弹幕 ID）。 | [optional]
**dimension** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseDimension**](GetSocialBilibiliVideoinfo200ResponseDimension.md) |  | [optional]
**no_cache** | **bool** | 不缓存标记。 | [optional]
**pages** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponsePagesInner[]**](GetSocialBilibiliVideoinfo200ResponsePagesInner.md) | 视频分P列表。即使是单P视频，该数组也包含一个元素。 | [optional]
**subtitle** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseSubtitle**](GetSocialBilibiliVideoinfo200ResponseSubtitle.md) |  | [optional]
**staff** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseStaffInner[]**](GetSocialBilibiliVideoinfo200ResponseStaffInner.md) | 联合投稿成员列表。 | [optional]
**ugc_season** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseUgcSeason**](GetSocialBilibiliVideoinfo200ResponseUgcSeason.md) |  | [optional]
**is_chargeable_season** | **bool** | 是否为付费合集。 | [optional]
**is_story** | **bool** | 是否为剧情类视频。 | [optional]
**honor_reply** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseHonorReply**](GetSocialBilibiliVideoinfo200ResponseHonorReply.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
