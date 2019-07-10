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
     * @ORM\Column(type="integer")
     */
    private $routeInterval;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $routeNotificationId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="routes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getRouteInterval(): ?int
    {
        return $this->routeInterval;
    }

    public function setRouteInterval(int $routeInterval): self
    {
        $this->routeInterval = $routeInterval;

        return $this;
    }

    public function getRouteNotificationId(): ?int
    {
        return $this->routeNotificationId;
    }

    public function setRouteNotificationId(?int $routeNotificationId): self
    {
        $this->routeNotificationId = $routeNotificationId;

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
}
