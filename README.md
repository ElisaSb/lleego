# Challenge

## Guía

Para arrancar el proyecto, seguid los siguientes pasos:

* Instalar [Docker](https://docs.docker.com/engine/install/ubuntu/), [Docker-compose](https://docs.docker.com/compose/install/) y el comando _make_:
```console
$ sudo apt install make
```
* Lanzar los siguientes comandos dentro de la raíz del proyecto:
```console
$ make build
$ make install
```
* Al acceder desde un navegador a "http://127.0.7.14/api" podremos ver el mensaje --> "Server is ready!" en la pantalla.

***

* Al acceder desde un navegador a "http://127.0.7.14/api/avail?origin=MAD&destination=BIO&date=2022-06-01" obtendremos el GET con la petición esperada.
* Al lanzar los siguientes comandos en una terminal, obtendremos la respuesta esperada:
```console
$ make ssh-be
$ php bin/console lleego:avail MAD BIO 2023-06-01
```
***

### Datos sobre la prueba

Las características de la prueba son las siguientes:

* Se encuentra configurada con Docker.
* PHP: 7.4
* Symfony: 5
