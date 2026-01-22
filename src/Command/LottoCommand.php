<?php

declare(strict_types=1);

namespace App\Command;

use App\LottoNumbers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class LottoCommand extends Command
{
    protected static $defaultName = 'lotto:numbers';
    private const DRAW_COUNT = 6;

    protected function configure(): void
    {
        $this
            ->setDescription('Random lotto numbers')
            ->addOption(
                'loNum',
                null,
                InputOption::VALUE_REQUIRED,
                'This is the first and lowest number you can play in the lottery.',
                1
            )
            ->addOption(
                'hiNum',
                null,
                InputOption::VALUE_REQUIRED,
                'This is the last and highest number you can play in the lottery.',
                59
            )
            ->addOption(
                'initShuffle',
                null,
                InputOption::VALUE_REQUIRED,
                'Numbers should be shuffled / randomized for this amount of time (seconds) before the first number is selected.',
                0
            )
            ->addOption(
                'shuffle',
                null,
                InputOption::VALUE_REQUIRED,
                'This is the number of seconds remaining balls should be shuffled for before the next number is selected.',
                0
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loNum = (int) $input->getOption('loNum');
        $hiNum = (int) $input->getOption('hiNum');
        $initShuffle = (int) $input->getOption('initShuffle');
        $shuffle = (int) $input->getOption('shuffle');

        if ($loNum >= $hiNum) {
            $output->writeln('<error>loNum must be lower than hiNum.</error>');
            return Command::INVALID;
        }

        if (self::DRAW_COUNT > ($hiNum - $loNum + 1)) {
            $output->writeln('<error>Not enough unique numbers in the selected range.</error>');
            return Command::INVALID;
        }

        $lottoNumber = new LottoNumbers($loNum, $hiNum);

        $this->shuffleForSeconds($lottoNumber, $initShuffle);

        $result = [];
        for ($i = 0; $i < self::DRAW_COUNT; $i++) {
            $result[] = $lottoNumber->getNumber();
            $this->shuffleForSeconds($lottoNumber, $shuffle);
        }

        $output->writeln(implode(',', $result));

        return Command::SUCCESS;
    }

    private function shuffleForSeconds(LottoNumbers $lottoNumber, int $seconds): void
    {
        if ($seconds <= 0) {
            return;
        }

        $timeStop = microtime(true) + $seconds;
        do {
            $lottoNumber->shuffleArray();
            usleep(1000);
        } while (microtime(true) < $timeStop);
    }
}
