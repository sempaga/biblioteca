<?php

namespace App\Controller;

use App\Entity\Editorial;
use App\FakeData\Paises;
use App\Repository\EditorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorialController extends AbstractController
{
    public function index(EditorialRepository $editorialRepository): Response
    {
        $editoriales= $editorialRepository->findAll();
        return $this->render('editorial/index.html.twig', [
            'editoriales'=>$editoriales,
        ]);
    }

    public function new(): Response
    {
        $paises = Paises::$paises;
        return $this->render('editorial/new.html.twig', ['paises'=>$paises]);
    }

    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //1) recibir datos
        $nombre = $request->request->get('nombre'); //le pasas en get el argumento del parametro name del html
        $pais = $request->request->get('pais'); //le pasas en get el argumento del parametro name del html
        
        //2) dar de alta en bbdd
            //1) crear objeto autor
            $editorial= new Editorial;
            //2) dar el nombre y tipo al autor usando los datos recibidos
            $editorial->setNombre($nombre);
            $editorial->setPais($pais);
           

            //3)actualizar bbdd
            $em->persist($editorial);
            $em->flush();
        //3) redirigir al formulario o lo que se pida despues
        return $this->redirectToRoute('editorial');
    }

    public function ver(EditorialRepository $editorialRepository, $id):Response
    {
        $editorial = $editorialRepository->find($id);
        dump($editorial);
        return $this->render('editorial/ver.html.twig',[
            'editorial'=> $editorial
        ]);
    }
    public function edit(EditorialRepository $editorialRepository, $id):Response
    {
        $paises = Paises::$paises;
        $editorial = $editorialRepository->find($id);

        return $this->render('editorial/modificar.html.twig', [
            'editorial'=>$editorial, 'paises'=>$paises
        ]);
    }
    public function update($id, Request $request, EntityManagerInterface $em, EditorialRepository $editorialRepository): Response
    {
        $editorial= $editorialRepository->find($id);
        //1) recibir datos
        $nombre = $request->request->get('nombre'); //le pasas en get el argumento del parametro name del html
        $pais = $request->request->get('pais');
        //2) dar el nombre y tipo al autor usando los datos recibidos
        $editorial->setNombre($nombre);
        $editorial->setPais($pais);
            
        $em->persist($editorial);
        $em->flush();

        return $this->redirectToRoute('editorial');
    }

    public function remove(EditorialRepository  $editorialRepository, EntityManagerInterface $em, $id):Response
    {
        $editorial= $editorialRepository->find($id);
        
        $em->remove($editorial);
        $em->flush();
        $editoriales= $editorialRepository->findAll();

        return $this->render('editorial/index.html.twig', [
            'editoriales'=>$editoriales,
        ]);

    }
}
