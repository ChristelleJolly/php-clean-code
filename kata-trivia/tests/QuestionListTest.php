<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use Trivia\Category;
use Trivia\Question;
use Trivia\QuestionList;

class QuestionListTest extends TestCase
{
    public function test_should_only_accept_one_category()
    {
        $questionList = new QuestionList(Category::POP);

        $this->expectException(\InvalidArgumentException::class);
        $questionList->add(new Question(Category::ROCK, "Question Rock 1"));
    }
}