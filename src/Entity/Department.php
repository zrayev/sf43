<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="department")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/<[a-z][\s\S]*>/i",
     *     match=false,
     *     message="Your text cannot contain invalid characters."
     * )
     * @ORM\Column(type="string", length=1024)
     */
    private $description;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $teamLead;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="departments")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", mappedBy="departments")
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

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
            $person->addDepartment($this);
        }

        return $this;
    }

    public function removePerson(Staff $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            $person->removeDepartment($this);
        }

        return $this;
    }

    public function getTeamLead(): ?string
    {
        return $this->teamLead;
    }

    public function setTeamLead(string $teamLead): self
    {
        $this->teamLead = $teamLead;

        return $this;
    }
}
