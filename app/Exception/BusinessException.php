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

namespace App\Exception;

use App\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    public function __construct(ErrorCode|int $code = 0, ?string $message = null, ?Throwable $previous = null)
    {
        // If the $code is an instance of ErrorCode, then use the message of the ErrorCode.
        if (is_null($message)) {
            $message = $code instanceof ErrorCode
                ? $code->getMessage()
                : ErrorCode::getMessage($code);
        }

        // If the $code is an instance of ErrorCode, then use the value of the ErrorCode.
        $code = $code instanceof ErrorCode ? $code->value : $code;

        parent::__construct($message, $code, $previous);
    }
}
