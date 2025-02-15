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

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

/**
 * @method static string getMessage(array $translate = null)
 */
#[Constants]
enum ErrorCode: int
{
    use EnumConstantsTrait;

    #[Message("Server Error!")]
    case SERVER_ERROR = 500;

    #[Message("System parameter error")]
    case SYSTEM_INVALID = 700;
}
