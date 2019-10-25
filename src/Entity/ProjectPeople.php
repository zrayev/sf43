<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private  $responsibility;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="people")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private  $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
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
}
