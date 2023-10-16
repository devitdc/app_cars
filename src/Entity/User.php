<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @UniqueEntity("email", message="This email is already used.")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message="The email {{ value }} is not valid.",
     *     mode="strict"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable="true")
     * @Assert\Length(
     *     min="2",
     *     max="100",
     *     minMessage="Firstname must have {{ limit }} minimum characters.",
     *     maxMessage="Firstname must have {{ limit }} minimum characters."
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable="true")
     * @Assert\Length(
     *     min="2",
     *     max="100",
     *      minMessage="Lastname must have {{ limit }} minimum characters.",
     *     maxMessage="Lastname must have {{ limit }} minimum characters.")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=10, nullable="true")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=8,
     *     max=64,
     *     minMessage="Password must have {{ limit }} minimum characters.",
     *     maxMessage="Password must have {{ limit }} minimum characters.",
     *     groups={"Default", "checkPassword"})
     * @Assert\EqualTo(propertyPath="passwordMatch", message="The passwords do not match.")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $passwordMatch;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(
     *     min=3,
     *     max=10,
     *     minMessage="Status must have {{ limit }} minimum characters.",
     *     maxMessage="Status must have {{ limit }} minimum characters.")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        /* A utiliser lorsqu'un utilisateur à plusieurs rôles
         * avec une relation ManyToMany avec l'entité Role
         */
        /*$roles = [];
        $userRoles = $this->getRole();

        foreach ($userRoles as $userRole) {
            $roles[] = $userRole->getRoleName();
        }

        return $roles;*/

        /*
         * A utiliser lorsqu'un utilisateur à un seul rôle
         * avec une relation ManyToOne avec l'entité Role
         */
        $role = [];
        $userRole = $this->getRole();
        $role[] = $userRole->getRoleName();

        return $role;
    }

    public function setRoles($roles): self
    {
        /*if (is_string($roles)) {
            $this->roles = $roles;
        } else {
            $this->roles = [];
            foreach ($roles as $role) {
                $this->roles = $role;
            }
        }

        return $this;*/
    }

    public function getPasswordMatch(): ?string
    {
        return $this->passwordMatch;
    }

    public function setPasswordMatch(string $password): self
    {
        $this->passwordMatch = $password;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
       $this->status = $status;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

}
