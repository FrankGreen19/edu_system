<?php

namespace App\Entity;

use App\Repository\OrderedTestQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ordered_test_questions')]
#[ORM\Entity(repositoryClass: OrderedTestQuestionRepository::class)]
class OrderedTestQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'orderedTestQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?test $test = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?question $question = null;

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
}
