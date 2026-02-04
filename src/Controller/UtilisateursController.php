<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UtilisateursController extends AbstractController
{
    #[Route('/utilisateurs', name: 'utilisateurs')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('utilisateurs/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route("/utilisateurs/form", name: "utilisateur_add")]
    #[Route("/utilisateurs/form/{id}", name: "utilisateur_edit")]
    public function form(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, User $user = null): Response
    {
        if(!$user) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user->getId()) {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        'password'
                    )
                );
            }
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('utilisateurs/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
