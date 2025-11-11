# # GetStatusRatelimit200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**accepts** | **int** | Total number of accepted requests | [optional]
**in_flight** | **int** | Number of current in-flight requests | [optional]
**last_update** | **string** | Last update time of the status | [optional]
**limit** | **int** | Current concurrency limit | [optional]
**load** | **float** | Calculated system load (in_flight / limit) | [optional]
**min_rtt** | **float** | Minimum observed RTT in milliseconds | [optional]
**rejects** | **int** | Total number of rejected requests | [optional]
**rtt** | **float** | Smoothed RTT in milliseconds | [optional]
**throttled** | **int** | Total number of throttled requests | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
