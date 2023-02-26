<?php

namespace App\Controller;

use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
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
  public function browse(HttpClientInterface $httpClient, CacheInterface $cache, string $slug = null): Response
  {
    $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
    $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($httpClient){ // Ver punto 1 de NOTAS
      $cacheItem->expiresAfter(5); // la caché expirará en 5 segundos
      $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
      return $response->toArray();
    });
    
    return $this->render('vinyl/browse.html.twig', [
      'genre' => $genre,
      'mixes' => $mixes
    ]);
  }
}

/**
 * NOTAS:
 * 1. Caché: La primera vez que carge la web no tendrá nada en caché, de este modo ejecutará función que le pasamos como segundo
 * argumento en cache->get() la cual hará la petición a la URL y almacena la respuesta en la caché como un array por primera vez.
 * Cuando volvamos a cargar la página ya obtendremos los datos de la caché en 'mixes_data'.
 */