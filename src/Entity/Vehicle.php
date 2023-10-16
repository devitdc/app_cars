<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="vehicles")
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 * @Vich\Uploadable()
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank()
     */
    private ?string $mileAge;

    /**
     * @ORM\Column(type="integer", length=4)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=4,
     *     max=4,
     *     exactMessage="This value should have exactly {{ limit }} characters"
     * )
     */
    private ?string $yearManufacture;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/(?<!\d)[2-5](?!\d)/",
     *     match=true,
     *     message="Number of doors must be between 2 and 5."
     * )
     */
    private ?int $doorNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $horsePower;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/(?<!\d)[2-9](?!\d)/",
     *     match=true,
     *     message="Number of seats must be between 2 and 9."
     * )
     */
    private ?int $seatNumber;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     */
    private ?string $vehicleCondition;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private ?string $gearBoxType;

    /**
     * @ORM\Column(type="bigint")
     */
    private ?float $price;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank()
     */
    private ?string $fuelType;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     */
    private ?string $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private ?string $registrationNumber;

    /**
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="image")
     *
     */
    private ?File $imageFile = null;

    public function __toString() {
        return
            $this->vehicleCondition .
            $this->gearBoxType .
            $this->fuelType .
            $this->color .
            $this->image .
            $this->registrationNumber .
            $this->model;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMileAge(): ?string
    {
        return $this->mileAge;
    }

    public function setMileAge(string $mileAge): self
    {
        $this->mileAge = $mileAge;

        return $this;
    }

    public function getYearManufacture(): ?string
    {
        return $this->yearManufacture;
    }

    public function setYearManufacture(string $yearManufacture): self
    {
        $this->yearManufacture = $yearManufacture;

        return $this;
    }

    public function getDoorNumber(): ?int
    {
        return $this->doorNumber;
    }

    public function setDoorNumber(int $doorNumber): self
    {
        $this->doorNumber = $doorNumber;

        return $this;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): self
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getVehicleCondition(): ?string
    {
        return $this->vehicleCondition;
    }

    public function setVehicleCondition(string $vehicleCondition): self
    {
        $this->vehicleCondition = $vehicleCondition;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getGearBoxType(): ?string
    {
        return $this->gearBoxType;
    }

    public function setGearBoxType(string $gearBoxType): self
    {
        $this->gearBoxType = $gearBoxType;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $imageFile
     * @return Vehicle
     */
    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        /*if ($this->imageFile instanceof UploadedFile) {
            $this->d_image_updated = new \DateTime('now');
        }*/
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

}
