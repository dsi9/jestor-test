<?php

namespace App\Models;

use App\Lib\Model;
use DateTimeImmutable;

class ToDo extends Model
{
    protected $table = 'todo_list';

    /** @var string|null */
    protected $subject;

    /** @var string|null */
    protected $description;

    /** @var string|null */
    protected $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

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

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date ? new DateTimeImmutable($this->date) : null;
    }

    public function setDate(?DateTimeImmutable $date): self
    {
        $this->date = $date->format('Y-m-d H:i:s');

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'id'          => $this->getId(),
            'subject'     => $this->getSubject(),
            'description' => $this->getDescription(),
            'date'        => $this->getDate()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @param array<string, string> $data
     * @return Model|User
     */
    public function buildFromArray(array $data): Model
    {
        return $this->setId($data['id'] ?? null)
                    ->setSubject($data['subject'] ?? null)
                    ->setDescription($data['description'] ?? null)
                    ->setDate($data['date'] ? new DateTimeImmutable($data['date']) : null);
    }
}
