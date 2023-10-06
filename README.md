# Requirements
- PHP v8.1
- Symfony v5.5.10
- Composer

# Commands

Follow these steps to set up the symfony server. Execute these commands in the root of the project.

## Composer

`composer install`

## Symfony Development Server Up

`symfony server:start`

## Run test
`php bin/phpunit`

### Unit tests
`php bin/phpunit --testsuite=unit`

### Integration tests
`php bin/phpunit --testsuite=integration`

# Api documentation

With the symfony server on enter this site http://127.0.0.1:8000/api/doc

# TODOLIST

- [x] Usar Symfony como Framework
- [x] Debe ser un API REST y tener JSON como formato de salida.
- [x] Los campos a mostrar serán: id, name, tagline, first_brewed, descrition, image
- [x] Debe estar construida en Arquitectura Hexagonal y DDD
- [x] La aplicación debe cumplir los estandares PSR-2
- [x] Se deben construir test unitarios sin atacar al API ( Mockear PunkAPI )
- [x] Construir documentacion del API mediante OpenAPI. Puedes usar NelmioAPIBundle u otra librería para ello.
- [x] Cachear las peticiones a PunkAPI temporalmente mediante FileSystem o Redis
