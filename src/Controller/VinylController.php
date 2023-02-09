<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController
{
  #[Route('/')]
  public function homepage(): Response
  {
    return new Response('Hola soy Diego');
  }

  /**
   * Lo que pongamos en slug en la ruta, lo recibirá la función como parametro.
   * En este caso no es obligatorio pasarle algo porque iniciamos $slug en null.
   */
  #[Route('/browse/{slug}')] 
  public function browse(string $slug = null): Response
  {
    if ($slug) {
      $title = 'Género: '.u(str_replace('-', ' ', $slug))->title(true);
    } else {
      $title = 'Todos los géneros.';
    }
    
    return new Response($title);
  }
}