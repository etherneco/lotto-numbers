<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class ListCommandTest extends KernelTestCase
{
    public function testResult(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('lotto:numbers');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([
            'command' => $command->getName(),
            '--loNum' => 1,
            '--hiNum' => 40,
            '--initShuffle' => 0,
            '--shuffle' => 0,
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);

        $output = trim($commandTester->getDisplay());
        $list = $output === '' ? [] : explode(',', $output);

        $this->assertCount(6, $list);

        $unique = [];
        foreach ($list as $elem) {
            $this->assertIsNumeric($elem);
            $number = (int) $elem;
            $this->assertGreaterThanOrEqual(1, $number);
            $this->assertLessThanOrEqual(40, $number);
            $unique[$number] = true;
        }

        $this->assertCount(6, $unique);
    }

    public function testWait(): void
    {
        $start = microtime(true);

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('lotto:numbers');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute([
            'command' => $command->getName(),
            '--loNum' => 1,
            '--hiNum' => 40,
            '--initShuffle' => 1,
            '--shuffle' => 1,
        ]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertGreaterThanOrEqual(6, microtime(true) - $start);
    }
}
