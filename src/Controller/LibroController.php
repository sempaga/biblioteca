<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Repository\AutorRepository;
use App\Repository\EditorialRepository;
use App\Repository\LibroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    
    public function index(LibroRepository $libroRepository): Response
    {
        $libros= $libroRepository->findAll();
        return $this->render('libro/index.html.twig', [
            'libros'=>$libros
        ]);
    }
    public function new(EditorialRepository $editorialRepository,
    AutorRepository $autorRepository): Response
    {
        $editoriales = $editorialRepository->findAll();
        $autores = $autorRepository->findAll();

        return $this->render('libro/new.html.twig',  [
            'editoriales'=>$editoriales, 'autores'=>$autores]);
    }

    public function create(Request $request, EntityManagerInterface $em,  EditorialRepository $editorialRepository,
    AutorRepository $autorRepository ): Response
    {

        $datosForm = $request->request->get('libro');
        dump($datosForm);

        $libro = new Libro();
        $libro->setTitulo($datosForm['titulo']);
        $libro->setIsbn($datosForm['isbn']);
        $libro->setEdicion($datosForm['edicion']);
        $libro->setPublicacion($datosForm['publicacion']);
        $libro->setCategoria($datosForm['categoria']);
        
        $editorial = $editorialRepository->find($datosForm['editorial']);
        $libro->setEditorial($editorial);

        $autoresIds = (array)$datosForm['autores'];
        foreach($autoresIds as $autorId) {
            $autor = $autorRepository->find($autorId);
            $libro->addAutor($autor);
        }

        $em->persist($libro);
        $em->flush();

        
        
        return $this->redirectToRoute('libro');
    }

    public function ver(LibroRepository  $libroRepository, $id):Response
    {
        $libro = $libroRepository->find($id);
        dump($libro);
        return $this->render('libro/ver.html.twig',[
            'libro'=> $libro
        ]);
    }
    public function edit(EditorialRepository $editorialRepository,
    AutorRepository $autorRepository, $id, LibroRepository $libroRepository):Response
    {
        $libro = $libroRepository->find($id);
        $editoriales = $editorialRepository->findAll();
        $autores = $autorRepository->findAll();
        return $this->render('libro/modificar.html.twig',  ['libro'=>$libro,
            'editoriales'=>$editoriales, 'autores'=>$autores]);
    }

    public function update( $id,
    Request $request, 
    LibroRepository $libroRepository, 
    EditorialRepository $editorialRepository,
    AutorRepository $autorRepository,
    EntityManagerInterface $em): Response
    {
        $datosForm = $request->request->get('libro');
        dump($datosForm);

        $libro = $libroRepository->find($id);
        $libro->setTitulo($datosForm['titulo']);
        $libro->setIsbn($datosForm['isbn']);
        $libro->setEdicion($datosForm['edicion']);
        $libro->setPublicacion($datosForm['publicacion']);
        $libro->setCategoria($datosForm['categoria']);
        
        $editorial = $editorialRepository->find($datosForm['editorial']);
        $libro->setEditorial($editorial);

        $autoresIds = (array)$datosForm['autores'];
        foreach($autoresIds as $autorId) {
            $autor = $autorRepository->find($autorId);
            $libro->addAutor($autor);
        }

        $em->persist($libro);
        $em->flush();
        return $this->render('fondo/edit.html.twig', [
            'libro' => $libro,
            'editoriales' => $editorialRepository->findAll(),
            'autores' => $autorRepository->findAll(),
        ]);
    }

    public function remove(LibroRepository  $libroRepository, EntityManagerInterface $em, $id):Response
    {
        $libro= $libroRepository->find($id);
        
        $em->remove($libro);
        $em->flush();
        $libros= $libroRepository->findAll();

        return $this->render('autor/index.html.twig', [
            'libros'=>$libros,
        ]);

    }
}
