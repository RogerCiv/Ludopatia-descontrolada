<?php

namespace App\Controller;

use App\Repository\SorteoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(SorteoRepository $sorteoRepository): Response
    {
        $sorteos = $sorteoRepository->findAll();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'sorteos' => $sorteos,
        ]);
    }
}
