<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Metrics;

use OpenTelemetry\SDK\Metrics\Exemplar\ExemplarFilter\NoneExemplarFilter;
use OpenTelemetry\SDK\Metrics\MeterProvider;
use OpenTelemetry\SDK\Metrics\MeterProviderBuilder;
use OpenTelemetry\SDK\Metrics\MetricExporter\NoopMetricExporter;
use OpenTelemetry\SDK\Metrics\MetricReader\ExportingReader;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MeterProviderBuilder::class)]
class MeterProviderBuilderTest extends TestCase
{
    public function test_build(): void
    {
        $exporter = new NoopMetricExporter();
        $reader = new ExportingReader($exporter);
        $provider = (new MeterProviderBuilder())
            ->addReader($reader)
            ->setResource(ResourceInfoFactory::emptyResource())
            ->setExemplarFilter(new NoneExemplarFilter())
            ->build();

        $this->assertInstanceOf(MeterProvider::class, $provider);
    }
}
