<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("title")
 * @ORM\Entity()
 * @ORM\Table(name="skill")
 */
class Skill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", mappedBy="skills", cascade={"persist"})
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

    /**
     * @return Collection|Staff[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Staff $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->addSkill($this);
        }

        return $this;
    }

    public function removePerson(Staff $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            $person->removeSkill($this);
        }

        return $this;
    }
}
