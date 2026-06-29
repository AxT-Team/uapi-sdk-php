# # GetMiscTrackingQuery200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**carrier_code** | **string** | 快递公司编码 | [optional]
**carrier_name** | **string** | 快递公司名称 | [optional]
**completed_at** | **string** | 完成时间。仅已完成时返回签收或妥投对应的轨迹时间；未完成时为空字符串。 | [optional]
**is_completed** | **bool** | 快递是否已完成。仅当状态识别为已签收/已妥投/已完成时为 true。 | [optional]
**status** | **string** | 快递状态中文名称，例如：待揽收、已揽收、运输中、派送中、已完成、异常、未知。 | [optional]
**status_code** | **string** | 快递状态编码。可能值：pending、picked_up、in_transit、out_for_delivery、delivered、exception、unknown。 | [optional]
**track_count** | **int** | 物流轨迹数量 | [optional]
**tracking_number** | **string** | 快递单号 | [optional]
**tracks** | [**\OpenAPI\Client\Model\GetMiscTrackingQuery200ResponseTracksInner[]**](GetMiscTrackingQuery200ResponseTracksInner.md) | 物流轨迹列表，按时间倒序排列 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
