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
|       Request         | Método |                    Endpoint                       | Status |
|-----------------------|--------|---------------------------------------------------|--------|
| Listar atracciones    | GET    | http://localhost/WEB2-TPE-API/api/atraccion       | 200    |
| Obtener atraccion     | GET    | http://localhost/WEB2-TPE-API/api/atraccion/:id   | 200    |
| Crear atraccion       | POST   | http://localhost/WEB2-TPE-API/api/atraccion       | 201    |
| Editar atraccion      | PUT    | http://localhost/WEB2-TPE-API/api/atraccion/:id   | 201    |
| Obtener token         | GET    | http://localhost/WEB2-TPE-API/api/usuarios/token  | 200    | 

### Detalle de Endpoints

### Listar Atracciones (GET)
Devuelve una lista de todas las atracciones turísticas disponibles.

```http
GET /api/atraccion
```
Response
```json
[
    {
        "id": 1,
        "name": "Torre Eiffel",
        "location": "Av. Gustave Eiffel, 75007 Paris",
        "price": "25.00",
        "path_img": "images/66fdb1d10938c.jpg",
        "description": "La Torre Eiffel es el monumento más.....",
        "open_time": "09:00:00",
        "close_time": "23:00:00",
        "website": "https://www.toureiffel.paris",
        "country_id": 2,
        "country": "Francia"
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

### Este endpoint permite distintos tipos de querys params, asi también como su combinación.

### Parámetros 

| Parámetro    | Descripción                                     | Valor por Defecto |
|--------------|-------------------------------------------------|-------------------|
| filter       | Permite filtrar los resultados basados en un campo específico       | -                 |
| rvalue  | Valor por el cual se realiza el filtrado.       | -                 |
| sort      | Permite ordenar los resultados según un campo específico      | id                |
| order        | Tipo de ordenamiento (ascendente o descendente). | desc              |
| page         | Número de página que se desea observar.         | 1                 |
| limit        | Cantidad de registros mostrados por página.     | 4                 |

### Orden
`GET /api/atraccion?sort={valor}&order={valor}`

  | Parámetro | Tipo | Ejemplo | Descripción |
  |----------|----------|----------|----------|
  | `sort`    | String   | sort=nombre   | Valor nombre de la columna. Se realizara el ordenamientopor la columna [nombre] de la tabla.|
  | `order`    | String   | order=desc   | Valor de búsqueda. Se aplicara el ordenamiento en orden descendente. Posibles valores admitidos [asc/desc]. |

### Paginación
`GET /api/atraccion?page={valor}&limit={valor}`

  | Parámetro | Tipo | Ejemplo | Descripción |
  |----------|----------|----------|----------|
  | `page`    | String   | page=2   | Número de página a mostrar.|
  | `limit`    | String   | limit=3   | Límite de elementos mostrados por página. |

### Filtrado
`GET /api/atraccion?filter={valor}&value={valor}`
  | Parámetro | Tipo | Ejemplo | Descripción |
  |----------|----------|----------|----------|
  | `filter`    | String   | filter=nombre   | Valor nombre de la columna. Se realizara el filtro por la columna [nombre] de la tabla.|
  | `filterValue`    | String   | filterValue=Pad   | Valor de búsqueda. Se aplicara el filtro en la columna [nombre] por el valor [Pad]. |

### Valores por defecto

  Cuando se hace uso de la cadena de parametro principal filter, sort, page y estos no toman ningun valor o no se encuentra el parámetro compañero, se toman los siguientes valores por defecto. Lo mismo aplica para los parametros secundarios.

  | Parámetro | Tipo | Ejemplo | Valor por defecto |
  |----------|----------|----------|----------|
  | filter    | String   | page   | nombre |
  | filterValue    | String   | page   |  |
  | sort    | String   | sort   | id_producto |
  | order    | String   | sort   | asc |
  | page    | String   | page  | 1 |
  | limit    | String   | page  | 3 |

La combinación de todos los parámetros se encuentra disponible. Ejemplo: 

Ejemplo combinando todos los querys params: 
```
GET api/atraccion?filter=[valor]&filterValue=[valor]&sort=[valor]&oder=[valor]&page=[valor]&limit=[valor]
``` 

### Obtener Atracción (GET)
Obtiene los detalles de una atracción específica mediante su ID.

```http
GET /api/atraccion/:id
```
Response
```json
{
    "id": 3,
    "name": "Big Ben",
    "location": "London SW1A 0AA",
    "price": "0.00",
    "path_img": "images/66fdb27bb6f7b.jpg",
    "description": "El Big Ben es uno de los símbolos......",
    "open_time": "00:00:00",
    "close_time": "00:00:00",
    "website": "https://www.parliament.uk/bigben/",
    "country_id": 1,
    "country": "Inglaterra",
    "idCountry": 1,
    "currency": "Libra Esterlina (£)"
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


### Editar Atracción (PUT)
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

### Obtener Token (POST)
Genera un token de autenticación mediante credenciales de usuario.

```http
POST /api/usuarios/token
```
Credenciales (Basic Auth)

Los datos requeridos para la generacion del mismo se deberan completar en los campos que ofrece Authorization, Type: Basic Auth. 
- `username`: webadmin
- `password`: admin

Response

Token para autenticación en los endpoints `POST` y `PUT`:
```json
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoid2ViYWRtaW4iLCJyb2LCJpYXQiOjE3MzA5........."
```

