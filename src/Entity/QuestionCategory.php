<?php

namespace App\Entity;

use App\Repository\QuestionCategoryRepository;
use App\Resource\QuestionCategoryResource;
use App\Resource\ResourceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'question_categories')]
#[ORM\Entity(repositoryClass: QuestionCategoryRepository::class)]
class QuestionCategory extends BasicEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'authoredQuestionCategories')]
    private ?user $author = null;

    #[ORM\OneToMany(mappedBy: 'questionCategory', targetEntity: Question::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $questions;

    const AUTHORLESS = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?user
    {
        return $this->author;
    }

    public function setAuthor(?user $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questions->toArray();
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuestionCategory($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuestionCategory() === $this) {
                $question->setQuestionCategory(null);
            }
        }

        return $this;
    }

    public function toResource(): ResourceInterface
    {
        $questions = [];
        foreach ($this->getQuestions() as $question) {
            $questions[] = $question->toExtendedResource();
        }

        return new QuestionCategoryResource(
            $this->id,
            $this->title,
            $questions,
        );
    }
}
