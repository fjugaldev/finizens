<?php

namespace App\Service;


use App\Entity\Communication;
use App\Entity\CommunicationType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContactService
 */
class ContactService implements BaseServiceInterface
{
    const TYPE_CALL = 'call';
    const TYPE_SMS = 'sms';

    /** @var ContainerInterface */
    protected $container;

    /** @var EntityManager */
    protected $entityManager;

    /**
     * InventoryService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, EntityManager $entityManager)
    {
        $this->setContainer($container);
        $this->setEntityManager($entityManager);
        //$this->communicationLog = explode(PHP_EOL, file_get_contents(self::LOG_URL));
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
    }

    /**
     * @return array
     */
    public function parse(array $communicationLog): array
    {
        // Gets the log parser service.
        $contactsLog = $this->getContainer()->get('api.service.log_parser')->parse($communicationLog);
        $contacts = [];
        foreach ($contactsLog as $detail) {
            $em = $this->getEntityManager();

            // Verifies if the contact already exists
            $contact = $em->getRepository(Contact::class)->findOneBy([
                'phone' => $detail['details']['phone'],
            ]);

            // If contact doesn't exits, creates a new one.
            if (is_null($contact)) {
                $contact = new Contact();
                $contact->setName($detail['details']['name']);
                $contact->setPhone($detail['details']['phone']);
                $em->persist($contact);
                $em->flush();
            }

            foreach ($detail['communications'] as $comm) {
                // Creates a new communication entity object.
                $communication = new Communication();

                switch ($comm['type']) {
                    // Type call
                    case self::TYPE_CALL:
                        // Finds the type entity object.
                        $type = $em->getRepository(CommunicationType::class)->findOneBy([
                            'name' => self::TYPE_CALL,
                        ]);
                        // Sets communication type.
                        $communication->setType($type);
                        // Sets the call duration.
                        $time = substr($comm['duration'],0,2).':'.
                            substr($comm['duration'], 2, 2).':'.
                            substr($comm['duration'], 4, 2);
                        $duration = \DateTime::createFromFormat('H:i:s', $time);
                        $communication->setDuration($duration);
                        // Sets Incoming / Outgoing direction.
                        $communication->setIsIncoming($comm['inOut'] === 'incoming' ? true : false);
                        $communication->setIsOutgoing($comm['inOut'] === 'outgoing' ? true : false);
                        break;

                    // Type sms
                    case self::TYPE_SMS:
                        // Finds the type entity object.
                        $type = $em->getRepository(CommunicationType::class)->findOneBy([
                            'name' => self::TYPE_SMS,
                        ]);
                        // Sets the communication type.
                        $communication->setType($type);
                        // Sets Sent / Received direction.
                        $communication->setIsIncoming($comm['inOut'] === 'received' ? true : false);
                        $communication->setIsOutgoing($comm['inOut'] === 'sent' ? true : false);
                        break;

                    default:
                        throw new \Exception("Invalid communication type.");
                }
                // Sets the destination phone.
                $communication->setPhone($comm['phone']);
                // Sets the datetime for the communication.
                $date = \DateTime::createFromFormat('dmYHis', $comm['date']);
                $communication->setDatetime($date);
                // Saves the communication.
                $em->persist($communication);
                // Add the communication to the contact
                $contact->addCommunication($communication);
                // Saves the contact.
                $em->persist($contact);
            }

            // Commit changes.
            $em->flush();

            // Push each contact in contacts array.
            array_push($contacts, $contact->__toJson());
        }

        return $contacts;
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
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Sets de Service Container.
     * @param ContainerInterface $container
     *
     * @return self
     */
    protected function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    protected function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
