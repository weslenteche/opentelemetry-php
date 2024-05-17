<?php

declare(strict_types=1);

namespace API\Metrics;

use OpenTelemetry\API\Metrics\Noop\NoopMeter;
use OpenTelemetry\API\Metrics\Noop\NoopMeterProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopMeterProvider::class)]
class NoopMeterProviderTest extends TestCase
{
    public function test_provides_meter(): void
    {
        $meter = (new NoopMeterProvider())->getMeter('meter');
        $this->assertInstanceOf(NoopMeter::class, $meter);
    }
}
