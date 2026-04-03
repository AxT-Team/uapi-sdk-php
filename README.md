# uapi-sdk-php

![Banner](https://raw.githubusercontent.com/AxT-Team/uapi-sdk-php/main/banner.png)

[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Docs](https://img.shields.io/badge/Docs-uapis.cn-2EAE5D?style=flat-square)](https://uapis.cn/)

> [!NOTE]
> 所有接口的 PHP 示例都可以在 [UApi](https://uapis.cn/docs/introduction) 的接口文档页面，向下滚动至 **快速启动** 区块后直接复制。

## 快速开始

```bash
composer require AxT-Team/uapi-sdk-php
```

```php
<?php
require 'vendor/autoload.php';

$client = new Uapi\Client('https://uapis.cn', 'YOUR_API_KEY');
$result = $client->misc()->getMiscHotboard(['type' => 'weibo']);
var_dump($result);
```

这个接口默认只要传 `type` 就可以拿当前热榜。`time`、`keyword`、`time_start`、`time_end`、`limit`、`sources` 都是按场景再传的可选参数。

## 特性

现在你不再需要反反复复的查阅文档了。

只需在 IDE 中键入 `$client->`，所有核心模块——如 `social()`、`game()`、`image()`——即刻同步展现。进一步输入即可直接定位到 `getSocialQqUserinfo` 这样的具体方法，其名称与文档的 `operationId` 严格保持一致，确保了开发过程的直观与高效。

所有方法签名只接受真实且必需的参数。当你在构建请求时，IDE 会即时提示 `qq`、`username` 等键名，这彻底杜绝了在关联数组中因键名拼写错误而导致的运行时错误。

针对 401、404、429 等标准 HTTP 响应，SDK 已将其统一映射为具名的异常类型。这些异常均附带 `code`、`status`、`details` 等关键上下文信息，确保你在日志中能第一时间准确、快速地诊断问题。

HTTP 层基于 Guzzle，构造函数会自动设置 Base URL、追加 `Authorization` 头并关闭 `http_errors`，方便你直接读取 JSON/字节响应；需要更细致的超时或代理策略时，可以按需扩展这段初始化逻辑。

如果你需要查看字段细节或内部逻辑，仓库中的 `./internal` 目录同步保留了由 `openapi-generator` 生成的完整结构体，随时可供参考。

## 响应元信息

每次请求完成后，SDK 会自动把响应 Header 解析成结构化的 `ResponseMeta`，你不用自己拆原始字符串。

成功时可以通过 `$client->lastResponseMeta` 读取，失败时可以通过 `$e->meta` 读取，两条路径拿到的是同一套字段。

```php
<?php
require 'vendor/autoload.php';

use Uapi\Client;
use Uapi\UapiError;

$client = new Client('https://uapis.cn', 'YOUR_API_KEY');

// 成功路径
$result = $client->social()->getSocialQqUserinfo(['qq' => '10001']);
$meta = $client->lastResponseMeta;
if ($meta) {
    echo '余额剩余: ' . ($meta->balanceRemainingCents ?? 0) . " 分\n";
    echo '资源包剩余: ' . ($meta->quotaRemainingCredits ?? 0) . " 积分\n";
    echo 'Request ID: ' . ($meta->requestId ?? '-') . "\n";
}

// 失败路径
try {
    $client->social()->getSocialQqUserinfo(['qq' => '10001']);
} catch (UapiError $e) {
    if ($e->meta) {
        echo '限流，' . ($e->meta->retryAfterSeconds ?? 0) . "s 后重试\n";
        echo 'Request ID: ' . ($e->meta->requestId ?? '-') . "\n";
    }
}
```

常用字段一览：

| 字段 | 说明 |
|------|------|
| `balanceRemainingCents` | 账户余额剩余（分） |
| `quotaRemainingCredits` | 资源包剩余积分 |
| `visitorQuotaRemainingCredits` | 访客配额剩余积分 |
| `retryAfterSeconds` | 触发限流后的建议等待时长 |
| `requestId` | 请求唯一 ID，排障时使用 |
| `debitStatus` | 本次计费状态 |
| `rateLimitPolicies` / `rateLimits` | 完整结构化限流策略数据 |

## 错误模型概览

| HTTP 状态码 | SDK 错误类型                                  | 附加信息                                                                          |
|-------------|----------------------------------------------|------------------------------------------------------------------------------------|
| 401/403     | `UnauthorizedError`                          | `code`、`status`                                                                   |
| 404         | `NotFoundError` / `NoMatchError`             | `code`、`status`                                                                   |
| 400         | `InvalidParameterError` / `InvalidParamsError` | `code`、`status`、`details`                                                        |
| 429         | `ServiceBusyError`                           | `code`、`status`、`retry_after_seconds`                                            |
| 5xx         | `InternalServerErrorError` / `ApiErrorError` | `code`、`status`、`details`                                                        |
| 其他 4xx    | `UapiError`                                  | `code`、`status`、`details`                                                        |

## 其他 SDK

| 语言        | 仓库地址                                                     |
|-------------|--------------------------------------------------------------|
| Go          | https://github.com/AxT-Team/uapi-sdk-go                      |
| Python      | https://github.com/AxT-Team/uapi-sdk-python                  |
| TypeScript| https://github.com/AxT-Team/uapi-sdk-typescript           |
| Browser (TypeScript/JavaScript)| https://github.com/AxT-Team/uapi-browser-sdk        |
| Java        | https://github.com/AxT-Team/uapi-sdk-java                    |
| PHP（当前）         | https://github.com/AxT-Team/uapi-sdk-php                     |
| C#          | https://github.com/AxT-Team/uapi-sdk-csharp                  |
| C++         | https://github.com/AxT-Team/uapi-sdk-cpp                     |
| Rust        | https://github.com/AxT-Team/uapi-sdk-rust                    |

## 文档

访问 [UApi文档首页](https://uapis.cn/docs/introduction) 并选择任意接口，向下滚动到 **快速启动** 区块即可看到最新的 PHP 示例代码。


