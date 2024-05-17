<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Trace;

use OpenTelemetry\SDK\Trace\NoopTracerProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoopTracerProvider::class)]
class NoopTracerProviderTest extends TestCase
{
    public function test_force_flush(): void
    {
        $provider = new NoopTracerProvider();
        $this->assertTrue($provider->forceFlush());
    }

    public function test_shutdown(): void
    {
        $provider = new NoopTracerProvider();
        $this->assertTrue($provider->shutdown());
    }
}
