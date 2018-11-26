# Finizens APP
La presente app tiene como finalidad implementar una solución como parte del proceso de selección de la empresa.

## Requerimientos necesarios:
1. Docker
1. Npm o Yarn (Recomendado)
1. Composer

## Tecnología empleada:
1. Symfony 4.1.8 para el backend y API Rest.
1. Vue.js para el frontend.
1. MySQL 5.7

## TO-DO:
- [X] Configurar entorno con Docker
- [X] Instalar paquetes requeridos backend.
- [X] Diseñar y crear de Entidades.
- [X] Generar BD desde doctrine command
- [X] Generar schema de bd con doctrine command
- [X] Implementar el API Rest, Servicios y Clases requeridas para la lógica de negocio.
- [X] Documentar entre lineas de código.
- [X] Aplicar estandares de Symfony (PSR-1, PSR-2 y PSR-4).
- [X] Aplicar Mess Detector.
- [X] Instalar paquetes requeridos frontend
    - [X] Instalar y configurar Bootstrap-Vue
    - [X] Instalar y configurar Axio
    - [X] Instalar y configurar Vue-Router -> Para enrutamiento, no se utilizó por falta de tiempo.
    - [X] Instalar y configurar Vuex -> Para manejo de estados y store, no se utilizó por falta de tiempo.
- [X] Configurar Webpack encore.
- [X] Implementar interfaz con Vue.js
- [ ] Realizar pruebas unitarias (PHPUnit)

## Instalación

Clonar el repositorio:

```sh
$ git clone https://github.com/fjugaldev/finizens.git
```
```sh
$ cd finizens
```
Generamos nuestro stack de docker a instalar
```sh
$ docker-compose -f docker-compose.yaml -f docker-compose.mysql.yaml config > docker-stack.yaml
```
- Realizamos el build basado en nuestro docker-stack.yaml
```sh
$ docker-compose -f docker-stack.yaml build
```
Ahora instalamos dependencias del proyecto, tanto para backend como frontend
La app esta desarrollada bajo el directorio "***symfony***"

```sh
$ cd symfony
```
Instalar dependencias de composer y node

```sh
$ composer install
$ yarn install #recomendado
ó
$ npm install
```

Compilar archivos js y css

```sh
$ ./node_modules/.bin/encore dev 
```

Iniciar nuestros contenedores

```sh
$ cd ..
```

```sh
$ docker-compose -f docker-stack.yaml up -d
```

Añadimos el host de mysql para que apunte a 127.0.0.1 en nuestro fichero de hosts

```sh
$ echo '127.0.0.1       mysql' | sudo tee -a /etc/hosts
```

Seguidamente procederemos a generar el schema de la bd:

```sh
$ cd symfony
```
```sh
$ php bin/console doctrine:schema:update --force
```
Precargamos data necesaria en el contenedor de mysql:

```sh
$ cd ..
```

```sh
$ docker exec -i finizens_mysql mysql -ufinizens -pfinizens finizens_db < symfony/finizens_db_communication_type.sql
```

Parseamos el fichero mediante el comando (Ejecutar una sola vez, Valida los contactos generados y no los duplica pero el log de comunicaciones no pude validarlo por temas de tiempo):

```sh
$ php bin/console finizens:parse-log 611111111
```

Ejecutamos la app dirigiendonos a: http://127.0.0.1:8008/contacts

Al iniciar tendremos lo siguiente: 
- Servidor ejecutandose en http://127.0.0.1:8008
- Servidor mysql en puerto 3306
- Base de datos: finizens_db
- Usuario BD: finizens
- Password BD: finizenz
- El host de mysql es "mysql" en lugar de "localhost" ya que se trata de un contenedor de docker.

Para mas detalles ver el fichero .env dentro del directorio "***symfony***" o comunícate conmigo mediante ***fjugal.dev@franciscougalde.com*** 'o' a mi móvil ***695913552***

## Consideraciones Finales:
- Por cuestiones de tiempo no pude implementar al inicio las pruebas unitarias con PHPUnit.
- Quería implementar DDD mediante la arquitectura en cebolla (Onion Architecture) pero por cuestiones de tiempo, no pude terminar de configurar otro proyecto en Symfony en donde estoy generando un skeleton base para futuros proyectos.
- El comando implementado para parsear los ficheros solo parsea un fichero indicando un número de teléfono a consultar. La idea era tambien crear un comando padre o manager para leer un directorio de logs y que este se encargara de ejecutar recursivamente el comando que actualmente esta generado.
- Me faltó añadir seguridad mediante tokens al API por cuestiones de tiempo.
- Me faltó validar un poco más los datos de entrada y salida por cuestiones de tiempo.
- Me faltó gestionar un poco mejor los errores por cuestiones de tiempo.




