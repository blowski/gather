<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GatheringRepository")
 */
class Gathering
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HomeGroup", inversedBy="gatherings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $homeGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Material")
     */
    private $material;

    /**
     * @ORM\Column(type="text")
     */
    private $passage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="gathering")
     */
    private $comments;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable")
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable")
     */
    private $endDate;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeGroup(): ?HomeGroup
    {
        return $this->homeGroup;
    }

    public function setHomeGroup(?HomeGroup $homeGroup): self
    {
        $this->homeGroup = $homeGroup;

        return $this;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial(Material $material)
    {
        $this->material = $material;
        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): Gathering
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): Gathering
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments->add($comment);
        $comment->setGathering($this);
        return $this;
    }

    public function getPassage()
    {
        return $this->passage;
    }

    public function setPassage($passage)
    {
        $this->passage = $passage;
        return $this;
    }
}
