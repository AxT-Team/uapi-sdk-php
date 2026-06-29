# # GetSocialBilibiliVideoinfo200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**aid** | **float** | 稿件的AV号。 | [optional]
**bvid** | **string** | 稿件的BV号。 | [optional]
**cid** | **float** | 主分P的 CID（弹幕 ID）。 | [optional]
**copyright** | **float** | 视频类型。1代表原创，2代表转载。 | [optional]
**ctime** | **float** | 用户投稿时间的Unix时间戳（秒）。 | [optional]
**desc** | **string** | 视频简介。可能会包含HTML换行符。 | [optional]
**desc_v2** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseDescV2Inner[]**](GetSocialBilibiliVideoinfo200ResponseDescV2Inner.md) | 结构化简介片段。 | [optional]
**dimension** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseDimension**](GetSocialBilibiliVideoinfo200ResponseDimension.md) |  | [optional]
**duration** | **float** | 稿件总时长（所有分P累加），单位为秒。 | [optional]
**dynamic** | **string** | 投稿时附带的动态文字。 | [optional]
**honor_reply** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseHonorReply**](GetSocialBilibiliVideoinfo200ResponseHonorReply.md) |  | [optional]
**is_chargeable_season** | **bool** | 是否为付费合集。 | [optional]
**is_story** | **bool** | 是否为剧情类视频。 | [optional]
**is_upower_exclusive** | **bool** | 是否为充电专属视频。该字段来自 B 站视频详情，用于区分普通免费视频和充电专属内容。 | [optional]
**is_upower_exclusive_with_qa** | **bool** | 是否为带问答/互动限制的充电专属视频。 | [optional]
**is_upower_play** | **bool** | 当前视频是否属于充电可播放状态。 | [optional]
**is_upower_preview** | **bool** | 当前视频是否为充电专属试看状态。 | [optional]
**no_cache** | **bool** | 不缓存标记。 | [optional]
**owner** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseOwner**](GetSocialBilibiliVideoinfo200ResponseOwner.md) |  | [optional]
**pages** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponsePagesInner[]**](GetSocialBilibiliVideoinfo200ResponsePagesInner.md) | 视频分P列表。即使是单P视频，该数组也包含一个元素。 | [optional]
**pay_type** | **string** | 归一化付费类型。可能值：free、upower_exclusive、upower、ugc_pay、pgc_pay。 | [optional]
**pic** | **string** | 稿件封面图片的URL。这是一个可以直接在网页上展示的链接。 | [optional]
**pubdate** | **float** | 稿件发布时间的Unix时间戳（秒）。 | [optional]
**rights** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseRights**](GetSocialBilibiliVideoinfo200ResponseRights.md) |  | [optional]
**staff** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseStaffInner[]**](GetSocialBilibiliVideoinfo200ResponseStaffInner.md) | 联合投稿成员列表。 | [optional]
**stat** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseStat**](GetSocialBilibiliVideoinfo200ResponseStat.md) |  | [optional]
**state** | **float** | 视频状态码。 | [optional]
**subtitle** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseSubtitle**](GetSocialBilibiliVideoinfo200ResponseSubtitle.md) |  | [optional]
**tid** | **float** | 视频所属的子分区 ID。 | [optional]
**title** | **string** | 稿件的标题。 | [optional]
**tname** | **string** | 视频所属的子分区名称。 | [optional]
**ugc_season** | [**\OpenAPI\Client\Model\GetSocialBilibiliVideoinfo200ResponseUgcSeason**](GetSocialBilibiliVideoinfo200ResponseUgcSeason.md) |  | [optional]
**videos** | **float** | 稿件分P总数。如果是单P视频，则为1。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
