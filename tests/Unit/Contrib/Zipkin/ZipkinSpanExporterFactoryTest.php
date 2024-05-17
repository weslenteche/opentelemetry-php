<?php

declare(strict_types=1);

namespace Contrib\Zipkin;

use OpenTelemetry\Contrib\Zipkin\SpanExporterFactory;
use OpenTelemetry\SDK\Common\Configuration\Variables;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
use OpenTelemetry\Tests\TestState;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress UndefinedInterfaceMethod
 */
#[CoversClass(SpanExporterFactory::class)]
class ZipkinSpanExporterFactoryTest extends TestCase
{
    use TestState;

    protected function tearDown(): void
    {
        $this->restoreEnvironmentVariables();
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('configProvider')]
    public function test_create(array $env): void
    {
        foreach ($env as $k => $v) {
            $this->setEnvironmentVariable($k, $v);
        }

        $factory = new SpanExporterFactory();
        $this->assertInstanceOf(SpanExporterInterface::class, $factory->create());
    }

    public static function configProvider(): array
    {
        return [
            'defaults' => [
                'env' => [
                    Variables::OTEL_EXPORTER_ZIPKIN_ENDPOINT => 'http://localhost:9411/api/v2/spans',
                ],
            ],
        ];
    }
}
