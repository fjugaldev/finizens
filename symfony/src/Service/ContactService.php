<?php

namespace App\Service;


use App\Model\CallModel;
use App\Model\ContactModel;
use App\Model\SmsModel;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContactService
 */
class ContactService implements BaseService
{
    const LOG_URL = 'https://gist.githubusercontent.com/miguelgf/e099e5e5bfde4f6428edb0ae94946c83/raw/f2eb3e6f5b4d78e9172b946379c6900db7a2c578/communications.611111111.log';
    const TYPE_CALL = 'call';
    const TYPE_SMS = 'sms';

    /** @var ContainerInterface */
    protected $container;

    /** @var array */
    protected $communicationLog;

    /**
     * InventoryService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->communicationLog = explode(PHP_EOL, file_get_contents(self::LOG_URL));
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function get(int $id): array
    {
        // TODO: Implement get() method.
        return [];
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
        $contacts = $this->getContainer()->get('api.service.log_parser')->parse($this->getCommunicationLog());
        $data = [];
        foreach ($contacts as $detail) {
            $contact = new ContactModel();
            $contact->setName($detail['details']['name']);
            $contact->setPhone($detail['details']['phone']);

            $communications = [];
            foreach ($detail['communications'] as $type => $communication) {
                switch ($type) {
                    case self::TYPE_CALL:
                        $comm = new CallModel();
                        $comm->setType(self::TYPE_CALL);
                        $comm->setPhone($communication['phone']);
                        $comm->setDate($communication['phone']);
                        $comm->setCallDuration($communication['phone']);
                        break;

                    case self::TYPE_SMS:
                        $comm = new SmsModel();
                        $comm->setType(self::TYPE_SMS);
                        $comm->setPhone($communication['phone']);
                        $comm->setDate($communication['phone']);
                        break;

                    default:
                        throw new \Exception("Invalid communication type.");
                }

                $communications[] = $comm->__toJson();
            }

            $contact->setCommunicationLog($communications);
            $contacts[] = $contact->__toJson();
        }

        return [
            'data' => $contacts,
            'status' => 200,
        ];
    }

    /**
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function add(\stdClass $parameters): array
    {
        // TODO: Implement add() method.
        return [];
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
        return [];
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function remove(string $name): array
    {
        // TODO: Implement remove() method.
        return [];
    }

    /**
     * @return array
     */
    protected function getCommunicationLog()
    {
        return $this->communicationLog;
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
