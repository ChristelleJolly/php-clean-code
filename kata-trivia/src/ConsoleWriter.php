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
}