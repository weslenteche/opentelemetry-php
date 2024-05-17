<?php

declare(strict_types=1);

namespace API\Trace;

use OpenTelemetry\API\Trace\NoopTracer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopTracer::class)]
class NoopTracerTest extends TestCase
{
    public function test_get_instance(): void
    {
        $this->assertInstanceOf(NoopTracer::class, NoopTracer::getInstance());
    }
}
