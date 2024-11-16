# TPE - WEB2 / BASE DE DATOS X360

## Integrantes:
 * Franco Rioyo (46.089.724)
 * Pablo Belozcar (41.167.959)

## Descripción

Desarrollamos una Api RESTful que al consumirla proporciona información sobre juegos de xbox 360.

## ENDPOINTS

### Consumir toda la tabla `game`

```http
  GET /api/game
  Respuesta: Arreglo de objetos con la tabla `game` completa.
```

| Parametro de Query | Tipo     | Descripción                      | Valores                 |
| :----------------- | :------- | :------------------------------- | :---------------------- |
| `rate`             | `string` | Opcional. Filtro de valoraciones | `positive` & `negative` |
| `orderBy`          | `string` | Opcional. Ordenes multiples      | `titulo` & `año` & `clasificacion`|
| `orden`            | `string` | Opcional. Dirección del orden    | `asc` & `desc`          |

### Consumir un item de la tabla `game` según su ID

```http
  GET /api/game/:id
  Respuesta: Objetos con llas propiedades del juego solicitado.
```

| Parametro | Tipo     | Descripcion                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int`    | **Obligatorio**. Id del juego     |

### Insertar un elemento a la tabla `game`

```http
  POST /api/game
  Respuesta: Objeto con las propiedades del juego insertado.
```

| Propiedad del body | Tipo | Descripcion                                    |
| :------------- | :------- | :--------------------------------------------- |
| `title_id`     | `string` | **Obligatorio**. Id del juego según Microsoft  |
| `pegi_class`   | `int`    | **Obligatorio**. Clasificación en sistema PEGI |
| `title`        | `string` | **Obligatorio**. Titulo del juego              |
| `year`         | `int`    | **Obligatorio**. Año de lanzamiento            |
| `genre`        | `string` | **Obligatorio**. Género del juego              |
| `devs`         | `string` | **Obligatorio**. Compañía desarrolladora       |
| `vandal_rating`| `string` | **Obligatorio**. Valoracion según Vandal       |
| `thumbnail`    | `string` | **Obligatorio**. Link de una portada del juego |

#### EJEMPLO
{
    "title_id": "555308c2",
    "pegi_class": 18,
    "title": "Assassins Creed IV: Black Flag",
    "year": 2013,
    "genre": "Accion",
    "devs": "Ubisoft",
    "vandal_rating": "9",
    "thumbnail": "https://media.vandal.net/t200/20557/201322812018_1.jpg"
}

### Modificar un elemento de la tabla `game`

```http
  PUT /api/game/:id
  Respuesta: Objeto con las propiedades actualizadas del juego modificado.
```

| Propiedad del body | Tipo | Descripcion                                    |
| :------------- | :------- | :--------------------------------------------- |
| `title_id`     | `string` | **Obligatorio**. Id del juego según Microsoft  |
| `pegi_class`   | `int`    | **Obligatorio**. Clasificación en sistema PEGI |
| `title`        | `string` | **Obligatorio**. Titulo del juego              |
| `year`         | `int`    | **Obligatorio**. Año de lanzamiento            |
| `genre`        | `string` | **Obligatorio**. Género del juego              |
| `devs`         | `string` | **Obligatorio**. Compañía desarrolladora       |
| `vandal_rating`| `string` | **Obligatorio**. Valoracion según Vandal       |
| `thumbnail`    | `string` | **Obligatorio**. Link de una portada del juego |

#### EJEMPLO
{
    "title_id": "373407d8",
    "pegi_class": 7,
    "title": "Hora de Aventuras: Finn y Jake, Investigadores",
    "year": 2015,
    "genre": "Aventura",
    "devs": "Bandai Namco",
    "vandal_rating": "6",
    "thumbnail": "https://m.media-amazon.com/images/I/81dt08wLF5L._AC_UF1000,1000_QL80_.jpg"
}

### Eliminar un item de la tabla `game` según su ID

```http
  DELETE /api/game/:id
  Respuesta: Resultado de la operación.
```

| Parametro | Tipo     | Descripcion                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int`    | **Obligatorio**. Id del juego     |
