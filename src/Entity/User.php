<?php

namespace App\Entity;

use App\Resource\ResourceInterface;
use App\Resource\UserResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class User extends BasicEntity implements UserInterface, PasswordAuthenticatedUserInterface, EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 60)]
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

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Test::class)]
    private Collection $authoredTests;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: QuestionCategory::class)]
    private Collection $authoredQuestionCategories;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserTest::class, orphanRemoval: true)]
    private Collection $userTests;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    private Collection $relatedGroups;

    public const ACTIVE_NO  = 0;
    public const ACTIVE_YES = 1;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->authoredTests = new ArrayCollection();
        $this->authoredQuestionCategories = new ArrayCollection();
        $this->userTests = new ArrayCollection();
        $this->relatedGroups = new ArrayCollection();
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

    #[ORM\PrePersist]
    public function constructFullName() {
        $this->full_name = $this->last_name.' '.$this->first_name;
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

    public function getRelatedGroups(): Collection
    {
        return $this->relatedGroups;
    }

    public function addRelatedGroup(Group $relatedGroup): self
    {
        if (!$this->relatedGroups->contains($relatedGroup)) {
            $this->relatedGroups->add($relatedGroup);
        }

        return $this;
    }

    public function removeRelatedGroup(Group $relatedGroup): self
    {
        $this->relatedGroups->removeElement($relatedGroup);

        return $this;
    }

    public function toResource(): ResourceInterface
    {
        return new UserResource(
           $this->id,
           $this->email,
           $this->first_name,
           $this->last_name,
           $this->full_name,
           $this->active,
           $this->getRoles()
        );
    }
}
