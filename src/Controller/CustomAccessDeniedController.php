<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomAccessDeniedController extends AbstractController
{
    #[Route('/custom-access-denied', name: 'custom_access_denied')]
    public function index(): Response
    {
        return $this->render('custom_access_denied/index.html.twig', [
            'controller_name' => 'CustomAccessDeniedController',
        ]);
    }
}
