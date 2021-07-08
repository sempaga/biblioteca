<?php

namespace App\Services;

use App\Repository\LibroRepository;

class LibroManager{

    private $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository= $libroRepository;
    }
    public function getJsonLibro(){
        $libros = $this->libroRepository->findAll();

        $librosArray = [];
        foreach($libros as $libro) {
            $libroArray = [
                $libro->getTitulo(),
                $libro->getIsbn(),
                $libro->getEdicion(),
                $libro->getPublicacion()
            ];
            $librosArray[] = $libroArray;
        }

        return $librosArray;

    }

    public function arrayToJson($libros)
    {
        $librosArray = [];
        foreach($libros as $libro) {
            $libroArray = [
                $libro->getTitulo(),
                $libro->getIsbn(),
                $libro->getEdicion(),
                $libro->getPublicacion()
            ];
            $librosArray[] = $libroArray;
        }

        return $librosArray;
    } 
}