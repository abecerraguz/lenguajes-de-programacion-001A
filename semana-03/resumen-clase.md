![Infografía](material-clase/infografia.png)
# Experiencia de Aprendizaje 2: Aplicando PHP para realizar interacciones con la base de datos.
## Semana 3
---

# ¿Qué es una Base de Datos?

Imagina una **caja organizada** donde puedes guardar información de forma ordenada: nombres, fechas, textos, imágenes. Esa caja es una base de datos.

> Una **base de datos** es una colección organizada de información que se puede almacenar, consultar y modificar de forma eficiente.

[Descargar presentación](material-clase/presentacion.pdf)

## Conceptos clave (vocabulario que debes manejar):

| Concepto | Descripción simple |
|---|---|
| **Base de datos** | El contenedor principal. Agrupa todas las tablas del proyecto |
| **Tabla** | Una hoja de cálculo con columnas y filas. Ej: tabla `articulos` |
| **Campo** (columna) | El nombre de un tipo de dato. Ej: `titulo`, `fecha`, `autor` |
| **Registro** (fila) | Un conjunto de datos completo. Ej: los datos de un artículo específico |
| **Tipo de dato** | Define qué tipo de información acepta un campo: texto, número, fecha... |
| **Clave primaria** | Un identificador único que no se puede repetir. Ej: `id = 1`, `id = 2`... |

### Ejemplo visual (tabla `cms_articulos`):

| a_id | a_titulo | a_autor | a_fecha |
|---|---|---|---|
| 1 | "Mi primer artículo" | 1 | 2026-01-05 |
| 2 | "Aprendiendo PHP" | 1 | 2026-01-10 |

Cada **fila** = un registro (un artículo). Cada **columna** = un campo.

---

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

---

# ¿Qué es phpMyAdmin?

**phpMyAdmin** es una aplicación web que te permite **administrar bases de datos MySQL de forma visual**, sin necesidad de escribir código SQL complejo.

Con phpMyAdmin puedes:
- Crear y eliminar bases de datos
- Crear tablas y definir sus campos
- Insertar, editar y borrar registros
- Exportar e importar bases de datos como archivos `.sql`

> Es la herramienta perfecta para aprender, porque ves lo que estás haciendo de forma gráfica e intuitiva.

---

# Entorno Local: XAMPP y MAMP

Para usar MySQL y phpMyAdmin en tu computador debes instalar un **servidor local**. Según tu sistema operativo:

| Sistema operativo | Herramienta | Descarga |
|---|---|---|
| Windows | **XAMPP** | https://www.apachefriends.org |
| macOS | **MAMP** | https://www.mamp.info |

## ¿Cómo iniciar el entorno?

**Paso 1** — Abre XAMPP (Windows) o MAMP (Mac) y activa los servicios:
- **Apache** → el servidor web (necesario para que phpMyAdmin cargue)
- **MySQL** → el motor de base de datos

> ⚠️ **Importante**: Apache debe estar corriendo **antes** de abrir phpMyAdmin, de lo contrario no podrá cargar.

**Paso 2** — Haz clic en el botón **Admin** de MySQL (o abre tu navegador en `http://localhost/phpmyadmin`)

Ya estás listo para trabajar con tu base de datos.

---

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

---

# Creando una Base de Datos en phpMyAdmin

## Paso a paso:

**1.** Abre phpMyAdmin en el navegador (`http://localhost/phpmyadmin`)

**2.** En el menú izquierdo, haz clic en **"Nueva"**

**3.** Escribe el nombre de tu base de datos (sin espacios, sin tildes, sin ñ):
```
mi_cms
```

**4.** Haz clic en **"Crear"**

> ✅ Ya tienes tu base de datos. Ahora hay que crearle tablas.

---

# Creando una Tabla

## Paso a paso:

**1.** Selecciona tu base de datos en el menú izquierdo

**2.** En el campo **"Nombre de la tabla"** escribe el nombre (ej: `cms_articulos`)

**3.** Define el número de columnas y haz clic en **"Crear"**

**4.** Define cada campo:

| Campo | Qué debes completar |
|---|---|
| **Nombre** | El nombre del campo (ej: `a_titulo`) |
| **Tipo** | El tipo de dato (ej: `VARCHAR`, `INT`, `TEXT`, `DATETIME`) |
| **Longitud** | El tamaño máximo (ej: `100` para VARCHAR) |
| **A_I** (Auto Increment) | Marca este check solo en el campo `id` → se convierte en PRIMARY KEY |

**5.** Haz clic en **"Guardar"**

### Reglas para nombrar campos y tablas:
- Solo letras, números y guiones bajos `_`
- Sin espacios, sin tildes, sin `ñ`, sin caracteres especiales
- Ejemplo correcto: `a_titulo`, `u_password`, `cms_articulos`

---

# Agregar Datos (Poblar la Base de Datos)

**Poblar** = llenar la tabla con datos de ejemplo para probar que todo funciona.

## Paso a paso:

**1.** Selecciona tu base de datos → selecciona la tabla

**2.** Haz clic en **"Insertar"** en el menú superior

**3.** Completa los campos con datos de prueba

> ⚠️ **El campo `id` debe ir vacío** → se llena automáticamente gracias a AUTO_INCREMENT

**4.** Haz clic en **"Continuar"**

Si aparece una barra verde: el registro fue insertado con éxito.

---

# Modificar un Registro

**1.** Selecciona la tabla → verás todos los registros listados

**2.** Haz clic en **"Editar"** (ícono de lápiz) junto al registro que quieres cambiar

**3.** Modifica los valores que necesites

**4.** Haz clic en **"Continuar"** para guardar

> ⚠️ El campo `id` **no se puede modificar** → es el identificador único e inmutable del registro.

---

# Borrar un Registro

**1.** Selecciona la tabla → ubica el registro

**2.** Haz clic en **"Borrar"** (ícono rojo)

**3.** Confirma la acción en el mensaje emergente haciendo clic en **"OK"**

> ⚠️ Esta acción es **irreversible**. Una vez borrado, no se puede recuperar.

---

# Consideraciones al Diseñar una Base de Datos

Antes de crear tablas, debes pensar bien qué información vas a guardar. Algunas reglas básicas:

### 1. Separar los datos por categoría
No mezcles todo en una sola tabla. Crea tablas específicas:
- `cms_usuarios` → solo datos de usuarios
- `cms_articulos` → solo datos de artículos

### 2. Identificar relaciones entre tablas
Un usuario puede tener muchos artículos → el campo `a_autor` en `cms_articulos` guarda el `id` del usuario que lo escribió. Así se **relacionan** las tablas.

### 3. Nombres descriptivos para los campos
Usa nombres claros que expliquen qué contiene ese campo:
- ✅ `a_titulo`, `u_nombre`, `a_fecha`
- ❌ `campo1`, `dato`, `x`

### 4. Elige bien el tipo de dato
- Texto corto → `VARCHAR`
- Texto largo → `TEXT`
- Números enteros → `INT`
- Fechas → `DATETIME` o `DATE`
- Contraseñas → `VARCHAR(32)` (para almacenar hash MD5)

---

# 🎯 Actividad Formativa — Semana 3

> **RA2 / IL4** — Prepara una base de datos MySQL en phpMyAdmin, incluyendo la creación de tablas e inserción de datos, para almacenar y gestionar la información del CMS.

## Lo que debes entregar:

### 1. Crear la base de datos
Crea una nueva base de datos en phpMyAdmin con el nombre que elijas para tu proyecto.

### 2. Crear las siguientes tablas con sus campos exactos:

**Tabla `cms_usuarios`**

| Campo | Tipo | Detalles |
|---|---|---|
| `u_id` | INT | Clave primaria (PRIMARY KEY, AUTO_INCREMENT) |
| `u_nombre` | VARCHAR | 20 caracteres |
| `u_username` | VARCHAR | 10 caracteres |
| `u_password` | VARCHAR | 32 caracteres |

**Tabla `cms_articulos`**

| Campo | Tipo | Detalles |
|---|---|---|
| `a_id` | INT | Clave primaria (PRIMARY KEY, AUTO_INCREMENT) |
| `a_titulo` | VARCHAR | 100 caracteres |
| `a_autor` | INT | Referencia al `u_id` del usuario |
| `a_fecha` | DATETIME | Fecha y hora del artículo |
| `a_resumen` | VARCHAR | 200 caracteres |
| `a_texto` | TEXT | Contenido completo del artículo |

### 3. Poblar las tablas con datos de ejemplo

Agrega al menos:
- **2 usuarios** en `cms_usuarios`
- **5 artículos** en `cms_articulos`

Los datos son de prueba, pero deben ser coherentes (un artículo debe tener un `a_autor` que exista en `cms_usuarios`).

### 4. Exportar y entregar

1. En phpMyAdmin selecciona tu base de datos
2. Ve a la pestaña **"Exportar"**
3. Elige formato **SQL** y haz clic en **"Continuar"**
4. Guarda el archivo `.sql` que se descarga
5. Comprime ese archivo en formato **`.zip`**
6. Sube el `.zip` a la plataforma

---

## Resumen del flujo de trabajo de la semana

```
Instalar XAMPP/MAMP
       ↓
Iniciar Apache + MySQL
       ↓
Abrir phpMyAdmin (localhost/phpmyadmin)
       ↓
Crear base de datos
       ↓
Crear tablas (cms_usuarios y cms_articulos)
       ↓
Agregar campos con tipos de datos correctos
       ↓
Poblar con datos de ejemplo
       ↓
Exportar como .sql → comprimir en .zip → subir a plataforma
```

---

*Última actualización: Semana 3 - Curso de Lenguajes de Programación 2026*