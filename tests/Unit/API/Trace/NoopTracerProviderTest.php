<?php

declare(strict_types=1);

namespace API\Trace;

use OpenTelemetry\API\Trace\NoopTracer;
use OpenTelemetry\API\Trace\NoopTracerProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopTracerProvider::class)]
class NoopTracerProviderTest extends TestCase
{
    public function test_provides_tracer(): void
    {
        $tracer = (new NoopTracerProvider())->getTracer('tracer');
        $this->assertInstanceOf(NoopTracer::class, $tracer);
    }
}
