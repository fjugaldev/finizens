<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommunicationRepository")
 */
class Communication
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CommunicationType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isIncoming;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOutgoing;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="communications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * Communication constructor.
     */
    public function __construct()
    {
        $this->isIncoming = false;
        $this->isOutgoing = false;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getType(): ?CommunicationType
    {
        return $this->type;
    }

    public function setType(?CommunicationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return array
     */
    public function __toJson(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'id'       => $this->getId(),
            'phone'    => $this->getPhone(),
            'type'     => $this->getType()->getName(),
            'incoming' => $this->getIsIncoming(),
            'outgoing'  => $this->getIsOutgoing(),
            'datetime' => $this->getDatetime()->format('Y-m-d H:i:s'),
            'duration' => !is_null($this->getDuration()) ? $this->getDuration()->format('H:i:s') : [],
        ];
    }

    public function getIsIncoming(): ?bool
    {
        return $this->isIncoming;
    }

    public function setIsIncoming(bool $isIncoming): self
    {
        $this->isIncoming = $isIncoming;

        return $this;
    }

    public function getIsOutgoing(): ?bool
    {
        return $this->isOutgoing;
    }

    public function setIsOutgoing(bool $isOutgoing): self
    {
        $this->isOutgoing = $isOutgoing;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
