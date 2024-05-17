<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Trace;

use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\SDK\Trace\SamplerFactory;
use OpenTelemetry\SDK\Trace\SpanProcessor\NoopSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\TracerProviderBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TracerProviderBuilder::class)]
class TracerProviderBuilderTest extends TestCase
{
    public function test_build(): void
    {
        $provider = (new TracerProviderBuilder())
            ->addSpanProcessor(new NoopSpanProcessor())
            ->setResource(ResourceInfoFactory::emptyResource())
            ->setSampler((new SamplerFactory())->create())
            ->build();

        $this->assertInstanceOf(TracerProvider::class, $provider);
    }
}
