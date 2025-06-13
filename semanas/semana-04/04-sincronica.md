# Semana 4: Realizando consultas SQL para trabajar con BBDD
```sql
/*

CRUD
El acrónimo CRUD se refiere a las operaciones básicas utilizadas en la gestión de bases de datos y sistemas de información. Cada letra representa una de las cuatro operaciones principales:

Create (Crear)
Read (Leer)
Update (Actualizar)
Delete (Eliminar)

*/

-- Filtrando información
/*

URL Para practicar
https://www.programiz.com/sql/online-compiler/


Customer (Clientes)
Orders (Pedidos)
Shippings (Envíos)


*/

SELECT * FROM Customers;
SELECT * FROM Customers WHERE first_name="John";
SELECT * FROM Customers WHERE last_name LIKE 'R%';
SELECT * FROM Customers WHERE age > 21;
SELECT * FROM Customers WHERE age < 28;
SELECT * FROM Customers WHERE age != 28;
SELECT * FROM Customers WHERE age >= 28;
SELECT * FROM Customers WHERE age <= 28;
SELECT first_name FROM Customers ORDER BY first_name ASC;
SELECT first_name FROM Customers ORDER BY first_name DESC;

SELECT first_name,last_name
FROM Customers
WHERE country LIKE 'USA'
ORDER BY first_name DESC;


INSERT INTO customers ( customer_id, first_name, last_name, age, country )
VALUES (6, 'Pedro', 'Rojas', '40', 'MX');


UPDATE customers
SET first_name = 'Juan'
WHERE customer_id = 6;

DELETE FROM customers
WHERE customer_id = 6;


SELECT customers.*, orders.*, shippings.*
FROM customers
JOIN orders ON customers.customer_id = orders.customer_id
JOIN shippings ON orders.customer_id = shippings.customer
WHERE status="Pending" OR status="Delivered";

SELECT customers.*, orders.*, shippings.*
FROM customers
JOIN orders ON customers.customer_id = orders.customer_id
JOIN shippings ON orders.customer_id = shippings.customer
WHERE status="Pending" OR status="Delivered";


------------------------------------------------------------------

CREATE DATABASE cms_blog;

-- Crear la tabla de usuarios
CREATE TABLE cms_usuarios (
    u_id INT PRIMARY KEY AUTO_INCREMENT,
    u_nombre VARCHAR(20) NOT NULL,
    u_username VARCHAR(10) UNIQUE NOT NULL,
    u_password VARCHAR(32) NOT NULL
);

-- Crear la tabla de artículos
CREATE TABLE cms_articulos (
    a_id INT PRIMARY KEY AUTO_INCREMENT,
    a_titulo VARCHAR(100) NOT NULL,
    a_autor INT NOT NULL,
    a_fecha DATETIME NOT NULL,
    a_resumen VARCHAR(200) NOT NULL,
    a_texto TEXT NOT NULL,
    FOREIGN KEY (a_autor) REFERENCES cms_usuarios(u_id) ON DELETE CASCADE
);


INSERT INTO cms_usuarios  (u_nombre, u_username, u_password)
VALUES 
    ('Juan Pérez', 'jperez', 'hash1'),
    ('María González', 'mrojas', 'hash2'),
    ('Pedro Ramírez', 'pramirez', 'hash3');

INSERT INTO cms_articulos (a_titulo, a_autor, a_fecha, a_resumen, a_texto)
VALUES 
    ('Título del Artículo 1', 1, '2025-01-18', 'Resumen del Artículo 1', 'Contenido del Artículo 1'),
    ('Título del Artículo 2', 2, '2025-01-19', 'Resumen del Artículo 2', 'Contenido del Artículo 2'),
    ('Título del Artículo 3', 2, '2025-01-20', 'Resumen del Artículo 3', 'Contenido del Artículo 3');


UPDATE cms_articulos
SET 
    a_titulo = 'Nuevo Título del Artículo 1',
    a_resumen = 'Nuevo Resumen del Artículo 1'
WHERE 
    a_id = 1;


DELETE FROM cms_articulos
WHERE a_id = 3;


-- JOIN
SELECT 
    cms_articulos.a_titulo AS Título,
    cms_usuarios.u_nombre AS Autor,
    cms_articulos.a_fecha AS Fecha
FROM 
    cms_articulos
INNER JOIN 
    cms_usuarios
ON 
    cms_articulos.a_autor = cms_usuarios.u_id;

```
# RESUMEN DE JOIN
![Ejemplo de JOIN](join.jpeg)