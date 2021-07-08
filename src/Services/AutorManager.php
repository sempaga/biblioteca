<?php

namespace App\Services;

use App\Entity\Autor;
use Doctrine\ORM\EntityManagerInterface;

class AutorManager{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    public function crearAutor(string $nombre, string $apellido, string $apodo,string $tipo){
        $autor= new Autor;
        //2) dar el nombre y tipo al autor usando los datos recibidos
        $autor->setNombre($nombre);
        $autor->setApellido($apellido);
        $autor->setApodo($apodo);
        $autor->setTipo($tipo);

        //3)actualizar bbdd
        $this->em->persist($autor);
        $this->em->flush();

        return $autor;
    }
}