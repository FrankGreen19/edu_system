<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tests')]
#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'authoredTests')]
    private ?User $author = null;

    #[ORM\Column]
    private ?int $questionsNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finishDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $executionTime = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestType $testType = null;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: TestQuestion::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $testQuestions;

    #[ORM\ManyToOne]
    private ?QuestionCategory $questionCategory = null;

    #[ORM\OneToMany(mappedBy: 'test', targetEntity: UserTest::class)]
    private Collection $userTests;

    public function __construct()
    {
        $this->testQuestions = new ArrayCollection();
        $this->userTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
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

    public function getQuestionsNumber(): ?int
    {
        return $this->questionsNumber;
    }

    public function setQuestionsNumber(int $questionsNumber): self
    {
        $this->questionsNumber = $questionsNumber;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getFinishDate(): ?\DateTimeInterface
    {
        return $this->finishDate;
    }

    public function setFinishDate(?\DateTimeInterface $finishDate): self
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    public function getExecutionTime(): ?int
    {
        return $this->executionTime;
    }

    public function setExecutionTime(int $executionTime): self
    {
        $this->executionTime = $executionTime;

        return $this;
    }

    public function getTestType(): ?TestType
    {
        return $this->testType;
    }

    public function setTestType(?TestType $testType): self
    {
        $this->testType = $testType;

        return $this;
    }

    /**
     * @return Collection<int, TestQuestion>
     */
    public function getTestQuestions(): Collection
    {
        return $this->testQuestions;
    }

    public function addTestQuestion(TestQuestion $orderedTestQuestion): self
    {
        if (!$this->testQuestions->contains($orderedTestQuestion)) {
            $this->testQuestions->add($orderedTestQuestion);
            $orderedTestQuestion->setTest($this);
        }

        return $this;
    }

    public function removeTestQuestion(TestQuestion $testQuestion): self
    {
        if ($this->testQuestions->removeElement($testQuestion)) {
            // set the owning side to null (unless already changed)
            if ($testQuestion->getTest() === $this) {
                $testQuestion->setTest(null);
            }
        }

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

    /**
     * @return Collection<int, UserTest>
     */
    public function getUserTests(): Collection
    {
        return $this->userTests;
    }

    public function addUserTest(UserTest $userTest): self
    {
        if (!$this->userTests->contains($userTest)) {
            $this->userTests->add($userTest);
            $userTest->setTest($this);
        }

        return $this;
    }

    public function removeUserTest(UserTest $userTest): self
    {
        if ($this->userTests->removeElement($userTest)) {
            // set the owning side to null (unless already changed)
            if ($userTest->getTest() === $this) {
                $userTest->setTest(null);
            }
        }

        return $this;
    }
}
