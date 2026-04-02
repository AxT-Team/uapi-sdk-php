# # GetSocialBilibiliLiveroom200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**uid** | **float** | 主播的用户ID (mid)。 | [optional]
**room_id** | **float** | 直播间的真实房间号（长号）。 | [optional]
**short_id** | **float** | 直播间的短号（靓号）。如果没有设置，则为0。 | [optional]
**attention** | **float** | 主播的粉丝数（关注数量）。 | [optional]
**online** | **float** | 直播间当前的人气值（对应你文档里的 PopularValue，不代表真实在线人数）。 | [optional]
**is_portrait** | **bool** | 是否为竖屏直播。 | [optional]
**live_status** | **float** | 直播状态。0:未开播, 1:直播中, 2:轮播中。 | [optional]
**area_id** | **float** | 分区ID。 | [optional]
**parent_area_name** | **string** | 父分区名称。 | [optional]
**parent_area_id** | **float** | 父分区 ID。 | [optional]
**area_name** | **string** | 子分区名称。 | [optional]
**background** | **string** | 直播间背景图的URL。 | [optional]
**title** | **string** | 当前直播间的标题。 | [optional]
**user_cover** | **string** | 用户设置的直播间封面URL。 | [optional]
**description** | **string** | 直播间公告或描述，支持换行符。 | [optional]
**live_time** | **string** | 本次直播开始的时间，格式为 &#x60;YYYY-MM-DD HH:mm:ss&#x60;。如果未开播，则为空字符串。 | [optional]
**keyframe** | **string** | 关键帧封面图链接。 | [optional]
**tags** | **string** | 直播间设置的标签，以逗号分隔。 | [optional]
**hot_words** | **string[]** | 直播间热词列表，通常用于弹幕互动。 | [optional]
**new_pendants** | [**\OpenAPI\Client\Model\GetSocialBilibiliLiveroom200ResponseNewPendants**](GetSocialBilibiliLiveroom200ResponseNewPendants.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
