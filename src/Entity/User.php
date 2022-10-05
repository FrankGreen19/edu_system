<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $last_name = null;

    #[ORM\Column(length: 20)]
    private ?string $first_name = null;

    #[ORM\Column(length: 50)]
    private ?string $full_name = null;

    #[ORM\Column]
    private ?int $active = null;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    private Collection $roles;

    #[ORM\OneToMany(mappedBy: 'authorId', targetEntity: Test::class)]
    private Collection $authoredTests;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: QuestionCategory::class)]
    private Collection $authoredQuestionCategories;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserTest::class, orphanRemoval: true)]
    private Collection $userTests;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->authoredTests = new ArrayCollection();
        $this->authoredQuestionCategories = new ArrayCollection();
        $this->userTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->roles->toArray() as $role) {
            $roles[] = $role->getTitle();
        }

        return $roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * @return Collection<int, Test>
     */
    public function getAuthoredTests(): Collection
    {
        return $this->authoredTests;
    }

    public function addAuthoredTest(Test $authoredTest): self
    {
        if (!$this->authoredTests->contains($authoredTest)) {
            $this->authoredTests->add($authoredTest);
            $authoredTest->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthoredTest(Test $authoredTest): self
    {
        if ($this->authoredTests->removeElement($authoredTest)) {
            // set the owning side to null (unless already changed)
            if ($authoredTest->getAuthor() === $this) {
                $authoredTest->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionCategory>
     */
    public function getAuthoredQuestionCategories(): Collection
    {
        return $this->authoredQuestionCategories;
    }

    public function addAuthoredQuestionCategory(QuestionCategory $authoredQuestionCategory): self
    {
        if (!$this->authoredQuestionCategories->contains($authoredQuestionCategory)) {
            $this->authoredQuestionCategories->add($authoredQuestionCategory);
            $authoredQuestionCategory->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthoredQuestionCategory(QuestionCategory $authoredQuestionCategory): self
    {
        if ($this->authoredQuestionCategories->removeElement($authoredQuestionCategory)) {
            // set the owning side to null (unless already changed)
            if ($authoredQuestionCategory->getAuthor() === $this) {
                $authoredQuestionCategory->setAuthor(null);
            }
        }

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
            $userTest->setUser($this);
        }

        return $this;
    }

    public function removeUserTest(UserTest $userTest): self
    {
        if ($this->userTests->removeElement($userTest)) {
            // set the owning side to null (unless already changed)
            if ($userTest->getUser() === $this) {
                $userTest->setUser(null);
            }
        }

        return $this;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}
