<?php

namespace App\Model;


use App\Service\BaseService;

/**
 * Class ContactModel
 */
class ContactModel
{
    /** @var string */
    protected $name;

    /** @var */
    protected $phone;

    /** @var array */
    protected $communicationLog;

    /**
     * ContactModel constructor.
     */
    public function __construct()
    {
        $this->communicationLog = [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     *
     * @return self
     */
    public function setPhone(int $phone): self
    {
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getCommunicationLog(): array
    {
        return $this->communicationLog;
    }

    /**
     * @param array $communicationLog
     *
     * @return self
     */
    public function setCommunicationLog(array $communicationLog): self
    {
        $this->communicationLog = $communicationLog;

        return $this;
    }

    /**
     * @return array
     */
    public function __toJson(): array
    {
        return get_object_vars($this);
    }
}
