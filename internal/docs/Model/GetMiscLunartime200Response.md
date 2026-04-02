# # GetMiscLunartime200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**query_timestamp** | **string** | 原始 ts 入参。 | [optional]
**query_timezone** | **string** | 原始 timezone 入参。 | [optional]
**timezone** | **string** | 解析后的时区。 | [optional]
**datetime** | **string** | 本地化时间，格式 YYYY-MM-DD HH:mm:ss。 | [optional]
**datetime_rfc3339** | **string** | RFC3339 时间格式。 | [optional]
**timestamp_unix** | **int** | 秒级 Unix 时间戳。 | [optional]
**weekday** | **string** | 星期英文。 | [optional]
**weekday_cn** | **string** | 星期中文。 | [optional]
**lunar_year** | **int** | 农历年份（数字）。 | [optional]
**lunar_month** | **int** | 农历月份（数字）。 | [optional]
**lunar_day** | **int** | 农历日期（数字）。 | [optional]
**is_leap_month** | **bool** | 是否闰月。 | [optional]
**lunar_year_cn** | **string** | 农历年份中文表示。 | [optional]
**lunar_month_cn** | **string** | 农历月份中文表示。 | [optional]
**lunar_day_cn** | **string** | 农历日期中文表示。 | [optional]
**ganzhi_year** | **string** | 干支年。 | [optional]
**ganzhi_month** | **string** | 干支月。 | [optional]
**ganzhi_day** | **string** | 干支日。 | [optional]
**zodiac** | **string** | 生肖。 | [optional]
**solar_term** | **string** | 节气名称。有值时返回，无值时可能为空字符串或不返回。 | [optional]
**lunar_festivals** | **string[]** | 农历节日数组。 | [optional]
**solar_festivals** | **string[]** | 公历节日数组。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
