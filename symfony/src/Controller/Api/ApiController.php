<?php

namespace App\Controller\Api;


use App\Utils\LogParser;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @Route("/api/v1", name="finizens_")
 */
class ApiController extends FOSRestController
{

    /**
     * @Rest\Get("/contacts", name="contact_list")
     *
     * @return JsonResponse
     */
    public function getContactsListAction(): JsonResponse
    {
        // Gets the contacts list.
        $response = $this->get('api.service.contacts_service')->getAll();

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }

    /**
     * @Rest\Get("/communications/{phone}", name="communications_list")
     *
     * @param int $phone
     *
     * @return JsonResponse
     */
    public function getCommunicationsListAction(int $phone): JsonResponse
    {
        // Gets the communication list for a contact.
        $response = $this->get('api.service.communications_service')->getAll();

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }
}
