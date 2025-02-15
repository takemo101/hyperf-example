<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\Request\CreateUserRequest;
use App\Request\UpdateUserRequest;
use App\Service\AlreadyUserExistsException;
use App\Service\CreateUserInput;
use App\Service\CreateUserService;
use Hyperf\Collection\Collection;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller]
class UserController
{
    /**
     * @return Collection<integer,User>
     */
    #[RequestMapping(path: "/user", methods: ["get"])]
    public function index(): Collection
    {
        $users = User::get();

        return $users;
    }

    /**
     * @param RequestInterface $request
     * @return User
     */
    // #[RequestMapping(path: "/user", methods: ["post"])]
    public function create(RequestInterface $request): User
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return $user;
    }

    /**
     * @param CreateUserService $service
     * @param CreateUserRequest $request
     * @return User
     */
    #[RequestMapping(path: "/user", methods: ["post"])]
    public function createUseFormRequest(CreateUserService $service, CreateUserRequest $request): User
    {
        try {
            $user = $service->execute(
                new CreateUserInput(
                    name: $request->input('name'),
                    email: $request->input('email'),
                ),
            );
        } catch (AlreadyUserExistsException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $user;
    }

    /**
     * @param RequestInterface $request
     * @param string $id
     * @return User
     * @throws ModelNotFoundException
     */
    // #[RequestMapping(path: "/user/{id}", methods: ["put"])]
    public function update(
        RequestInterface $request,
        string $id,
    ): User {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->save();

        return $user;
    }

    /**
     * @param UpdateUserRequest $request
     * @param string $id
     * @return User
     * @throws ModelNotFoundException
     */
    #[RequestMapping(path: "/user/{id}", methods: ["put"])]
    public function updateUseFormRequest(
        UpdateUserRequest $request,
        string $id,
    ): User {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->save();

        return $user;
    }


    /**
     * @param string $id
     * @return User
     * @throws ModelNotFoundException
     */
    #[RequestMapping(path: "/user/{id}", methods: ["get"])]
    public function show(string $id): User
    {
        $user = User::findOrFail($id);

        return $user;
    }

    /**
     * @param string $id
     * @return User
     * @throws ModelNotFoundException
     */
    #[RequestMapping(path: "/user/{id}", methods: ["delete"])]
    public function destroy(string $id): User
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $user;
    }
}
