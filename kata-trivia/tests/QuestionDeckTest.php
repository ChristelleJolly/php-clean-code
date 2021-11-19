<?php


namespace Tests;


use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Trivia\Category;
use Trivia\Question;
use Trivia\QuestionDeck;

class QuestionDeckTest extends TestCase
{
    public function test_should_retrieve_first_question_by_its_category_when_only_one_category_exists()
    {
        $deck = new QuestionDeck(new Question(Category::POP, "Question Pop 1"),
            new Question(Category::POP, "Question Pop 2"));

        $question = $deck->current(Category::POP);

        Assert::assertEquals("Question Pop 1", $question->label());
    }

    public function test_should_retrieve_second_question_by_its_category_when_only_one_category_exists()
    {
        $deck = new QuestionDeck(new Question(Category::POP, "Question Pop 1"),
            new Question(Category::POP, "Question Pop 2"));

        $deck->next(Category::POP);
        $question = $deck->current(Category::POP);

        Assert::assertEquals("Question Pop 2", $question->label());
    }

    public function test_should_throw_when_retrieving_third_question_from_2_questions_deck()
    {
        $deck = new QuestionDeck(new Question(Category::POP, "Question Pop 1"),
            new Question(Category::POP, "Question Pop 2"));

        $deck->next(Category::POP);
        $deck->next(Category::POP);

        $this->expectException(\OutOfBoundsException::class);
        $question = $deck->current(Category::POP);
    }

    public function test_should_retrieve_first_question_by_its_category_when_multiple_category_exists()
    {
        $deck = new QuestionDeck(new Question(Category::POP, "Question Pop 1"),
            new Question(Category::POP, "Question Pop 2"),
            new Question(Category::ROCK, "Question Rock 1"),
            new Question(Category::SCIENCE, "Question Science 1")
        );

        $question = $deck->current(Category::ROCK);

        Assert::assertEquals("Question Rock 1", $question->label());
    }
}