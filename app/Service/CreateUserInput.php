<?php

declare(strict_types=1);

namespace App\Service;

readonly class CreateUserInput
{
    /**
     * @param string $name
     * @param string $email
     */
    public function __construct(
        public string $name,
        public string $email,
    ) {
        //
    }
}
