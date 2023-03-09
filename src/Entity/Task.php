<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urgency = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column]
    private ?int $conditionId = null;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $description
     * @param string|null $urgency
     * @param \DateTimeInterface|null $deadline
     */
    public function __construct(?int $userId, ?string $name, ?string $description, ?string $urgency, ?\DateTimeInterface $deadline)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->urgency = $urgency;
        $this->deadline = $deadline;
        $this->conditionId = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrgency(): ?string
    {
        return $this->urgency;
    }

    public function setUrgency(?string $urgency): self
    {
        $this->urgency = $urgency;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getConditionId(): ?int
    {
        return $this->conditionId;
    }

    public function setConditionId(int $conditionId): self
    {
        $this->conditionId = $conditionId;

        return $this;
    }
}
