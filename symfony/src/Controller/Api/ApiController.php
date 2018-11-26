<?php

namespace App\Controller\Api;


use App\Entity\Contact;
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getContactsListAction(Request $request): JsonResponse
    {
        try {
            // Gets the contacts list.x
            $em = $this->getDoctrine()->getManager();
            $contacts = $em->getRepository(Contact::class)->findAll();
            $data = [];
            /** @var Contact $contact */
            foreach ($contacts as $contact) {
                $data[] = $contact->__toArray();
            }

            $response = [
                'status' => 200,
                'data' => $data,
            ];

        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'data' => [
                    'message' => 'An error has occurred trying to get the contact list. Error: '.$e->getMessage(),
                ],
            ];
        }

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }
}
