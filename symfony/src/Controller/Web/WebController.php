<?php

namespace App\Controller\Web;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/contacts", name="default")
     */
    public function index()
    {
        return $this->render('app.html.twig');
    }
}
