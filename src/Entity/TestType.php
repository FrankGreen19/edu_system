<?php

namespace App\Entity;

use App\Repository\TestTypeRepository;
use App\Resource\ResourceInterface;
use App\Resource\TestTypeResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'test_types')]
#[ORM\Entity(repositoryClass: TestTypeRepository::class)]
class TestType extends BasicEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
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

    public function toResource(): ResourceInterface
    {
        return new TestTypeResource($this->id, $this->title);
    }
}
