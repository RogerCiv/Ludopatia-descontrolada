<?php

namespace App\Controller;

use App\Entity\Apuesta;
use App\Entity\NumerosLoteria;
use App\Entity\Sorteo;
use App\Form\NumerosLoteriaType;
use App\Repository\ApuestaRepository;
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

    #[Route('comprar/{id}/{sorteoId}', name: 'app_numeros_loteria_comprar', methods: ['POST', 'GET'])]
    public function comprar(Request $request, NumerosLoteria $numerosLoterium, EntityManagerInterface $entityManager, int $id, int $sorteoId): Response
    {
        // Obtener el usuario actual
        $user = $this->getUser();
    
        // Obtener el número de lotería seleccionado
        $numeroLoteria = $entityManager->getRepository(NumerosLoteria::class)->find($id);

        if (!$numeroLoteria) {
            throw $this->createNotFoundException('No se encontró el número de lotería con el ID: ' . $id);
        }
    
        // Obtener el sorteo
        $sorteo = $entityManager->getRepository(Sorteo::class)->find($sorteoId);
    
        
        // Verificar que los objetos se hayan encontrado
        if (!$user || !$numeroLoteria || !$sorteo) {
            throw $this->createNotFoundException('Usuario, número de lotería o sorteo no encontrado.');
        }
    
        // Crear una nueva instancia de Apuesta
        $apuesta = new Apuesta();
        $apuesta->setUsuario($user);
        $apuesta->setNumeroLoteria($numeroLoteria);
        $apuesta->setSorteo($sorteo);
    
        // Persistir y flush para guardar en la base de datos
        $entityManager->persist($apuesta);
        $entityManager->flush();
    
        // Redireccionar de nuevo a la vista del sorteo
        return $this->redirectToRoute('app_sorteo_show', ['id' => $sorteoId], Response::HTTP_SEE_OTHER);
    }
    
}
