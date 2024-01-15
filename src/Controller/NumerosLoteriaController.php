<?php

namespace App\Controller;

use App\Entity\NumerosLoteria;
use App\Form\NumerosLoteriaType;
use App\Repository\NumerosLoteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/numeros/loteria')]
class NumerosLoteriaController extends AbstractController
{
    #[Route('/', name: 'app_numeros_loteria_index', methods: ['GET'])]
    public function index(NumerosLoteriaRepository $numerosLoteriaRepository): Response
    {
        return $this->render('numeros_loteria/index.html.twig', [
            'numeros_loterias' => $numerosLoteriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_numeros_loteria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $numerosLoterium = new NumerosLoteria();
        $form = $this->createForm(NumerosLoteriaType::class, $numerosLoterium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($numerosLoterium);
            $entityManager->flush();

            return $this->redirectToRoute('app_numeros_loteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('numeros_loteria/new.html.twig', [
            'numeros_loterium' => $numerosLoterium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_numeros_loteria_show', methods: ['GET'])]
    public function show(NumerosLoteria $numerosLoterium): Response
    {
        return $this->render('numeros_loteria/show.html.twig', [
            'numeros_loterium' => $numerosLoterium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_numeros_loteria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NumerosLoteria $numerosLoterium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NumerosLoteriaType::class, $numerosLoterium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_numeros_loteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('numeros_loteria/edit.html.twig', [
            'numeros_loterium' => $numerosLoterium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_numeros_loteria_delete', methods: ['POST'])]
    public function delete(Request $request, NumerosLoteria $numerosLoterium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$numerosLoterium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($numerosLoterium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_numeros_loteria_index', [], Response::HTTP_SEE_OTHER);
    }
}
