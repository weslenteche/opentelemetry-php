<?php

declare(strict_types=1);

namespace OpenTelemetry\API;

use function assert;
use Closure;
use const E_USER_WARNING;
use OpenTelemetry\API\Instrumentation\Configurator;
use OpenTelemetry\API\Instrumentation\ContextKeys;
use OpenTelemetry\API\Logs\EventLoggerProviderInterface;
use OpenTelemetry\API\Logs\LoggerProviderInterface;
use OpenTelemetry\API\Metrics\MeterProviderInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;
use function sprintf;
use Throwable;
use function trigger_error;

/**
 * Provides access to the globally configured instrumentation instances.
 */
final class Globals
{
    /** @var Closure[] */
    private static array $initializers = [];
    private static ?self $globals = null;

    public function __construct(
        private readonly TracerProviderInterface $tracerProvider,
        private readonly MeterProviderInterface $meterProvider,
        private readonly LoggerProviderInterface $loggerProvider,
        private readonly EventLoggerProviderInterface $eventLoggerProvider,
        private readonly TextMapPropagatorInterface $propagator,
    ) {
    }

    public static function tracerProvider(): TracerProviderInterface
    {
        return Context::getCurrent()->get(ContextKeys::tracerProvider()) ?? self::globals()->tracerProvider;
    }

    public static function meterProvider(): MeterProviderInterface
    {
        return Context::getCurrent()->get(ContextKeys::meterProvider()) ?? self::globals()->meterProvider;
    }

    public static function propagator(): TextMapPropagatorInterface
    {
        return Context::getCurrent()->get(ContextKeys::propagator()) ?? self::globals()->propagator;
    }

    public static function loggerProvider(): LoggerProviderInterface
    {
        return Context::getCurrent()->get(ContextKeys::loggerProvider()) ?? self::globals()->loggerProvider;
    }

    public static function eventLoggerProvider(): EventLoggerProviderInterface
    {
        return Context::getCurrent()->get(ContextKeys::eventLoggerProvider()) ?? self::globals()->eventLoggerProvider;
    }

    /**
     * @param Closure(Configurator): Configurator $initializer
     *
     * @internal
     * @psalm-internal OpenTelemetry
     */
    public static function registerInitializer(Closure $initializer): void
    {
        self::$initializers[] = $initializer;
    }

    /**
     * @phan-suppress PhanTypeMismatchReturnNullable
     */
    private static function globals(): self
    {
        if (self::$globals !== null) {
            return self::$globals;
        }

        $configurator = Configurator::createNoop();
        $scope = $configurator->activate();

        try {
            foreach (self::$initializers as $initializer) {
                try {
                    $configurator = $initializer($configurator);
                } catch (Throwable $e) {
                    trigger_error(sprintf("Error during opentelemetry initialization: %s\n%s", $e->getMessage(), $e->getTraceAsString()), E_USER_WARNING);
                }
            }
        } finally {
            $scope->detach();
        }

        $context = $configurator->storeInContext();
        $tracerProvider = $context->get(ContextKeys::tracerProvider());
        $meterProvider = $context->get(ContextKeys::meterProvider());
        $propagator = $context->get(ContextKeys::propagator());
        $loggerProvider = $context->get(ContextKeys::loggerProvider());
        $eventLoggerProvider = $context->get(ContextKeys::eventLoggerProvider());

        assert(isset($tracerProvider, $meterProvider, $loggerProvider, $eventLoggerProvider, $propagator));

        return self::$globals = new self($tracerProvider, $meterProvider, $loggerProvider, $eventLoggerProvider, $propagator);
    }

    /**
     * @internal
     */
    public static function reset(): void
    {
        self::$globals = null;
        self::$initializers = [];
    }
}
