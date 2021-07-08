<?php

namespace App\Controller;

use App\Entity\Autor;
use App\Repository\AutorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\AutorManager;

class AutorController extends AbstractController
{

    public function index(AutorRepository $autorRepository): Response
    {
        $autores= $autorRepository->findAll();
        return $this->render('autor/index.html.twig', [
            'autores'=>$autores,
        ]);
    }

    public function new(): Response
    {
        return $this->render('autor/new.html.twig');
    }

    public function create(Request $request, AutorManager $manager): Response
    {
        //1) recibir datos
        $nombre = $request->request->get('nombre'); //le pasas en get el argumento del parametro name del html
        $apellido = $request->request->get('apellido'); //le pasas en get el argumento del parametro name del html
        $apodo = $request->request->get('apodo'); //le pasas en get el argumento del parametro name del html
        $tipo =$request->request->get('tipo');
       //2) LLamar al servicio 
        try{
            $autor =$manager->crearAutor($nombre, $apellido, $apodo, $tipo);
            $autor->getId();
        }catch(\Exception $ex ){
            $ex->getMessage();
            $ex->getCode();
            $ex->getTraceAsString();
        }
        //3) redirigir al formulario o lo que se pida despues
        return $this->redirectToRoute('autor');
    }

    public function ver(AutorRepository $autorRepository, $id):Response
    {
        $autor = $autorRepository->find($id);
        dump($autor);
        return $this->render('autor/ver.html.twig',[
            'autor'=> $autor
        ]);
    }
    public function edit(AutorRepository $autorRepository, $id):Response
    {
        $autor = $autorRepository->find($id);

        return $this->render('autor/modificar.html.twig', [
            'autor' => $autor
        ]);

        
    }

    public function update($id, Request $request, EntityManagerInterface $em, AutorRepository $autorRepository): Response
    {
        $nombre = $request->request->get('nombre');
        $apellido = $request->request->get('apellido'); //le pasas en get el argumento del parametro name del html
        $apodo = $request->request->get('apodo'); 
        $tipo = $request->request->get('tipo');
        
        $autor = $autorRepository->find($id);
        $autor->setNombre($nombre);
        $autor->setApellido($apellido);
        $autor->setApodo($apodo);
        $autor->setTipo($tipo);
            
        $em->persist($autor);
        $em->flush();

        return $this->redirectToRoute('autor');
    }

    public function remove(AutorRepository  $autorRepository, EntityManagerInterface $em, $id):Response
    {
        $autor = $autorRepository->find($id);
        $em->remove($autor);
        $em->flush();
        
        return $this->redirectToRoute('autor');

    }
}
