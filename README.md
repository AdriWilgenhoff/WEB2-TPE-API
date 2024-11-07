# Trabajo Práctico Especial - Web 2 - 2024

## Integrantes
- Florencia Alarcos (36608008)
- Adrian Ezequiel Wilgenhoff (33356953)
 
## Temática
Atracciones Turistícas

## Documentación API
Esta API REST permite manejar el ABM de las atracciones turisticas. En el repositorio está incluido el Postman Collection para facilitar las pruebas.

### Resumen Endpoints 
|       Request         | Método |                    Endpoint                       | Status |
|-----------------------|--------|---------------------------------------------------|--------|
| Listar atracciones    | GET    | http://localhost/WEB2-TPE-API/api/atraccion       | 200    |
| Obtener atraccion     | GET    | http://localhost/WEB2-TPE-API/api/atraccion/:id   | 200    |
| Crear atraccion       | POST   | http://localhost/WEB2-TPE-API/api/atraccion       | 201    |
| Editar atraccion      | PUT    | http://localhost/WEB2-TPE-API/api/atraccion/:id   | 201    |
| Obtener token         | GET    | http://localhost/WEB2-TPE-API/api/usuarios/token  | 200    | 

### Listar Atracciones (GET)
```http
GET /api/atraccion
```
Response:
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

### Obtener Atraccion (GET)
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

### Crear Atraccion (POST)
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
  > **La key "path_img" puede omitirse y de hacerlo se asignará una imagen por defecto.**

  >[!NOTE]
  > **Este endpoint de creacion requiere estar autenticado para usarse.**

  >[!NOTE]
  > **El id del Pais debe ser alguno de los que estan en la base de datos.**


### Editar Atraccion (PUT)
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
  > **La key "path_img" puede omitirse y de hacerlo se mantiene la que tenía.**

  >[!NOTE]
  > **Este endpoint de creacion requiere estar autenticado para usarse.**

  >[!NOTE]
  > **El id del Pais debe ser alguno de los que estan en la base de datos.**

### Obtener Token (POST)
```http
POST /api/usuarios/token
```
Devuelve, de ser correctos los datos introducidos (usuario y contraseña),  un token que permite autenticarse.

Los datos requeridos para la generacion del mismo se deberan completar en los campos que ofrece Authorization, Type: Basic Auth. 
- `username`: webadmin
- `password`: admin

Response:
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoid2ViYWRtaW4iLCJyb2xlIjoiYWRtaW4iLCJpYXQiOjE3MzA5NDUxMTIsImV4cCI6MTczMDk0NTE3MiwiU2FsdWRvIjoiSG9sYSJ9.gJaYtnVp9T5a-IQE4t8YObUVJ0g2qmyjdTra0du9KFI"
  
El token generado es requerido para utilizar los request de tipo POST y PUT. 

