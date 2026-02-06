# API de Gestion de Productos y Divisas

API RESTful construida con Laravel 11 utilizando una arquitectura orientada a dominios (DDD), servida sobre FrankenPHP para alto rendimiento y totalmente contenerizada con Docker.

## Stack Tecnologico

- **Framework:** Laravel 11
- **Arquitectura:** Domain Driven Design (DDD) Modular
- **Servidor:** FrankenPHP (Octane)
- **Base de Datos:** PostgreSQL 15
- **Testing:** PestPHP (Feature & Unit Tests)
- **Infraestructura:** Docker & Docker Compose

## Documentacion y Recursos Adicionales

Para facilitar la revision y pruebas del proyecto, se incluyen los siguientes recursos en la carpeta `docs/`:

- **Coleccion de Postman:** Importa el archivo `docs/postman_collection.json` en tu cliente Postman para tener todos los endpoints listos para usar.
- **Diagrama Entidad-Relacion (ER):** Visualizacion de la estructura de base de datos y relaciones entre Productos, Divisas y Precios.

![Modelo Entidad Relacion](docs/er_model.png)

## Requisitos Previos

- Docker
- Docker Compose

## Instalacion y Despliegue

Este proyecto sigue una configuracion "Zero Config". El entorno se encarga de esperar la disponibilidad de la base de datos y ejecutar las migraciones automaticamente al iniciar.

1. Construir e iniciar los contenedores:

    docker compose up -d --build

2. Acceder a la API:

- URL Base: http://localhost/api

## Ejecucion de Pruebas

El proyecto cuenta con una suite de pruebas automatizadas implementadas con PestPHP para asegurar la integridad de la logica de negocio.

Para ejecutar las pruebas dentro del contenedor:

    docker-compose exec app composer test-p

## Estructura del Proyecto (DDD)

El codigo fuente se ha organizado separando los dominios de negocio de la infraestructura del framework.

    app/
    ├── Domains/
    │   ├── Currency/       # Logica de Divisas
    │   │   ├── Actions/    # Casos de uso (Create, Delete con validacion)
    │   │   ├── Models/     # Modelos Eloquent
    │   └── Product/        # Logica de Productos
    │       ├── Actions/
    │       ├── Models/
    ├── Http/
    │   ├── Controllers/    # Controladores
    │   └── Requests/       # Form Requests (Validacion de entrada)

## Consumo de la API

### Paginacion y Estructura de Respuesta

Los endpoints de listado (como `/api/products`) implementan paginacion estandar. La respuesta JSON sigue la estructura `JSON API` simplificada de Laravel:

- **data:** Contiene el array de objetos solicitados.
- **links:** Enlaces de navegacion (first, last, prev, next).
- **meta:** Informacion de paginacion (current_page, from, to, total, per_page).

Ejemplo de uso para navegar entre paginas:

    GET /api/products?page=2

### Endpoints Principales

#### Productos

| Metodo | Endpoint | Descripcion |
| :--- | :--- | :--- |
| GET | /api/products | Listar productos (Paginado) |
| POST | /api/products | Crear nuevo producto |
| GET | /api/products/{id} | Ver detalles de un producto |
| PUT | /api/products/{id} | Actualizar producto |
| DELETE | /api/products/{id} | Eliminar producto (Soft Delete) |

#### Divisas

| Metodo | Endpoint | Descripcion |
| :--- | :--- | :--- |
| GET | /api/currencies | Listar todas las divisas disponibles |
| POST | /api/currencies | Registrar nueva divisa |
| GET | /api/currencies/{id} | Consultar detalles de una divisa |
| DELETE | /api/currencies/{id} | Eliminar divisa (Validado: no permite borrar si tiene uso) |

#### Precios por Moneda

| Metodo | Endpoint | Descripcion |
| :--- | :--- | :--- |
| POST | /api/products/{id}/prices | Agregar precio en otra moneda a un producto |
| GET | /api/products/{id}/prices | Listar todos los precios asociados a un producto |

## Seguridad Implementada

### Rate Limiting
Se ha implementado un limitador de tráfico para prevenir ataques de fuerza bruta y denegación de servicio (DDoS).
- **Limite:** 60 peticiones por minuto por IP.
- **Respuesta:** HTTP 429 Too Many Requests.

### CORS (Cross-Origin Resource Sharing)
La API está configurada para restringir el acceso a dominios específicos definidos en la variable de entorno `CORS_ALLOWED_ORIGINS`.

## Decisiones Tecnicas

1. **Inmutabilidad:** El archivo docker-compose.yml no utiliza volumenes para montar el codigo en tiempo de ejecucion, garantizando que la imagen construida sea identica a la desplegada.
2. **Strict Typing:** Se utiliza `declare(strict_types=1);` en las clases para asegurar la robustez del tipado.
3. **Validacion de Negocio:** Se implementaron Actions para encapsular reglas complejas, como impedir la eliminacion de una divisa si existen productos cotizados en ella.