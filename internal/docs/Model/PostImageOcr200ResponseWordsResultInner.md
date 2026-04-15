# # PostImageOcr200ResponseWordsResultInner

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**words** | **string** | 当前文字片段的识别结果。 | [optional]
**location** | [**\OpenAPI\Client\Model\PostImageOcr200ResponseWordsResultInnerLocation**](PostImageOcr200ResponseWordsResultInnerLocation.md) |  | [optional]
**vertexes_location** | [**\OpenAPI\Client\Model\PostImageOcr200ResponseWordsResultInnerVertexesLocationInner[]**](PostImageOcr200ResponseWordsResultInnerVertexesLocationInner.md) | 当前文字片段的顶点坐标列表。只有在 &#x60;need_location&#x3D;true&#x60; 时才会返回。 | [optional]
**score** | **float** | 当前文字片段的置信度。部分结果会返回。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
