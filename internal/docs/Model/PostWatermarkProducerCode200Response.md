# # PostWatermarkProducerCode200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**binding** | **string** | 解析出的证件绑定方式。 | [optional]
**code** | **string** | 标准的 27 位服务提供者编码。 | [optional]
**identifier** | **string** | 剔除补位后的主体证件原始明文。 | [optional]
**model_code** | **string** | 解析出的模型/应用码（启用扩展时存在）。 | [optional]
**service_extension** | **bool** | 编码中是否启用了服务扩展段。 | [optional]
**service_type** | **string** | 解析出的服务角色类型（启用扩展时存在）。 | [optional]
**subject_code** | **string** | 包含补位逻辑在内的 18 位主体特征段。 | [optional]
**subject_type** | **string** | 解析出的主体类型。 | [optional]
**valid** | **bool** | 该编码是否合规合法。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
