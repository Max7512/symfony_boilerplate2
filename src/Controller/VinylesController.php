<?php

namespace App\Controller;

use App\Entity\Vinyle;
use App\Form\VinyleType;
use App\Repository\VinyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VinylesController extends AbstractController
{
    #[Route('/vinyles', name: 'vinyles')]
    public function index(VinyleRepository $vinyleRepository): Response
    {
        return $this->render('vinyles/index.html.twig', [
            'vinyles' => $vinyleRepository->findAll(),
        ]);
    }

    #[Route("/vinyles/form", name: "vinyle_add")]
    #[Route("/vinyles/form/{id}", name: "vinyle_edit")]
    public function form(VinyleRepository $vinyleRepository, Request $request, EntityManagerInterface $manager, int $id = null): Response
    {
        if (!$id) {
            $vinyle = new Vinyle();
        } else {
            $vinyle = $vinyleRepository->findById($id);
        }

        $this->denyAccessUnlessGranted('add_vinyle', $vinyle);

        if ($vinyle->getId()) {
            $this->denyAccessUnlessGranted('edit_vinyle', $vinyle);
        }

        $form = $this->createForm(VinyleType::class, $vinyle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vinyle);
            $manager->flush();

            return $this->redirectToRoute('vinyles');
        }

        return $this->render('vinyles/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
