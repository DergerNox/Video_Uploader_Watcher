<?php
namespace DB\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "RegisteredUsers")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 30)]
    private string $UserName;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "datetime")]
    private \DateTime $reg_date;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $role;

    // Getters and setters...

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->UserName;
    }

    public function setUserName(string $UserName): void
    {
        $this->UserName = $UserName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRegDate(): \DateTime
    {
        return $this->reg_date;
    }

    public function setRegDate(\DateTime $reg_date): void
    {
        $this->reg_date = $reg_date;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }
}
