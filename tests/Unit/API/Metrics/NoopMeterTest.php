<?php

declare(strict_types=1);

namespace API\Metrics;

use OpenTelemetry\API\Metrics\Noop\NoopCounter;
use OpenTelemetry\API\Metrics\Noop\NoopHistogram;
use OpenTelemetry\API\Metrics\Noop\NoopMeter;
use OpenTelemetry\API\Metrics\Noop\NoopObservableCounter;
use OpenTelemetry\API\Metrics\Noop\NoopObservableGauge;
use OpenTelemetry\API\Metrics\Noop\NoopObservableUpDownCounter;
use OpenTelemetry\API\Metrics\Noop\NoopUpDownCounter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopMeter::class)]
class NoopMeterTest extends TestCase
{
    protected NoopMeter $meter;

    protected function setUp(): void
    {
        $this->meter = new NoopMeter();
        parent::setUp();
    }

    public function test_create_counter(): void
    {
        $counter = $this->meter->createCounter('name');
        $this->assertInstanceOf(NoopCounter::class, $counter);
    }

    public function test_create_observable_counter(): void
    {
        $counter = $this->meter->createObservableCounter('name');
        $this->assertInstanceOf(NoopObservableCounter::class, $counter);
    }

    public function test_create_histogram(): void
    {
        $histogram = $this->meter->createHistogram('name');
        $this->assertInstanceOf(NoopHistogram::class, $histogram);
    }

    public function test_create_observable_gauge(): void
    {
        $gauge = $this->meter->createObservableGauge('name');
        $this->assertInstanceOf(NoopObservableGauge::class, $gauge);
    }

    public function test_create_up_down_counter(): void
    {
        $counter = $this->meter->createUpDownCounter('name');
        $this->assertInstanceOf(NoopUpDownCounter::class, $counter);
    }

    public function test_create_observable_up_down_counter(): void
    {
        $counter = $this->meter->createObservableUpDownCounter('name');
        $this->assertInstanceOf(NoopObservableUpDownCounter::class, $counter);
    }
}
