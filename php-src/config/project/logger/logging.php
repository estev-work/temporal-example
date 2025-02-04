<?php

return [
    'channels' => [
        \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum::DEFAULT->name => new \Modules\Shared\Infrastructure\Config\Values\Logger\LoggerChannel(
            fileName: 'default.log',
            format: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerFormatEnum::JSON,
            type: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerTypeEnum::FILE,
            levels: [
                \Psr\Log\LogLevel::ERROR,
                \Psr\Log\LogLevel::CRITICAL,
                \Psr\Log\LogLevel::WARNING,
                \Psr\Log\LogLevel::INFO,
                \Psr\Log\LogLevel::DEBUG,
                \Psr\Log\LogLevel::EMERGENCY,
                \Psr\Log\LogLevel::ALERT,
                \Psr\Log\LogLevel::NOTICE,
            ],
            enabled: true,
            period: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerPeriodEnum::DAILY,
            days: 14,
        ),
        \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum::WORKFLOW->name => new \Modules\Shared\Infrastructure\Config\Values\Logger\LoggerChannel(
            fileName: 'workflow.log',
            format: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerFormatEnum::JSON,
            type: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerTypeEnum::FILE,
            levels: [
                \Psr\Log\LogLevel::ERROR,
                \Psr\Log\LogLevel::CRITICAL,
                \Psr\Log\LogLevel::WARNING,
                \Psr\Log\LogLevel::INFO,
                \Psr\Log\LogLevel::DEBUG,
                \Psr\Log\LogLevel::EMERGENCY,
                \Psr\Log\LogLevel::ALERT,
                \Psr\Log\LogLevel::NOTICE,
            ],
            enabled: true,
            period: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerPeriodEnum::DAILY,
            days: 14,
        ),
        \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerChannelEnum::ACTIVITY->name => new \Modules\Shared\Infrastructure\Config\Values\Logger\LoggerChannel(
            fileName: 'activity.log',
            format: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerFormatEnum::JSON,
            type: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerTypeEnum::FILE,
            levels: [
                \Psr\Log\LogLevel::ERROR,
                \Psr\Log\LogLevel::CRITICAL,
                \Psr\Log\LogLevel::WARNING,
                \Psr\Log\LogLevel::INFO,
                \Psr\Log\LogLevel::DEBUG,
                \Psr\Log\LogLevel::EMERGENCY,
                \Psr\Log\LogLevel::ALERT,
                \Psr\Log\LogLevel::NOTICE,
            ],
            enabled: true,
            period: \Modules\Shared\Application\Config\Values\Logger\Enums\LoggerPeriodEnum::DAILY,
            days: 14,
        ),
    ],
];
