<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
  #[Route('/', name:'app_homepage')]
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
  #[Route('/browse/{slug}', name: 'app_browse')] 
  public function browse(string $slug = null): Response
  {
    $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
    $mixes = $this->getMixes();
    
    return $this->render('vinyl/browse.html.twig', [
      'genre' => $genre,
      'mixes' => $mixes
    ]);
  }

  private function getMixes(): array
    {
      // data fake temporal 
      return [
        [
          'title' => 'PB & Jams',
          'trackCount' => 14,
          'genre' => 'Rock',
          'createdAt' => new DateTime('2023-02-20')
        ],
        [
          'title' => 'Put a Hex on your Ex',
          'trackCount' => 8,
          'genre' => 'Heavy Metal',
          'createdAt' => new DateTime('2023-01-19')
        ],
        [
          'title' => 'Spice Grills - Summer Tunes',
          'trackCount' => 10,
          'genre' => 'Pop',
          'createdAt' => new DateTime('2022-10-19')
        ]
      ];
    }
}