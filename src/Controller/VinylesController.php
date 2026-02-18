<?php

namespace App\Controller;

use App\Entity\Vinyle;
use App\Form\Flow\DTO\DescriptionDTO;
use App\Form\Flow\DTO\NameDTO;
use App\Form\Flow\DTO\PriceDTO;
use App\Form\Flow\VinyleMultiStepFlow;
use App\Form\Flow\VinyleType;
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

    #[Route("/vinyles/flow", name: "vinyle_add")]
    #[Route("/vinyles/flow/{id}", name: "vinyle_edit")]
    public function flow(VinyleRepository $vinyleRepository, Request $request, EntityManagerInterface $manager, int $id = null): Response
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

        $vinyleType = new VinyleType(new NameDTO($vinyle->getName()), new DescriptionDTO($vinyle->getDescription()), new PriceDTO($vinyle->getPrice()));

        /** @var FormFlowInterface $flow */
        $flow = $this->createForm(VinyleMultiStepFlow::class, $vinyleType);

        $flow->handleRequest($request);

        if ($flow->isSubmitted() && $flow->isValid() && $flow->isFinished()) {
            $manager->persist($vinyle);
            $manager->flush();

            return $this->redirectToRoute('vinyles');
        }

        return $this->render('vinyles/form.html.twig', [
            'form' => $flow->getStepForm(),
        ]);
    }
}
