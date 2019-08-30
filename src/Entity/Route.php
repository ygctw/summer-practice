<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RouteRepository")
 */
class Route
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station")
     * @ORM\JoinColumn(nullable=false)
     */
    private $routeFromId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Station")
     * @ORM\JoinColumn(nullable=false)
     */
    private $routeToId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="routes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="time")
     */
    private $routeInterval;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $routeNotification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRouteFromId(): ?string
    {
        return $this->routeFromId;
    }

    public function setRouteFromId(string $routeFromId): self
    {
        $this->routeFromId = $routeFromId;

        return $this;
    }

    public function getRouteToId(): ?string
    {
        return $this->routeToId;
    }

    public function setRouteToId(string $routeToId): self
    {
        $this->routeToId = $routeToId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRouteInterval(): ?\DateTimeInterface
    {
        return $this->routeInterval;
    }

    public function setRouteInterval(\DateTimeInterface $routeInterval): self
    {
        $this->routeInterval = $routeInterval;

        return $this;
    }

    public function getRouteNotification(): ?\DateTimeInterface
    {
        return $this->routeNotification;
    }

    public function setRouteNotification(?\DateTimeInterface $routeNotification): self
    {
        $this->routeNotification = $routeNotification;

        return $this;
    }
}
