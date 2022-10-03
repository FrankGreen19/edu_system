<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'questions')]
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $answer = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?QuestionImage $image = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestionCategory $questionCategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getImage(): ?QuestionImage
    {
        return $this->image;
    }

    public function setImage(?QuestionImage $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuestionCategory(): ?QuestionCategory
    {
        return $this->questionCategory;
    }

    public function setQuestionCategory(?QuestionCategory $questionCategory): self
    {
        $this->questionCategory = $questionCategory;

        return $this;
    }
}
