<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Form\LibroType;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/crud-libro')]
class CRUDLibroController extends AbstractController
{
    #[Route('/', name: 'c_r_u_d_libro_index', methods: ['GET'])]
    public function index(LibroRepository $libroRepository): Response
    {
        return $this->render('crud_libro/index.html.twig', [
            'libros' => $libroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'c_r_u_d_libro_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $libro = new Libro();
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($libro);
            $entityManager->flush();
            $this->addFlash('info', 'Libro Creado');
            return $this->redirectToRoute('c_r_u_d_libro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_libro/new.html.twig', [
            'libro' => $libro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'c_r_u_d_libro_show', methods: ['GET'])]
    public function show(Libro $libro): Response
    {
        return $this->render('crud_libro/show.html.twig', [
            'libro' => $libro,
        ]);
    }

    #[Route('/{id}/edit', name: 'c_r_u_d_libro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Libro $libro): Response
    {
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('c_r_u_d_libro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('crud_libro/edit.html.twig', [
            'libro' => $libro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'c_r_u_d_libro_delete', methods: ['POST'])]
    public function delete(Request $request, Libro $libro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$libro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($libro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('c_r_u_d_libro_index', [], Response::HTTP_SEE_OTHER);
    }
}
