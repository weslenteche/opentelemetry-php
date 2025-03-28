<?php

declare(strict_types=1);

namespace ExampleSDK\ComponentProvider\Logs;

use BadMethodCallException;
use ExampleSDK\Logs\LogRecordExporter;
use OpenTelemetry\Config\SDK\Configuration\ComponentProvider;
use OpenTelemetry\Config\SDK\Configuration\ComponentProviderRegistry;
use OpenTelemetry\Config\SDK\Configuration\Context;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

final class LogRecordExporterConsole implements ComponentProvider
{
    /**
     * @param array{} $properties
     */
    public function createPlugin(array $properties, Context $context): LogRecordExporter
    {
        throw new BadMethodCallException('not implemented');
    }

    public function getConfig(ComponentProviderRegistry $registry, NodeBuilder $builder): ArrayNodeDefinition
    {
        return $builder->arrayNode('console');
    }
}
