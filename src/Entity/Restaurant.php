<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 *
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="restaurant:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="restaurant:item"}}},
 *     paginationEnabled=false
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"conference": "exact"})
 * 
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * @Groups({"restaurant:list", "restaurant:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"restaurant:list", "restaurant:item"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"restaurant:list", "restaurant:item"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Groups({"restaurant:list", "restaurant:item"})
     */
    private $open;

    /**
     * @ORM\ManyToOne(targetEntity=Conference::class, inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"restaurant:list", "restaurant:item"})
     */
    private $conference;

    public function __toString(): string
    {
        return $this->name.' - '.$this->type;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOpen(): ?bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;

        return $this;
    }

    public function getConference(): ?Conference
    {
        return $this->conference;
    }

    public function setConference(?Conference $conference): self
    {
        $this->conference = $conference;

        return $this;
    }
}
