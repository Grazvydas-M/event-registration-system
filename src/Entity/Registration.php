<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'registrations')]
    private Event $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Registration
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Registration
    {
        $this->email = $email;

        return $this;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): Registration
    {
        $this->event = $event;

        return $this;
    }
}
