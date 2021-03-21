<?php

namespace App\Entity;

use App\Repository\ClassRoomRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ClassRoomRepository::class)
 * @ApiResource()
 */
class ClassRoom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     * @return ClassRoom
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return ClassRoom
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return array
     */
    public function getApiSchema()
    {
        return [
            'class' => $this->getClass(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'active' => $this->getActive(),
        ];
    }
}
