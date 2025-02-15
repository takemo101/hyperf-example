<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\Codec\Json;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Swow\Psr7\Message\ResponsePlusInterface;
use Throwable;

class AppValidationExceptionHandler extends ExceptionHandler
{
    public function __construct(
        private Json $jsonCodec,
    ) {
        //
    }
    public function handle(Throwable $throwable, ResponsePlusInterface $response)
    {
        $this->stopPropagation();

        if (!($throwable instanceof ValidationException)) {
            return $response;
        }

        $errors = $throwable->validator->errors();

        return $response->setStatus($throwable->status)->setBody(new SwooleStream(
            $this->jsonCodec->encode([
                'errors' => $errors->getMessages(),
            ]),
        ));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
