# 📘 Comandos MySQL - Referencia de Consola

> Guía completa para moverse en MySQL desde la terminal.

Conexión Rápida por Terminal con Aliases
La forma más rápida es crear aliases en tu ~/.zshrc:

1. Abre tu archivo de configuración
```bash
    nano ~/.zshrc
```
2. Agrega estas dos líneas al final
```bash
    alias mysqlbrew='mysql -h 127.0.0.1 -P 3306 -u root -p'
    alias mysqlxampp='mysql -h 127.0.0.1 -P 3307 -u root -p'
    # No olvidar buscar la linea
    source <(ng completion script)
    # Remplazarla por 
    autoload -Uz compinit && compinit
```
3. Guarda y recarga
```bash
   source ~/.zshrc
```


---

## 🔌 Conexión al Servidor

```bash
# Conectarse a MySQL con Brew (puerto 3306)
mysqlbrew

# Conectarse a MySQL con XAMPP (puerto 3307)
mysqlxampp

# Conexión manual especificando todos los parámetros
mysql -h 127.0.0.1 -P 3306 -u root -p

# Conectarse directamente a una base de datos
mysql -h 127.0.0.1 -P 3306 -u root -p nombre_base_datos
```

---

## 🚪 Salir de la Consola MySQL

```sql
exit
-- o
quit
-- o
\q
```

---

## 🗄️ Bases de Datos

```sql
-- Ver todas las bases de datos
SHOW DATABASES;

-- Crear una base de datos
CREATE DATABASE mi_base_datos;

-- Crear base de datos solo si no existe
CREATE DATABASE IF NOT EXISTS mi_base_datos;

-- Seleccionar / entrar a una base de datos
USE mi_base_datos;

-- Ver en qué base de datos estás actualmente
SELECT DATABASE();

-- Eliminar una base de datos
DROP DATABASE mi_base_datos;

-- Eliminar solo si existe (evita errores)
DROP DATABASE IF EXISTS mi_base_datos;
```

---

## 📋 Tablas

```sql
-- Ver todas las tablas de la BD seleccionada
SHOW TABLES;

-- Ver la estructura de una tabla
DESCRIBE usuarios;
DESC usuarios;      -- forma corta

-- Ver el SQL con el que fue creada una tabla
SHOW CREATE TABLE usuarios;

-- Crear una tabla completa de ejemplo
CREATE TABLE usuarios (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100)  NOT NULL,
    email       VARCHAR(100)  UNIQUE NOT NULL,
    edad        INT,
    activo      BOOLEAN       DEFAULT TRUE,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- Renombrar una tabla
RENAME TABLE usuarios TO clientes;

-- Eliminar una tabla
DROP TABLE usuarios;

-- Eliminar solo si existe
DROP TABLE IF EXISTS usuarios;

-- Vaciar una tabla (borra datos pero conserva la estructura)
TRUNCATE TABLE usuarios;
```

---

## 🔧 Modificar Tablas (ALTER)

```sql
-- Agregar una columna
ALTER TABLE usuarios ADD COLUMN telefono VARCHAR(20);

-- Agregar columna en una posición específica
ALTER TABLE usuarios ADD COLUMN telefono VARCHAR(20) AFTER email;

-- Modificar el tipo de una columna
ALTER TABLE usuarios MODIFY COLUMN edad TINYINT;

-- Renombrar una columna
ALTER TABLE usuarios RENAME COLUMN edad TO years;

-- Eliminar una columna
ALTER TABLE usuarios DROP COLUMN telefono;

-- Agregar índice
ALTER TABLE usuarios ADD INDEX idx_email (email);
```

---

## 📝 Insertar Datos (INSERT)

```sql
-- Insertar un registro
INSERT INTO usuarios (nombre, email, edad)
VALUES ('Juan Pérez', 'juan@email.com', 30);

-- Insertar varios registros a la vez
INSERT INTO usuarios (nombre, email, edad) VALUES
    ('Ana García',   'ana@email.com',   25),
    ('Luis Torres',  'luis@email.com',  35),
    ('María López',  'maria@email.com', 28);
```

---

## 🔍 Consultar Datos (SELECT)

```sql
-- Ver todos los datos
SELECT * FROM usuarios;

-- Ver columnas específicas
SELECT nombre, email FROM usuarios;

-- Filtrar con WHERE
SELECT * FROM usuarios WHERE edad > 25;

-- Múltiples condiciones
SELECT * FROM usuarios WHERE edad > 25 AND activo = TRUE;

-- Buscar con LIKE (% = cualquier texto)
SELECT * FROM usuarios WHERE nombre LIKE 'Juan%';
SELECT * FROM usuarios WHERE email LIKE '%@gmail.com';

-- Ordenar resultados
SELECT * FROM usuarios ORDER BY nombre ASC;   -- A → Z
SELECT * FROM usuarios ORDER BY edad  DESC;  -- Mayor → Menor

-- Limitar resultados
SELECT * FROM usuarios LIMIT 10;

-- Limitar con offset (paginación)
SELECT * FROM usuarios LIMIT 10 OFFSET 20;   -- desde el registro 20

-- Contar registros
SELECT COUNT(*) FROM usuarios;
SELECT COUNT(*) FROM usuarios WHERE activo = TRUE;

-- Valores únicos
SELECT DISTINCT edad FROM usuarios;

-- Valor máximo, mínimo y promedio
SELECT MAX(edad), MIN(edad), AVG(edad) FROM usuarios;
```

---

## ✏️ Actualizar Datos (UPDATE)

```sql
-- Actualizar un campo
UPDATE usuarios SET edad = 31 WHERE id = 1;

-- Actualizar varios campos a la vez
UPDATE usuarios SET edad = 31, activo = FALSE WHERE id = 1;

-- Actualizar varios registros
UPDATE usuarios SET activo = FALSE WHERE edad < 18;
```

> ⚠️ **Siempre usa WHERE** en UPDATE o afectará TODOS los registros.

---

## 🗑️ Eliminar Datos (DELETE)

```sql
-- Eliminar un registro específico
DELETE FROM usuarios WHERE id = 1;

-- Eliminar varios registros con condición
DELETE FROM usuarios WHERE activo = FALSE;
```

> ⚠️ **Siempre usa WHERE** en DELETE o borrará TODOS los registros.

---

## 🔗 Relaciones entre Tablas (JOINs)

```sql
-- Crear tabla relacionada de ejemplo
CREATE TABLE pedidos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT NOT NULL,
    producto    VARCHAR(100),
    total       DECIMAL(10,2),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- INNER JOIN: solo registros que coinciden en ambas tablas
SELECT u.nombre, p.producto, p.total
FROM usuarios u
INNER JOIN pedidos p ON u.id = p.usuario_id;

-- LEFT JOIN: todos los usuarios, tengan o no pedidos
SELECT u.nombre, p.producto
FROM usuarios u
LEFT JOIN pedidos p ON u.id = p.usuario_id;
```

---

## 👤 Usuarios y Permisos

```sql
-- Ver todos los usuarios
SELECT User, Host FROM mysql.user;

-- Ver el usuario actual
SELECT USER();

-- Crear un nuevo usuario
CREATE USER 'nuevo_usuario'@'localhost' IDENTIFIED BY 'contraseña';

-- Dar todos los permisos sobre una base de datos
GRANT ALL PRIVILEGES ON mi_base_datos.* TO 'nuevo_usuario'@'localhost';

-- Aplicar cambios de permisos
FLUSH PRIVILEGES;

-- Ver permisos de un usuario
SHOW GRANTS FOR 'nuevo_usuario'@'localhost';

-- Eliminar un usuario
DROP USER 'nuevo_usuario'@'localhost';
```

---

## ⚙️ Información del Sistema

```sql
-- Ver versión de MySQL
SELECT VERSION();

-- Ver el puerto activo
SELECT @@port;

-- Ver todas las variables del sistema
SHOW VARIABLES;

-- Buscar una variable específica
SHOW VARIABLES LIKE 'max_connections';

-- Ver procesos activos
SHOW PROCESSLIST;

-- Ver el estado del servidor
STATUS;
```

---

## 🧹 Utilidades en Consola

```sql
-- Limpiar la pantalla (sin salir de mysql)
system clear;

-- Ver el historial de comandos
\!history

-- Ejecutar un archivo .sql externo
SOURCE /ruta/al/archivo.sql;
-- o también
\. /ruta/al/archivo.sql
```

---

## 📤 Exportar e Importar Bases de Datos (mysqldump)

> ⚠️ Estos comandos se ejecutan desde la **terminal de Mac**, NO desde dentro del prompt `mysql>`. Si estás dentro de MySQL, primero escribe `exit`.

### Exportar

```bash
# Exportar BD - Brew (3306)
mysqldump -h 127.0.0.1 -P 3306 -u root -p nombre_bd > backup.sql

# Exportar BD - XAMPP (3307)
mysqldump -h 127.0.0.1 -P 3307 -u root -p nombre_bd > backup.sql

# Exportar al Escritorio
mysqldump -h 127.0.0.1 -P 3306 -u root -p nombre_bd > ~/Desktop/backup.sql

# Exportar comprimido (ocupa menos espacio)
mysqldump -h 127.0.0.1 -P 3306 -u root -p nombre_bd | gzip > ~/Desktop/backup.sql.gz

# Exportar varias bases de datos a la vez
mysqldump -h 127.0.0.1 -P 3306 -u root -p \
  --databases bd1 bd2 bd3 > backup_multiple.sql

# Exportar TODAS las bases de datos
mysqldump -h 127.0.0.1 -P 3306 -u root -p \
  --all-databases > backup_todo.sql

# Exportar solo la ESTRUCTURA (sin datos)
mysqldump -h 127.0.0.1 -P 3306 -u root -p \
  --no-data nombre_bd > solo_estructura.sql

# Exportar solo los DATOS (sin estructura)
mysqldump -h 127.0.0.1 -P 3306 -u root -p \
  --no-create-info nombre_bd > solo_datos.sql

# Exportar una tabla específica
mysqldump -h 127.0.0.1 -P 3306 -u root -p \
  nombre_bd nombre_tabla > backup_tabla.sql

# Exportar con fecha en el nombre (evita sobreescribir)
mysqldump -h 127.0.0.1 -P 3306 -u root -p nombre_bd > \
  backup_$(date +%Y-%m-%d).sql
# Resultado: backup_2026-06-17.sql ✅
```

### Importar

```bash
# Importar a una base de datos existente
mysql -h 127.0.0.1 -P 3306 -u root -p nombre_bd < backup.sql

# Importar un archivo comprimido
gunzip < backup.sql.gz | mysql -h 127.0.0.1 -P 3306 -u root -p nombre_bd
```

---

## 💡 Tips Importantes

### El punto y coma `;`
Todo comando SQL debe terminar con `;` para ejecutarse.
```sql
mysql> SELECT * FROM usuarios    -- Sin ; espera más input...
    ->                           -- Sigue esperando...
    -> ;                         -- ✅ Ahora ejecuta
```

### Cancelar un comando
Si te equivocaste y no quieres ejecutar lo que escribiste:
```sql
mysql> SELECT * FROM usuarios\c    -- \c cancela el comando
mysql>
```

### Ver a qué servidor estás conectado
```sql
SELECT @@port;     -- 3306 = Brew | 3307 = XAMPP
SELECT USER();     -- muestra usuario y host
SELECT DATABASE(); -- muestra la BD seleccionada
```

---

## 📌 Comandos del día a día (Resumen rápido)

| Acción | Comando |
|---|---|
| Ver bases de datos | `SHOW DATABASES;` |
| Entrar a una BD | `USE nombre_bd;` |
| Ver tablas | `SHOW TABLES;` |
| Ver estructura tabla | `DESC nombre_tabla;` |
| Ver datos | `SELECT * FROM tabla;` |
| Insertar | `INSERT INTO tabla (col) VALUES (val);` |
| Actualizar | `UPDATE tabla SET col=val WHERE id=1;` |
| Eliminar registro | `DELETE FROM tabla WHERE id=1;` |
| Puerto actual | `SELECT @@port;` |
| Salir | `exit` |
| Exportar BD | `mysqldump ... nombre_bd > archivo.sql` |
| Exportar comprimido | `mysqldump ... nombre_bd \| gzip > archivo.sql.gz` |
| Solo estructura | `mysqldump --no-data ...` |
| Solo datos | `mysqldump --no-create-info ...` |
| Importar BD | `mysql ... nombre_bd < archivo.sql` |
