<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withPhpSets(php84: true)
    ->withSkip([
        // We are expecting fully qualified class names with a leading
        // backslash. Contrary to the official PHP documentation, names provided
        // by the ::class constant are not prefixed with a backslash:
        // https://github.com/php/doc-en/issues/2138
        StringClassNameToClassConstantRector::class,

        ThisCallOnStaticMethodToStaticCallRector::class,
    ]);
