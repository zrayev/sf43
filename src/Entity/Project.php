<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="project")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=1024)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectPeople", mappedBy="id", cascade={"persist"})
     */
    private $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ProjectPeople[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(ProjectPeople $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setId($this);
        }

        return $this;
    }

    public function removePerson(ProjectPeople $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getId() === $this) {
                $person->setId(null);
            }
        }

        return $this;
    }
}
