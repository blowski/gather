<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomeGroupRepository")
 */
class HomeGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="homeGroups", orphanRemoval=true)
     */
    private $members;

    /**
     * @ORM\Column(type="string", length=6, unique=true)
     * @Assert\Length(
     *     min="6",
     *     max="6",
     *     exactMessage="Code must be exactly 6 characters"
     * )
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gathering", mappedBy="homeGroup", orphanRemoval=true)
     */
    private $gatherings;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->gatherings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->addHomeGroup($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            $member->removeHomeGroup($this);
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return Collection|Gathering[]
     */
    public function getGatherings(): Collection
    {
        return $this->gatherings;
    }

    public function addGathering(Gathering $gathering): self
    {
        if (!$this->gatherings->contains($gathering)) {
            $this->gatherings[] = $gathering;
            $gathering->setHomeGroup($this);
        }

        return $this;
    }

    public function removeGathering(Gathering $gathering): self
    {
        if ($this->gatherings->contains($gathering)) {
            $this->gatherings->removeElement($gathering);
            // set the owning side to null (unless already changed)
            if ($gathering->getHomeGroup() === $this) {
                $gathering->setHomeGroup(null);
            }
        }

        return $this;
    }
}
