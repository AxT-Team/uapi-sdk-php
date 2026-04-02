# # GetMiscHolidayCalendar200ResponseDaysInner

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**date** | **string** | 公历日期（YYYY-MM-DD）。 | [optional]
**year** | **int** | 公历年份。 | [optional]
**month** | **int** | 公历月份。 | [optional]
**day** | **int** | 公历日期（天）。 | [optional]
**weekday_cn** | **string** | 中文星期，如星期三。 | [optional]
**is_weekend** | **bool** | 是否为周末。 | [optional]
**is_workday** | **bool** | 是否为工作日（含法定调休上班日）。 | [optional]
**is_rest_day** | **bool** | 是否为休息日。 | [optional]
**is_holiday** | **bool** | 当天是否存在节日、节气或法定事件。 | [optional]
**legal_holiday_name** | **string** | 法定节假日名称，无则为空或不返回。 | [optional]
**legal_holiday_type** | **string** | 法定假日类型：rest 或 workday_adjust。 | [optional]
**solar_festival** | **string** | 公历节日名称。有值时返回。 | [optional]
**lunar_festival** | **string** | 农历节日名称。有值时返回。 | [optional]
**solar_term** | **string** | 节气名称。有值时返回。 | [optional]
**lunar_year** | **int** | 农历年份（数字）。 | [optional]
**lunar_month** | **int** | 农历月份（数字）。 | [optional]
**lunar_day** | **int** | 农历日期（数字）。 | [optional]
**lunar_month_name** | **string** | 农历月份中文名称。 | [optional]
**lunar_day_name** | **string** | 农历日期中文名称。 | [optional]
**ganzhi_year** | **string** | 干支年。 | [optional]
**ganzhi_month** | **string** | 干支月。 | [optional]
**ganzhi_day** | **string** | 干支日。 | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
