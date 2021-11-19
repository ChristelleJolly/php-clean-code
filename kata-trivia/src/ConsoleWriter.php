<?php


namespace Trivia;


class ConsoleWriter implements Writer
{

    /**
     * ConsoleWriter constructor.
     */
    public function __construct()
    {
    }

    public function writeLine($string)
    {
        echo $string . "\n";
    }

    public function writeLines(...$strings)
    {
        foreach ($strings as $string)
            $this->writeLine($string);
    }
}