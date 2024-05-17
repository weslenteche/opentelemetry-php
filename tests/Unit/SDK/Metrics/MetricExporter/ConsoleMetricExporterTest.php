<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Metrics\MetricExporter;

use OpenTelemetry\SDK\Metrics\MetricExporter\ConsoleMetricExporter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConsoleMetricExporter::class)]
class ConsoleMetricExporterTest extends TestCase
{
    public function test_shutdown(): void
    {
        $exporter = new ConsoleMetricExporter();
        $this->assertTrue($exporter->shutdown());
    }

    public function test_force_flush(): void
    {
        $exporter = new ConsoleMetricExporter();
        $this->assertTrue($exporter->forceFlush());
    }
}
