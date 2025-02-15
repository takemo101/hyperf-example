<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;

class IndexController
{
    public static int $count = 0;

    /**
     * @param RequestInterface $request
     * @return array<string,mixed>
     */
    public function index(RequestInterface $request): array
    {
        $method = $request->getMethod();

        $count = ++self::$count;

        return [
            'method' => $method,
            'message' => "Count: {$count}",
        ];
    }
}
