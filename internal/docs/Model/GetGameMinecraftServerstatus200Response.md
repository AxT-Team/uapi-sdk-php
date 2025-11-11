# # GetGameMinecraftServerstatus200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**code** | **int** | 状态码，200代表成功。 | [optional]
**favicon_url** | **string** | 服务器图标的 Base64 Data URI。你可以直接在 &#x60;&lt;img&gt;&#x60; 标签的 &#x60;src&#x60; 属性中使用它。 | [optional]
**ip** | **string** | 服务器解析后的IP地址。 | [optional]
**max_players** | **int** | 服务器配置的最大玩家容量。 | [optional]
**motd_clean** | **string** | 纯文本格式的服务器MOTD（每日消息），去除了所有颜色和格式代码。 | [optional]
**motd_html** | **string** | HTML格式的服务器MOTD，保留了颜色和样式，方便你在网页上直接渲染。 | [optional]
**online** | **bool** | 服务器当前是否在线。 | [optional]
**players** | **int** | 当前在线的玩家数量。 | [optional]
**port** | **int** | 服务器使用的端口。 | [optional]
**version** | **string** | 服务器报告的版本信息。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
