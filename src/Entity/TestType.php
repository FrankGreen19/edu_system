<?php

namespace App\Entity;

use App\Repository\TestTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'test_types')]
#[ORM\Entity(repositoryClass: TestTypeRepository::class)]
class TestType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $title = null;

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
}
