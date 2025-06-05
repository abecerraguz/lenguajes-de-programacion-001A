# Experiencia de Aprendizaje 2: Aplicando PHP para realizar interacciones con la base de datos.
## Semana 3
![Modelo Cliente servidor](../assets/img/modelo-cliente-servidor-php.png)

# ¿Qué es MySQL?

MySQL es un **sistema de gestión de bases de datos relacional** (RDBMS, por sus siglas en inglés) que utiliza **SQL** (Structured Query Language) como lenguaje principal para gestionar y manipular datos. Es uno de los sistemas de bases de datos más populares del mundo, conocido por ser **rápido, confiable y fácil de usar**.

## Características principales de MySQL:
1. **Base de datos relacional**: Organiza los datos en tablas con filas y columnas, lo que permite establecer relaciones entre los datos.
2. **Código abierto**: Aunque tiene versiones comerciales, MySQL es de código abierto y gratuito, lo que lo hace accesible para desarrolladores y empresas.
3. **Multiplataforma**: Funciona en diversos sistemas operativos como Windows, Linux y macOS.
4. **Escalabilidad**: Puede manejar bases de datos pequeñas para proyectos individuales hasta bases de datos muy grandes utilizadas por grandes empresas.
5. **Compatibilidad**: Es compatible con múltiples lenguajes de programación como PHP, Python, Java, y más.
6. **Soporte para transacciones**: Proporciona soporte para operaciones transaccionales con características como el control de concurrencia y recuperación ante fallos.
7. **Amplio uso en aplicaciones web**: Es una parte fundamental del stack **LAMP** (Linux, Apache, MySQL, PHP/Perl/Python), utilizado para desarrollar aplicaciones web dinámicas.

## Usos comunes de MySQL:
- Almacenar y gestionar datos para sitios web y aplicaciones (por ejemplo, datos de usuarios, publicaciones, comentarios).
- Manejar bases de datos en sistemas empresariales, como sistemas de inventario, facturación o CRM.
- Generar reportes y análisis a partir de grandes volúmenes de datos.


# Tipos de datos en MySQL

En MySQL, los tipos de datos se dividen en tres categorías principales: **numéricos**, **de fecha y hora** y **de cadenas de texto**.

---

## **1. Tipos de datos numéricos**

### **Enteros**
| Tipo        | Tamaño (bytes) | Rango (con signo)                   | Rango (sin signo)                   |
|-------------|----------------|--------------------------------------|--------------------------------------|
| `TINYINT`   | 1              | -128 a 127                          | 0 a 255                              |
| `SMALLINT`  | 2              | -32,768 a 32,767                    | 0 a 65,535                           |
| `MEDIUMINT` | 3              | -8,388,608 a 8,388,607              | 0 a 16,777,215                       |
| `INT` o `INTEGER` | 4        | -2,147,483,648 a 2,147,483,647      | 0 a 4,294,967,295                    |
| `BIGINT`    | 8              | -9,223,372,036,854,775,808 a 9,223,372,036,854,775,807 | 0 a 18,446,744,073,709,551,615 |

### **Decimales y Flotantes**
| Tipo        | Tamaño (bytes) | Descripción                                     |
|-------------|----------------|-------------------------------------------------|
| `DECIMAL` o `NUMERIC` | Variable | Número exacto con precisión definida. Ejemplo: `DECIMAL(10,2)` |
| `FLOAT`     | 4 o 8          | Número de punto flotante de precisión simple.   |
| `DOUBLE` o `REAL` | 8        | Número de punto flotante de doble precisión.    |

---

## **2. Tipos de datos de fecha y hora**
| Tipo         | Formato                | Rango                            | Descripción                             |
|--------------|------------------------|-----------------------------------|-----------------------------------------|
| `DATE`       | `YYYY-MM-DD`           | 1000-01-01 a 9999-12-31          | Fecha sin hora.                         |
| `DATETIME`   | `YYYY-MM-DD HH:MM:SS`  | 1000-01-01 00:00:00 a 9999-12-31 23:59:59 | Fecha y hora combinadas.          |
| `TIMESTAMP`  | `YYYY-MM-DD HH:MM:SS`  | 1970-01-01 00:00:01 UTC a 2038-01-19 03:14:07 UTC | Marca de tiempo basada en Unix. |
| `TIME`       | `HH:MM:SS`             | -838:59:59 a 838:59:59           | Solo tiempo (horas, minutos, segundos). |
| `YEAR`       | `YYYY`                 | 1901 a 2155                      | Año en formato de cuatro dígitos.       |

---

## **3. Tipos de datos de cadenas de texto**

### **Cadenas de longitud fija**
| Tipo        | Tamaño máximo | Descripción                                         |
|-------------|---------------|-----------------------------------------------------|
| `CHAR`      | 0 a 255       | Cadena de longitud fija. Ejemplo: `CHAR(10)` crea una cadena de 10 caracteres. |

### **Cadenas de longitud variable**
| Tipo        | Tamaño máximo      | Descripción                                     |
|-------------|--------------------|-------------------------------------------------|
| `VARCHAR`   | 0 a 65,535 (dependiendo de la fila) | Cadena de longitud variable. Ejemplo: `VARCHAR(255)`. |

### **Tipos de texto**
| Tipo        | Tamaño máximo      | Descripción                                     |
|-------------|--------------------|-------------------------------------------------|
| `TINYTEXT`  | 255 caracteres     | Texto pequeño.                                  |
| `TEXT`      | 65,535 caracteres  | Texto largo.                                    |
| `MEDIUMTEXT`| 16,777,215 caracteres | Texto muy largo.                             |
| `LONGTEXT`  | 4,294,967,295 caracteres | Texto extremadamente largo.              |

### **Tipos binarios**
| Tipo         | Tamaño máximo      | Descripción                                     |
|--------------|--------------------|-------------------------------------------------|
| `BINARY`     | 0 a 255 bytes      | Similar a `CHAR`, pero almacena datos binarios. |
| `VARBINARY`  | 0 a 65,535 bytes   | Similar a `VARCHAR`, pero para datos binarios.  |
| `TINYBLOB`   | 255 bytes          | Pequeño objeto binario.                        |
| `BLOB`       | 65,535 bytes       | Objeto binario largo.                          |
| `MEDIUMBLOB` | 16,777,215 bytes   | Objeto binario muy largo.                      |
| `LONGBLOB`   | 4,294,967,295 bytes| Objeto binario extremadamente largo.           |

---

## **4. Tipos espaciales (GIS)**
| Tipo         | Descripción                                     |
|--------------|-------------------------------------------------|
| `GEOMETRY`   | Representa datos espaciales.                   |
| `POINT`      | Representa un solo punto (X, Y).               |
| `LINESTRING` | Representa una línea compuesta por varios puntos. |
| `POLYGON`    | Representa un polígono.                        |

---

# ¿Qué es una PRIMARY KEY?
- Es un identificador único para cada registro en una tabla.
- No puede contener valores duplicados ni NULL.
- Una tabla puede tener solo una PRIMARY KEY, pero puede estar compuesta por una o más columnas (clave compuesta).

# ¿Qué es una FOREIGN KEY?
- Es una columna (o conjunto de columnas) en una tabla que se utiliza para establecer una relación con la PRIMARY KEY de otra tabla.
- Garantiza la integridad referencial, es decir, los valores en la FOREIGN KEY deben coincidir con los valores de la PRIMARY KEY en la tabla relacionada.

# Ejemplo
Ejemplo:
Supongamos que tenemos una base de datos llamada  mi_tienda
Supongamos que tenemos dos tablas: users y orders.

1. Tabla users: Contiene información de los usuarios.
    -	Tiene una PRIMARY KEY llamada user_id.

2. Tabla orders: Contiene información sobre pedidos.

    -	Tiene una FOREIGN KEY llamada user_id que referencia a la PRIMARY KEY de users.

### Código SQL:

```sql

    -- Crear tabla users
    CREATE TABLE users (
        user_id INT AUTO_INCREMENT PRIMARY KEY, -- PRIMARY KEY
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL
    );

    -- Crear tabla orders
    CREATE TABLE orders (
        order_id INT AUTO_INCREMENT PRIMARY KEY, -- PRIMARY KEY
        order_date DATE NOT NULL,
        user_id INT, -- FOREIGN KEY
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    );

```

# Explicación del código:
1. En la tabla users:

    -	user_id es la PRIMARY KEY, lo que significa que cada usuario tendrá un identificador único.
    -	AUTO_INCREMENT asegura que los valores de user_id se generen automáticamente de forma incremental.

2. En la tabla orders:

    - order_id es la PRIMARY KEY.
    - user_id es una FOREIGN KEY que apunta a user_id en la tabla users.
    - La relación asegura que solo se puedan insertar valores en orders.user_id que existan en users.user_id.

### Insertar datos:
```sql
    -- Insertar usuarios en la tabla users
    INSERT INTO users (name, email) VALUES 
    ('John Doe', 'john@example.com'),
    ('Jane Smith', 'jane@example.com');

    -- Insertar pedidos en la tabla orders
    INSERT INTO orders (order_date, user_id) VALUES 
    ('2025-01-08', 1), -- user_id 1 pertenece a John Doe
    ('2025-01-09', 2); -- user_id 2 pertenece a Jane Smith

```

### Consulta de datos:

```sql
    -- Obtener los pedidos junto con los nombres de los usuarios
    SELECT orders.order_id, orders.order_date, users.name
    FROM orders
    JOIN users ON orders.user_id = users.user_id;

```

### Resultado

| order_id | order_date | name        |
|----------|------------|-------------|
| 1        | 2025-01-08 | John Doe    |
| 2        | 2025-01-09 | Jane Smith  |


# Conclusión:
- La PRIMARY KEY asegura que cada registro en una tabla sea único.
- La FOREIGN KEY crea una relación entre tablas, garantizando que los datos sean consistentes.