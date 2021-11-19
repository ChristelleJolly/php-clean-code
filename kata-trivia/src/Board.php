<?php


namespace Trivia;


class Board
{
    /**
     * @var int
     */
    private $size;
    /**
     * @var array
     */
    private $categories;

    /**
     * Board constructor.
     * @param int $size
     * @param array $categories
     */
    public function __construct(int $size, array $categories)
    {
        $this->size = $size;
        $this->categories = $categories;
    }

    public function getCategory(int $position): string
    {
        return $this->categories[$position % count($this->categories)];
    }

    public function nextPosition(int $start, int $roll): int
    {
        return $start + $roll;
    }
}