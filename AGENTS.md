# AGENTS.md — uapi-sdk-php

This file tells AI coding agents how to use the **official PHP SDK** for
the [uapis.cn](https://uapis.cn) public API platform.

## What this package is

Idiomatic PHP client for UAPI, targeting PHP 8.1+. Generated from the live
OpenAPI 3.1 spec at <https://uapis.cn/openapi.json>.

## Install

```bash
composer require axt-team/uapi-sdk-php
```

## Quick start

```php
<?php
require_once 'vendor/autoload.php';

use Uapi\UapiClient;
use Uapi\Models\GetMiscWeatherRequest;

$client = new UapiClient('https://uapis.cn');
$weather = $client->misc->getMiscWeather(new GetMiscWeatherRequest(city: '北京'));
print_r($weather);
```

The client is grouped by tag (`misc`, `network`, `text`, `image`, `social`,
`translate`, `search`, …). Method names match the OpenAPI `operationId`,
camelCased.

## Authentication

Free-tier endpoints work with no key. Paid endpoints take a key:

```php
$client = new UapiClient('https://uapis.cn', apiKey: 'sk_…');
```

## Errors

Methods throw `Uapi\Exceptions\UapiApiException` on non-2xx responses. The
exception carries `code`, `error`, and `requestId` properties. Surface
`error` verbatim.

## Rate limits

Headers `X-RateLimit-Limit`, `X-RateLimit-Remaining`, `X-RateLimit-Reset`,
`Retry-After` are exposed on responses. Honor them.

## Related repos

- MCP server: <https://github.com/AxT-Team/uapi-mcp>.
- Skills bundle: <https://github.com/AxT-Team/uapi-agent-skills>.
- Other languages: `uapi-sdk-typescript`, `uapi-sdk-python`, `uapi-sdk-go`,
  `uapi-sdk-rust`, `uapi-sdk-java`, `uapi-sdk-csharp`, `uapi-sdk-cpp`.
