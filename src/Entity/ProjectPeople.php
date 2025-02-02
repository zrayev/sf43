<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="projectPeople")
 */
class ProjectPeople
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=256)
     */
    private $type;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=1024)
     */
    private $responsibility;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="people")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $project;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="projectPeople")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $person;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponsibility(): ?string
    {
        return $this->responsibility;
    }

    public function setResponsibility(string $responsibility): self
    {
        $this->responsibility = $responsibility;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getPerson(): ?Staff
    {
        return $this->person;
    }

    public function setPerson(?Staff $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
