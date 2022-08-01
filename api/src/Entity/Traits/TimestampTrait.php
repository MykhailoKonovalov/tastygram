<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo;

trait TimestampTrait
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Mapping\Annotation\Timestampable(on: 'create')]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Mapping\Annotation\Timestampable(on: 'update')]
    private ?\DateTimeInterface $updated = null;

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setUpdated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}