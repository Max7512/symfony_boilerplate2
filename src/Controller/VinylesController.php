<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VinylesController extends AbstractController
{
    #[Route('/vinyles', name: 'vinyles')]
    public function index(): Response
    {
        return $this->render('vinyles/index.html.twig', [
            'controller_name' => 'VinylesController',
        ]);
    }
}
