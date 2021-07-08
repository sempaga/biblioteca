<?php

namespace App\Controller;

use App\Repository\LibroRepository;
use App\Services\LibroManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataTableController extends AbstractController
{
    #[Route('/datatable', name: 'data_table')]
    public function index(): Response
    {
        return $this->render('data_table/index.html.twig', [
            'controller_name' => 'DataTableController',
        ]);
    }

    #[Route('/libros_json', name: 'libros_json')]
    public function libros_json(LibroRepository $libroRepository,LibroManager $manager): Response
    {
        //OPCION A: 
        //$librosArray = $manager->getJsonLibro();
        
        //OPCION B:
        $libros = $libroRepository->findAll();
        $librosArray = $manager->arrayToJson($libros);
        
        $content = [
            'data' => $librosArray
        ];

        return new JsonResponse($content);
    }
}
