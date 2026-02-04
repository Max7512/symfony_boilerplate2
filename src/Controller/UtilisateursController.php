<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UtilisateursController extends AbstractController
{
    #[Route('/utilisateurs', name: 'utilisateurs')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('utilisateurs/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
