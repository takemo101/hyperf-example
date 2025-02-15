<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Annotation\AsCommand;
use Hyperf\Command\Command as HyperfCommand;

#[AsCommand(signature: 'greet', description: 'Greet Hyperf')]
class GreetCommand extends HyperfCommand
{
    public function handle()
    {
        $this->line('Hello Hyperf!', 'info');
    }
}
