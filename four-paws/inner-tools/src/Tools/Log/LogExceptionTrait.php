<?php

namespace FourPaws\Innertools\Tools\Log;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Throwable;

trait LogExceptionTrait
{
    use LoggerAwareTrait;

    /**
     * Логирует любое исключение вместе со стеком вызовов.
     *
     * @param Throwable $exception Логируемое исключение.
     * @param string $logLevel Уровень сообщения в логе.
     */
    protected function logException(Throwable $exception, string $logLevel = LogLevel::ERROR)
    {
        $this->logger->log(
            $logLevel,
            sprintf(
                "[%s] %s (%s)",
                get_class($exception),
                $exception->getMessage(),
                $exception->getCode()
            ),
            [
                'trace' => $exception->getTraceAsString(),
            ]
        );
    }
}
