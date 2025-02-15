<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use Hyperf\Codec\Json;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(
        private StdoutLoggerInterface $logger,
        private Json $jsonCodec,
    ) {
        //
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $message = sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile());
        $this->logger->error($message);
        $this->logger->error($throwable->getTraceAsString());
        $responseWithHeader = $response
            ->withHeader('Server', 'Hyperf')
            ->withHeader('Content-Type', 'application/json');

        if ($throwable instanceof ModelNotFoundException) {
            return $responseWithHeader
                ->withStatus(404)
                ->withBody(new SwooleStream(
                    $this->jsonCodec->encode([
                        'message' => 'Resource not found.',
                    ]),
                ));
        }

        return $responseWithHeader
            ->withStatus(500)
            ->withBody(new SwooleStream(
                $this->jsonCodec->encode([
                    'message' => $message,
                    'trace' => $throwable->getTraceAsString(),
                ]),
            ));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
