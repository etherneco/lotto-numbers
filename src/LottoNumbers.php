<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use UnderflowException;

final class LottoNumbers
{
    /** @var int[] */
    private $numbers;

    public function __construct(int $from, int $to)
    {
        if ($from > $to) {
            throw new InvalidArgumentException('The lower bound must be <= the upper bound.');
        }

        $this->numbers = range($from, $to);
    }

    public function shuffleArray(): void
    {
        shuffle($this->numbers);
    }

    public function getNumber(): int
    {
        if ($this->numbers === []) {
            throw new UnderflowException('No numbers left to draw.');
        }

        $position = random_int(0, count($this->numbers) - 1);
        $ret = $this->numbers[$position];
        array_splice($this->numbers, $position, 1);

        return $ret;
    }
}

