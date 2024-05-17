<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Metrics;

use OpenTelemetry\API\Metrics\Noop\NoopMeter;
use OpenTelemetry\SDK\Metrics\NoopMeterProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopMeterProvider::class)]
class NoopMeterProviderTest extends TestCase
{
    public function test_force_flush(): void
    {
        $provider = new NoopMeterProvider();
        $this->assertTrue($provider->forceFlush());
    }

    public function test_shutdown(): void
    {
        $provider = new NoopMeterProvider();
        $this->assertTrue($provider->shutdown());
    }

    public function test_get_meter_returns_noop_meter(): void
    {
        $provider = new NoopMeterProvider();
        $this->assertInstanceOf(NoopMeter::class, $provider->getMeter('name'));
    }
}
