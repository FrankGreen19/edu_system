<?php

namespace App\Entity;

use App\Repository\TestQuestionRepository;
use App\Resource\ResourceInterface;
use App\Resource\TestQuestionResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'test_questions')]
#[ORM\Entity(repositoryClass: TestQuestionRepository::class)]
class TestQuestion implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'testQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\Column]
    private ?int $sortOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTest(): ?test
    {
        return $this->test;
    }

    public function setTest(?test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getQuestion(): ?question
    {
        return $this->question;
    }

    public function setQuestion(question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function toResource(): ResourceInterface
    {
        return new TestQuestionResource(
            $this->id,
            $this->test->getId(),
            $this->question->getId(),
            $this->sortOrder,
            $this->question->getDescription(),
        );
    }
}
