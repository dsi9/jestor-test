<?php

namespace App\Models;

use App\Lib\Model;

class User extends Model
{
    /** @var string */
    protected $table = 'users';

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPasswordHash(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'       => $this->getId(),
            'name'     => $this->getName(),
            'email'    => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
    }

    /**
     * @param array<string, string> $data
     * @return Model|User
     */
    public function buildFromArray(array $data): Model
    {
        return $this->setId($data['id'] ?? null)
                    ->setName($data['name'] ?? null)
                    ->setEmail($data['email'] ?? null)
                    ->setPasswordHash($data['password'] ?? null);
    }
}
