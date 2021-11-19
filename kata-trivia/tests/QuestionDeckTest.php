<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Category;
use Trivia\Question;
use Trivia\QuestionDeck;

class QuestionDeckTest extends TestCase
{
    public function test_should_retrieve_next_question_by_its_category_when_only_one_category_exists()
    {
        $deck = new QuestionDeck(new Question(Category::POP, "Question Pop 1"),
            new Question(Category::POP, "Question Pop 2"));

        $question = $deck->current(Category::POP);

        Assert::assertEquals("Question Pop 1", $question->label());
    }
}