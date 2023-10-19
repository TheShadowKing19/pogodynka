<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $country_code = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $longitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $latitude = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: WeatherForecast::class)]
    private Collection $weatherForecasts;

    public function __construct()
    {
        $this->weatherForecasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): static
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection<int, WeatherForecast>
     */
    public function getWeatherForecasts(): Collection
    {
        return $this->weatherForecasts;
    }

    public function addWeatherForecast(WeatherForecast $weatherForecast): static
    {
        if (!$this->weatherForecasts->contains($weatherForecast)) {
            $this->weatherForecasts->add($weatherForecast);
            $weatherForecast->setLocation($this);
        }

        return $this;
    }

    public function removeWeatherForecast(WeatherForecast $weatherForecast): static
    {
        if ($this->weatherForecasts->removeElement($weatherForecast)) {
            // set the owning side to null (unless already changed)
            if ($weatherForecast->getLocation() === $this) {
                $weatherForecast->setLocation(null);
            }
        }

        return $this;
    }
}
