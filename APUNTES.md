# Mixed Vinyl

Este proyecto es el primer curso de una serie de cursos sobre Symfony 6.0 de la web symfonycasts.  

## Inicio Proyecto

Hemos creado un proyecto base con el comando `symfony new mixed_vinyl`. 

Hemos creado el controlador VinylController a mano con dos rutas, una sencilla('/') y
otra dinámica ruta 'dinámica'('/browse/{slug}').

## Instalando templates

Para instalar una biblioteca de templates hemos utilizado el comando `composer require templates`.
'templates' es un alias que podemos utilizar gracias a el plugin de composer 'Flex' que previamente
viene instalado en nuestro proyecto de symfony. 
Podemos constular estos alias en 'flex.symfony.com'.

Flex tiene 3 superpoderes:
  1. Podemos utilizar alias:
      En lugar de tener que escribir el nombre completo del paquete requerido podemos escribir una sola palabra. 
  2. Desempaquetar paquetes.  
      Podemos llamar a un paquete que es una atajo para ejecutar 'composer require' y que se añadan
      varias librerias a tu proyecto.
  3. Sistema de recetas
      Las recetas vienen en los paquetes. Flex además de descargar las librerías ejecutará la receta 
      si la hubiere. Las recetas puedes hacer cosas como añadir nuevos archivos o inluso modificar
      algunos ya archivos ya existentes. 
      Por ejemplo en el caso de el paquete 'templates' crea la carpeta /templates en el proyecto y el archivo
      config/packages/twig.yaml.

## Las recetas en Symfony

Cada vez que instalamos un nuevo paquete, flex comprueba en un repositorio central si el paquete contiene una 
receta si es así la instala.

#### ¿ Dónde viven las recetas ?

En la nube. O más concretamente en Github (github.com/symfony/recipes) las aprobadas por el equipo de Symfony.
En github.com/symfony/recipes-contrib las que no están aprobadas por el equipo pero esto no quiere decir que no
sean buenas.
Para comprobar las recetas que tenemos instaladar en un proyecto podemos ejecutar el comando:
`composer recipes`
Si queremos información de una receta en concreto ejecutaremos:
`composer recipes nomre/del-paquete`

Se puede consultar lo que hace una receta en el manifest.json de esta en github.

Lo primero que hace la receta que viene con el paquete twig/pack es activar el twig bundle dentro
del archivo correspondiente. Las recetas son como una instalación automática. 

Lo segundo es copiar los archivos que lleva la receta en los archivos con el mismo nombre del proyecto.

#### Bundle

Un bundle es un plugin que le da nuevas características a Symfony.
Para activar un bundle tiene que estar en el archivo config/bundles.php

## Controller

Los controladores normalmente heredan de AbstractController para acceder a métodos que hacen 
cosas interesantes como renderizar una plantilla(template).
Un controlador debe devolver siempre un objeto Symfony Response.
La función del controlador puede tener dos tipos de argumentos:
  1. Uno cuyo nombre coincida con el comodín de la ruta.
  2. Uno cuyo tipo-indicación coincida con uno de los servicios de nuesta aplicación.  

## Twig

En Twig tenemos 3 sintaxis diferentes.

Para imprimir una variable utilizamos => {{ }}
Para comentarios => {# #}
Utilizar PHP o hacer algo => {% %} 

Para twig tenemos etiquetas(if, for, block...), filtros(title, sort, reverse...), funciones(max, random...)
y tests que sirven para los ifs(divisibleby, empty ...).
Podemos consultar la documentación en -> https://twig.symfony.com/doc/

#### Extensión de plantillas

`{% extends 'base.html.twig' %}` 

Cuando extendemos base.html.twig en otra plantilla. Le estamos diciendo a twig que reenderice base.html.twig
y que inserte en el contenido del archivo del template en el que hemos introducido la expresión de la primera línea.
Debemos indicarle en qué parte de base.html.twig queremos que aparezca dicho contenido. 
Para ello rodeamos el contenido con 
`{% block body %}`
  `<div>`
    `contenido`
  `</div>`
 `{% endblock %}`
En base.html.twig tendremos `{% block body %}{% endblock %}`

## Depurador

Para añadir un sistema de depuración que nos muestre información sobre nuestro proyecto(barra de herramientas 
de depuración web) ejecutamos el comando `composer require debug`. Es otro alias que nos instala paquetes y recetas 
referentes a la depuración del proyecto.

## Rutas

Las rutas se puden restringir a un determinado método(GET, POST, PUT).
Ejemplo: `#[Route('/api/songs/{id}', methods: ['GET'])]` => Sólo funcionará 
con el método GET.

Para vert informacón sobre las rutas de nuestro proyecto utilizamos:
`php bin/console debug:router`

Para comprobar el funcionamiento de una ruta concreta con un método concreto:
`php bin/console router:match /api/songs/11 --method=POST`

## Servicios

Los servicios son objetos que realizan un trabajo. Los servicios son herramientas. Symfony está
repleto de objetos que hacen su trabajo. Todo el trabajo en symfony lo hace un servicio.

Los más conocidos son: Twig, Logger, Cache, Database Conection, API Requests, Router.
Cuando instalamos un paquete obtendremos más objetos útiles.

Para consultar los servicios de nuestro proyecto:
`php bin/console debug:autowiring`

Si queremos buscar uno en específico, por ejemplo relacionado con twig:
`php bin/console debug:autowiring twig`

## Webpack

Es la herramienta estándar de la industria para empaquetar, minimizar y analizar nuestro CSS, JS y otros
archivos del Frontend. En Symfony el paquete se llama 'Encore Webpack'.

Para instalar: `composer require encore`.
Después necesitamos instalar algunos paquetes de Node con `yarn install`.

Gracias a estas líneas:
`{% block stylesheets %}
    {{ encore_entry_link_tags('app') }}
 {% endblock %}

 {% block javascripts %}
    {{ encore_entry_script_tags('app') }}
 {% endblock %}`

Podemos guardar en /assets los CSS y JS para que se reendericen en nuestro html.