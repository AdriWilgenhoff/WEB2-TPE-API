# Trabajo Práctico Especial - Web 2 - 2024

## Integrantes
- Florencia Alarcos (36608008)
- Adrian Ezequiel Wilgenhoff (33356953)
 
## Temática
Atracciones Turistícas

## Descripción
Este proyecto consiste en una API REST para gestionar atracciones turísticas, permitiendo realizar operaciones de alta, baja y modificación (ABM) de atracciones. Incluye un archivo de colección de Postman para facilitar las pruebas.

## Documentación de la API

### Endpoints 
|       Request         | Método |                    Endpoint                       | Status Success |  Status Error   |
|-----------------------|--------|---------------------------------------------------|----------------| ----------------|
| Listar atracciones    |  GET   | http://localhost/WEB2-TPE-API/api/atraccion       |     200-204    |        -        |
| Obtener atraccion     |  GET   | http://localhost/WEB2-TPE-API/api/atraccion/:id   |       200      |       404       |
| Crear atraccion       |  POST  | http://localhost/WEB2-TPE-API/api/atraccion       |       201      |   400-401-500   |
| Editar atraccion      |  PUT   | http://localhost/WEB2-TPE-API/api/atraccion/:id   |       201      | 400-401-404-500 |
| Obtener token         |  GET   | http://localhost/WEB2-TPE-API/api/user/token      |       200      |       400       |

### Detalle de Endpoints

## Listar Atracciones (GET)
Devuelve una lista de todas las atracciones turísticas disponibles.

```http
GET /api/atraccion
```
Response
```json
[
     {
        "id": 5,
        "name": "Torre de Londres",
        "location": "London EC3N 4AB",
        "price": "34.80",
        "path_img": "images/66fdb1fa945f8.jpg",
        "description": "La Torre de Londres es uno de los monumentos históricos.....",
        "open_time": "09:00:00",
        "close_time": "17:30:00",
        "website": "https://www.hrp.org.uk/tower-of-london/",
        "country": {
            "id": 1,
            "name": "Inglaterra",
            "language": "Inglés",
            "currency": "Libra Esterlina (£)"
        }
    },
    {
        "id": 2,
        "name": "Chichén Itzá",
        "location": "Chichén Itzá, 97751 Yucatán",
        "price": "0.00",
         ...
     },
     ...
]
```
### Parámetros de consulta
A continuación, se detallan los parámetros disponibles para ordenar, paginar y filtrar los resultados en la API de atracciones turísticas.

Si los parámetros `order`, `sort`, `page`, o `limit` no se especifican o están incompletos, se aplicarán valores por defecto.

### Orden
Puedes ordenar los resultados por cualquier columna `name` `location` `description` `open_time` `close_time` `website` `country` (Nombre del Pais) y especificar el orden ascendente o descendente. Si no se setean los parametros `sort` y `order` se devuelve la lista de atracciones ordenadas por `id` de forma ascendente. 

```http
GET /api/atraccion?sort={columna}&order={valor}
```

  | Parámetro  | Ejemplo     | Descripción | Valor por defecto |
  |----------  |----------   |----------|----------|
  | `sort`     | sort=name | Ordena los resultados por la columna especificada en `{columna}` de la tabla.| id |
  | `order`    | order=desc  | Especidfica el sentido del orden. Valores permitidos: `asc` (ascendente) o `desc` (descendente).| asc |

### Paginación
Permite limitar la cantidad de resultados por página y seleccionar la página deseada. El valor por defecto del limite se utiliza cuando se setea el parametro `page`.

```http
GET /api/atraccion?page={valor}&limit={valor}
```

  | Parámetro | Ejemplo | Descripción | Valor por defecto |
  |----------|----------|----------|----------|
  | `page`    |  page=2   | Número de página que se desea mostrar.| |
  | `limit`    | limit=3   | Cantidad de atracciones por página.| 5 |

### Filtrado
Puedes filtrar los resultados por una o varias de algunas de las siguientes columnas: `name` `location` `description` `open_time` `close_time` `website` `country` (Nombre del Pais)

```http
GET /api/atraccion?{campo}={valor}
```
  | Parámetro |  Ejemplo | Descripción | Valor por defecto |
  |----------|----------|----------|----------|
  | `{campo}` `{valor}`   |  name=Big Ben  | Columna y valor de la tabla por la cual se desea filtrar.| "" (sin valor) |

A continuación, un ejemplo de cómo combinar todos los parámetros de consulta en una sola solicitud:

```http
GET /api/atraccion?price=10.00&sort=name&order=asc&page=1&limit=3
``` 

## Obtener Atracción (GET)
Obtiene los detalles de una atracción específica mediante su ID.

```http
GET /api/atraccion/:id
```
Response
```json
{
    "id": 2,
    "name": "Chichén Itzá",
    "location": "Chichén Itzá, 97751 Yucatán",
    "price": "0.00",
    "path_img": "images/imagen-no-disponible.png",
    "description": "Chichén Itzá, ubicada en la península de Yucatán, .....................",
    "open_time": "08:00:00",
    "close_time": "17:00:00",
    "website": "https://www.inah.gob.mx/zonas/146-zona-arqueologica-de-chichen-itza",
    "country": {
        "id": 15,
        "name": "Mexico",
        "language": "Español",
        "currency": "Peso Mexicano ($)"
    }
}
```

### Crear Atracción (POST)
Crea una nueva atracción. ⚠️ Requiere autenticación.

```http
POST /api/atraccion
```
Request Body
```json
{
    "name": "La Movediza",
    "location": "Buenos Aires, Tandil",
    "price": "00.00",
    "path_img": "C:\\Documentos\\Imagenes\\LaMovediza.png",
    "description": "Una piedra que se cayo y pusieron una replica",
    "open_time": "09:00:00",
    "close_time": "23:00:00",
    "website": "https://www.laMove.com.ar",
    "country_id": 2
}
```
  >[!NOTE]
  > **El campo `path_img` es opcional. Si se omite, se asignará una imagen predeterminada.**

  >[!NOTE]
  > **Es necesario un `country_id` válido de la base de datos.**


## Editar Atracción (PUT)
Edita los datos de una atracción existente mediante su ID. ⚠️ Requiere autenticación.

```http
PUT /api/atraccion/:id
```
Request Body
```json
{
    "name": "La Movediza",
    "location": "Buenos Aires, Tandil",
    "price": "00.00",
    "path_img": "C:\\Documentos\\Imagenes\\LaMovediza.png",
    "description": "Una piedra que se cayo y pusieron una replica",
    "open_time": "09:00:00",
    "close_time": "23:00:00",
    "website": "https://www.laMove.com.ar",
    "country_id": 2
}
```
  >[!NOTE]
  > **Si `path_img` se omite, se conservará la imagen existente.**

  >[!NOTE]
  > **Nota: Es necesario un `country_id` válido de la base de datos.**

## Obtener Token (POST)
Genera un token de autenticación mediante credenciales de usuario.

```http
POST /api/user/token
```
Credenciales (Basic Auth)

Los datos requeridos para la generacion del mismo se deberan completar en los campos que ofrece Authorization, Type: Basic Auth. 
- `username` webadmin
- `password` admin

Response

Token para autenticación en los endpoints `POST` y `PUT`
```json
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoid2ViYWRtaW4iLCJyb2LCJpYXQiOjE3MzA5........."
```

