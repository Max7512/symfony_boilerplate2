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
        $this->denyAccessUnlessGranted('view_user');
        return $this->render('utilisateurs/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route("/utilisateurs/form", name: "utilisateur_add")]
    #[Route("/utilisateurs/form/{id}", name: "utilisateur_edit")]
    public function form(UserRepository $userRepository, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, int $id = null): Response
    {
        if (!$id) {
            $user = new User();
            $this->denyAccessUnlessGranted('add_user', $user);
        } else {
            $user = $userRepository->find($id);
            $this->denyAccessUnlessGranted('edit_user', $user);
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
