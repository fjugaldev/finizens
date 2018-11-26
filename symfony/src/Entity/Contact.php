<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Communication", mappedBy="contact")
     */
    private $communications;


    public function __construct()
    {
        $this->communications = new ArrayCollection();
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

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
        $contact = [
            'contact' => [
                'id'    => $this->getId(),
                'name'  => $this->getName(),
                'phone' => $this->getPhone(),
            ],
        ];

        foreach ($this->getCommunications() as $communication) {
            $contact['communications'][] = $communication->__toArray();
        }

        return $contact;
    }

    /**
     * @return Collection|Communication[]
     */
    public function getCommunications(): Collection
    {
        return $this->communications;
    }

    public function addCommunication(Communication $communication): self
    {
        if (!$this->communications->contains($communication)) {
            $this->communications[] = $communication;
            $communication->setContact($this);
        }

        return $this;
    }

    public function removeCommunication(Communication $communication): self
    {
        if ($this->communications->contains($communication)) {
            $this->communications->removeElement($communication);
            // set the owning side to null (unless already changed)
            if ($communication->getContact() === $this) {
                $communication->setContact(null);
            }
        }

        return $this;
    }
}
