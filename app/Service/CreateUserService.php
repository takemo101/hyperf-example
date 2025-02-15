<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\User;
use InvalidArgumentException;
use Hyperf\Database\Exception\InvalidBindingException;

class CreateUserService
{
    /**
     * Create a new user.
     *
     * @param CreateUserInput $input
     * @return User
     * @throws InvalidArgumentException
     * @throws InvalidBindingException
     * @throws AlreadyUserExistsException
     */
    public function execute(CreateUserInput $input): User
    {
        // email is unique
        if (
            User::query()->where(
                'email',
                $input->email
            )->exists()
        ) {
            throw new AlreadyUserExistsException();
        }

        $user = User::create([
            'name' => $input->name,
            'email' => $input->email,
        ]);

        return $user;
    }
}
