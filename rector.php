<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\CodeQuality\Rector as CodeQuality;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\MethodCall\RemoveNullArgOnNullDefaultParamRector;
use Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Php84\Rector\Class_\DeprecatedAnnotationToDeprecatedAttributeRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayAllRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayAnyRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/library',
        __DIR__ . '/tests',
        __DIR__ . '/demos',
    ])
    ->withRules([
        CodeQuality\Class_\CompleteDynamicPropertiesRector::class,
    ])
    ->withSkip([
        // see https://github.com/Shardj/zf1-future/pull/453
        CodeQuality\Class_\CompleteDynamicPropertiesRector::class => [
            __DIR__ . '/library/Zend/Pdf/Element.php',
        ],

        __DIR__ . '/tests/Zend/Loader/_files/ParseError.php',
        __DIR__ . '/tests/Zend/Session/SessionTest.php',
        __DIR__ . '/tests/Zend/Db/Select/StaticTest.php',
        __DIR__ . '/tests/Zend/OpenId/ConsumerTest.php',

        //Mucho ruido
        AddOverrideAttributeToOverriddenMethodsRector::class,
        AddTypeToConstRector::class,
        DeprecatedAnnotationToDeprecatedAttributeRector::class,
        ForeachToArrayAllRector::class,
        ForeachToArrayAnyRector::class,
        NewMethodCallWithoutParenthesesRector::class,
    ])
    ->withConfiguredRule(RenameMethodRector::class, [
        new MethodCallRename('Zend_Acl', 'add', 'addResource'),
    ])
    ->withSets([
        SetList::PHP_82,
        SetList::PHP_83,
        SetList::PHP_84,
    ])
    ->withPreparedSets(
        deadCode: false,  //PPP primera pasada más estrictamente orientada a compatibilidad,
        codeQuality: false,  //PPP bajar agresividad de los cambios
        typeDeclarations: false
    )
    ->withPhpVersion(PhpVersion::PHP_84);
