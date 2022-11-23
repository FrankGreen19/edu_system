<?php

namespace App\Entity;

use App\Repository\UserQuestionAnswersRepository;
use App\Resource\ResourceInterface;
use App\Resource\UserQuestionAnswerResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'user_question_answers')]
#[ORM\Entity(repositoryClass: UserQuestionAnswersRepository::class)]
class UserQuestionAnswer implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userQuestionAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserTest $userTest = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?question $question = null;

    #[ORM\Column(length: 100)]
    private ?string $answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserTest(): ?UserTest
    {
        return $this->userTest;
    }

    public function setUserTest(?UserTest $userTest): self
    {
        $this->userTest = $userTest;

        return $this;
    }

    public function getQuestion(): ?question
    {
        return $this->question;
    }

    public function setQuestion(?question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function toResource(): ResourceInterface
    {
        return new UserQuestionAnswerResource(
            $this->userTest->getId(),
            $this->question->getId(),
            $this->answer
        );
    }
}
