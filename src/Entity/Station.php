<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StationRepository")
 */
class Station
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
    private $stationTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stationCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="stations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStationTitle(): ?string
    {
        return $this->stationTitle;
    }

    public function setStationTitle(string $stationTitle): self
    {
        $this->stationTitle = $stationTitle;

        return $this;
    }

    public function getStationCode(): ?string
    {
        return $this->stationCode;
    }

    public function setStationCode(string $stationCode): self
    {
        $this->stationCode = $stationCode;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }
}
