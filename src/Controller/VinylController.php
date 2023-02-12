<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
  #[Route('/')]
  public function homepage(): Response
  {
    $tracks = [
      ['song' => 'La vereda de la puerta de atrás', 'artist' => 'Extremoduro'],
      ['song' => 'Primavera', 'artist' => 'Marea'],
      ['song' => 'Besos de Judas', 'artist' => 'J. Sabina'],
      ['song' => 'Asturias', 'artist' => 'Victor Manuel'],
      ['song' => 'Maneras de vivir', 'artist' => 'Rosendo'] 
    ];

    return $this->render('vinyl/homepage.html.twig', [
      'title' => 'Mi lista',
      'tracks' => $tracks
    ]);
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