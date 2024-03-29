<?php

namespace App\Controller;

use App\Entity\Sorteo;
use App\Form\SorteoType;
use App\Repository\ApuestaRepository;
use App\Repository\NumerosLoteriaRepository;
use App\Repository\SorteoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sorteo')]
class SorteoController extends AbstractController
{
    #[Route('/', name: 'app_sorteo_index', methods: ['GET'])]
    public function index(SorteoRepository $sorteoRepository): Response
    {
        return $this->render('sorteo/index.html.twig', [
            'sorteos' => $sorteoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sorteo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sorteo = new Sorteo();
        $form = $this->createForm(SorteoType::class, $sorteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sorteo->setFechaInicio(new \DateTime('now'));
            $sorteo->setState(0);
            $entityManager->persist($sorteo);
            $entityManager->flush();

            return $this->redirectToRoute('app_sorteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorteo/new.html.twig', [
            'sorteo' => $sorteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorteo_show', methods: ['GET'])]
    public function show(Sorteo $sorteo, NumerosLoteriaRepository $numerosLoteriaRepository, ApuestaRepository $apuestaRepository): Response
    {
        $numerosLoteria = $numerosLoteriaRepository->findAll();
        $apuestas = $apuestaRepository->findAll();
        return $this->render('sorteo/show.html.twig', [
            'sorteo' => $sorteo,
            'numerosLoteria' => $numerosLoteria,
            'apuestas' => $apuestas,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sorteo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sorteo $sorteo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SorteoType::class, $sorteo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sorteo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sorteo/edit.html.twig', [
            'sorteo' => $sorteo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorteo_delete', methods: ['POST'])]
    public function delete(Request $request, Sorteo $sorteo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sorteo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sorteo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sorteo_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/realizar_sorteo/{id}', name: 'realizar_sorteo', methods: ['GET'])]
    public function realizarSorteoManual(Sorteo $sorteo, EntityManagerInterface $entityManager): Response
{
    // Realiza el sorteo manualmente, similar a tu lógica actual
    // Puedes copiar y pegar el código relevante de la acción realizarSorteo
 // Realiza el sorteo
 $numerosLoteria = $sorteo->getNumerosLoteria();
 $numerosDisponibles = [];
 
 foreach ($numerosLoteria as $numeroLoteria) {
    
         $numerosDisponibles[] = $numeroLoteria;
     
 }
 dd($numerosDisponibles);
 $numeroGanador = $numerosDisponibles[array_rand($numerosDisponibles)]->getNumero();
 $sorteo->setWinner($numeroGanador);
    // Marca el sorteo como completado
    $sorteo->setState(1);
    
    // Guarda los cambios en la base de datos
    $entityManager->flush();

    // Redirige de vuelta a la página del sorteo
    return $this->redirectToRoute('app_sorteo_show', ['id' => $sorteo->getId()]);
}

// #[Route('/realizar_sorteo/{id}', name: 'realizar_sorteo', methods: ['GET'])]
// public function realizarSorteoManual(Sorteo $sorteo, EntityManagerInterface $entityManager): Response
// {
// // Realiza el sorteo manualmente, similar a tu lógica actual
// // Puedes copiar y pegar el código relevante de la acción realizarSorteo
// // Realiza el sorteo
// $numerosLoteria = $sorteo->getNumerosLoteria();
// $numerosDisponibles = [];

// foreach ($numerosLoteria as $numeroLoteria) {

//      $numerosDisponibles[] = $numeroLoteria;
 
// }
// dd($numerosDisponibles);
// $numeroGanador = $numerosDisponibles[array_rand($numerosDisponibles)]->getNumero();
// $sorteo->setWinner($numeroGanador);
// // Marca el sorteo como completado
// $sorteo->setState(1);

// // Guarda los cambios en la base de datos
// $entityManager->flush();

// // Redirige de vuelta a la página del sorteo
// return $this->redirectToRoute('app_sorteo_show', ['id' => $sorteo->getId()]);
// }
// ...


}
