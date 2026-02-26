# # PostTextAesEncryptAdvancedRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**text** | **string** | 待加密的明文文本 |
**key** | **string** | 加密密钥（支持任意长度） |
**mode** | **string** | 加密模式：GCM/CBC/ECB/CTR/OFB/CFB（可选，默认GCM） | [optional]
**padding** | **string** | 填充方式：PKCS7/ZERO/NONE（可选，默认PKCS7） | [optional]
**iv** | **string** | 自定义IV（可选，Base64编码，16字节）。GCM模式无需此参数 | [optional]
**output_format** | **string** | 输出格式：base64（默认）或hex | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
