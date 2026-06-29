# # PostSearchAggregateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**fetch_full** | **bool** | 是否获取页面完整正文（会影响响应时间） | [optional] [default to false]
**filetype** | **string** | 限制文件类型，不需要 &#x60;filetype:&#x60; 前缀。支持 pdf、doc、docx、ppt、pptx、xls、xlsx、txt 等 | [optional]
**query** | **string** | 搜索查询关键词，支持中英文 |
**site** | **string** | 限制搜索特定网站，不需要 &#x60;site:&#x60; 前缀 | [optional]
**sort** | **string** | 排序方式 | [optional] [default to 'relevance']
**time_range** | **string** | 时间范围过滤 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
