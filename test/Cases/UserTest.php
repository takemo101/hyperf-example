<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use App\Model\User;
use Hyperf\Database\Commands\Migrations\RefreshCommand;
use Hyperf\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

use function Hyperf\Collection\collect;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /** @var RefreshCommand */
        $command = $this->container->get(RefreshCommand::class);

        $command->run(
            input: new ArrayInput([]),
            output: new NullOutput(),
        );
    }

    #[Test]
    public function User一覧()
    {
        $users = collect(['test1', 'test2', 'test3'])
            ->map(
                fn(string $name) => User::create(
                    [
                        'name' => $name,
                        'email' => "{$name}+index@index.com",
                    ],
                ),
            );

        $this->get('/user')
            ->assertStatus(200)
            ->assertJson($users->toArray());
    }

    #[Test]
    public function User作成()
    {
        $data = [
            'name' => 'create',
            'email' => 'create@test.com',
        ];

        $this->post('/user', $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    #[Test]
    public function User更新()
    {
        $user = User::create(
            [
                'name' => 'update',
                'email' => 'update@test.com',
            ],
        );

        $data = [
            'name' => 'updated',
        ];

        $this->put("/user/{$user->id}", $data)
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                ...$data
            ]);
    }

    #[Test]
    public function User詳細()
    {
        $user = User::create(
            [
                'name' => 'show',
                'email' => 'show@test.com',
            ],
        );

        $this->get("/user/{$user->id}")
            ->assertStatus(200)
            ->assertJson($user->toArray());
    }

    #[Test]
    public function User削除()
    {
        $user = User::create(
            [
                'name' => 'delete',
                'email' => 'delete@test.com',
            ],
        );

        $this->delete("/user/{$user->id}")
            ->assertStatus(200)
            ->assertJson($user->toArray());

        $deletedUser = User::find($user->id);

        $this->assertNull($deletedUser);
    }
}
