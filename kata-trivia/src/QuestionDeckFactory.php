<?php


namespace Trivia;


class QuestionDeckFactory
{

    public static function build(int $countByCategory): QuestionDeck
    {
        $questions = [];

        for ($i = 0; $i < $countByCategory; $i++) {
            $questions = array_merge($questions, [
                new Question(Category::POP, "Pop Question " . $i),
                new Question(Category::SCIENCE, "Science Question " . $i),
                new Question(Category::SPORTS, "Sports Question " . $i),
                new Question(Category::ROCK, "Rock Question " . $i),
            ]);
        }

        return new QuestionDeck(...$questions);
    }
}