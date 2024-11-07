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
Crea una nueva atracción. Requiere autenticación.

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
Edita los datos de una atracción existente mediante su ID. Requiere autenticación.

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

Token JWT para autenticación en los endpoints protegidos:
```json
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoid2ViYWRtaW4iLCJyb2xlIjoiYWRtaW4iLCJpYXQiOjE3MzA5........."
```

  >[!NOTE]
  > **Nota: Este token es requerido para los endpoints `POST` y `PUT`.**

