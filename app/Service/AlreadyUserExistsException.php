<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class AlreadyUserExistsException extends Exception
{
    /**
     * @param string $message
     * @return void
     */
    public function __construct(
        string $message = 'Email already exists',
    ) {
        parent::__construct($message);
    }
}
