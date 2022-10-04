<?php

namespace App\Entity;

use App\Repository\UserTestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'user_tests')]
#[ORM\Entity(repositoryClass: UserTestRepository::class)]
class UserTest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userTests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?test $test = null;

    #[ORM\ManyToOne(inversedBy: 'userTests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\Column(nullable: true)]
    private ?float $result = null;

    #[ORM\OneToMany(mappedBy: 'userTest', targetEntity: UserQuestionAnswers::class, orphanRemoval: true)]
    private Collection $userQuestionAnswers;

    #[ORM\Column]
    private ?\DateTimeImmutable $startedAt = null;

    public function __construct()
    {
        $this->userQuestionAnswers = new ArrayCollection();
    }

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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getResult(): ?float
    {
        return $this->result;
    }

    public function setResult(?float $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Collection<int, UserQuestionAnswers>
     */
    public function getUserQuestionAnswers(): Collection
    {
        return $this->userQuestionAnswers;
    }

    public function addUserQuestionAnswer(UserQuestionAnswers $userQuestionAnswer): self
    {
        if (!$this->userQuestionAnswers->contains($userQuestionAnswer)) {
            $this->userQuestionAnswers->add($userQuestionAnswer);
            $userQuestionAnswer->setUserTest($this);
        }

        return $this;
    }

    public function removeUserQuestionAnswer(UserQuestionAnswers $userQuestionAnswer): self
    {
        if ($this->userQuestionAnswers->removeElement($userQuestionAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuestionAnswer->getUserTest() === $this) {
                $userQuestionAnswer->setUserTest(null);
            }
        }

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }
}
