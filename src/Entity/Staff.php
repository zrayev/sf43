<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="staff")
 */
class Staff
{
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    public $createdAt;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="people")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $skills;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Department", inversedBy="people")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectPeople", mappedBy="person", cascade={"persist"})
     */
    private $projectPeople;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->projectPeople = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
        }

        return $this;
    }

    /**
     * @return Collection|ProjectPeople[]
     */
    public function getProjectPeople(): Collection
    {
        return $this->projectPeople;
    }

    public function addProjectPerson(ProjectPeople $projectPerson): self
    {
        if (!$this->projectPeople->contains($projectPerson)) {
            $this->projectPeople[] = $projectPerson;
            $projectPerson->setPerson($this);
        }

        return $this;
    }

    public function removeProjectPerson(ProjectPeople $projectPerson): self
    {
        if ($this->projectPeople->contains($projectPerson)) {
            $this->projectPeople->removeElement($projectPerson);
            // set the owning side to null (unless already changed)
            if ($projectPerson->getPerson() === $this) {
                $projectPerson->setPerson(null);
            }
        }

        return $this;
    }

    public function setSkills(?ProjectPeople $skills): self
    {
        $this->skills = $skills;

        return $this;
    }
}
