<?php

namespace App\Service;


/**
 * Class CommunicationService
 */
class CommunicationService implements BaseService
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * InventoryService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function get(int $id): array
    {
        // TODO: Implement get() method.
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function add(\stdClass $parameters): array
    {
        // TODO: Implement add() method.
    }

    /**
     * @param int       $id
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function edit(int $id, \stdClass $parameters): array
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function remove(string $name): array
    {
        // TODO: Implement remove() method.
    }

    /**
     * Gets the Service Container.
     * @return ContainerInterface
     */
    private function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Sets de Service Container.
     * @param ContainerInterface $container
     *
     * @return self
     */
    private function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }
}
