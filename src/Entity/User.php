<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180, nullable=false)
     */
    private $givenName;

    /**
     * @ORM\Column(type="string", length=180, nullable=false)
     */
    private $surname;

    /**
     * @ORM\Column(nullable=false, unique=true, length=16)
     */
    private $screenName;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\HomeGroup", inversedBy="members")
     */
    private $homeGroups;

    public function __construct()
    {
        $this->homeGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGivenName()
    {
        return $this->givenName;
    }

    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addHomeGroup(HomeGroup $homeGroup): self
    {
        if(!$this->homeGroups->contains($homeGroup)) {
            $this->homeGroups->add($homeGroup);
        }

        return $this;
    }

    public function removeHomeGroup(HomeGroup $homeGroup): self
    {
        if($this->homeGroups->contains($homeGroup)) {
            $this->homeGroups->removeElement($homeGroup);
        }

        return $this;
    }

    public function getHomeGroups(): Collection
    {
        return $this->homeGroups;
    }

    public function getScreenName()
    {
        return $this->screenName;
    }

    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
        return $this;
    }


}
