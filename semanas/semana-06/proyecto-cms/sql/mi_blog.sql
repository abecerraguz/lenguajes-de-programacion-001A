-- =========================================================
-- Dump compatible para XAMPP / MariaDB 10.4 (MySQL antiguo)
-- Base: mi_blog
-- Charset: utf8mb4
-- Collation: utf8mb4_general_ci (compatible)
-- =========================================================

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;

-- (Opcional pero recomendado para alumnos)
-- CREATE DATABASE IF NOT EXISTS mi_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE mi_blog;

-- ---------------------------------------------------------
-- Tabla: users (primero, porque posts tiene FK a users)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `users` WRITE;
ALTER TABLE `users` DISABLE KEYS;

INSERT INTO `users` VALUES
(1,'pgonza','pedrogonza@gmail.com','$2y$10$4zCQ9uPeg0MXCt1GlCC5turEtuiIPuLZdV1FSZVHc88rwulr87d9W','Pedro Gonzáles'),
(6,'abecerraguz','abecerraguz@gmail.com','$2y$10$eihYt.fQLmdojLlMpQdeB..ooqpw81ynASSwXij42cqLCvqpPv94q','Alejandro Becerra'),
(7,'conybecerra','cony@gmail.com','$2y$10$NmAvJWrejpb3ia76Bx/1lOS38wSurQs5XLIwr8rlDUfBSdMRSVKsS','Constanza Becerra');

ALTER TABLE `users` ENABLE KEYS;
UNLOCK TABLES;

-- ---------------------------------------------------------
-- Tabla: posts
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int DEFAULT NULL,
  `publish_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `excerpt` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `posts` WRITE;
ALTER TABLE `posts` DISABLE KEYS;

INSERT INTO `posts` VALUES
(4,'La NO formaciónnnnnnnn','<p class=\"c-paragraph\">Pega completo con Gohan en el futuro apocal&iacute;ptico de los androides N&uacute;mero 17 y N&uacute;mero 18, de la Patrulla Roja. Aunque &eacute;l no es el que viaja al pasado (lo hace Trunks) pudo ser el encargado de realizar este viaje en el tiempo, que habr&iacute;a generado un impacto brutal en el resto de los Guerreros Z.</p>\r\n<p class=\"c-paragraph\">&ldquo;Creamos a este Cable Gohan del futuro siguiendo la l&iacute;nea de las anteriores colaboraciones en crossover que hemos tenido de X-Men y Dragon Ball. Esta sali&oacute; a la luz despu&eacute;s de unos sucesos chistosos y a la vez que lastimaron nuestros corazones de machos jajajaja (los implicados entender&aacute;n). Esperamos y les guste tanto como a nosotros&rdquo;, dijeron los dos ilustradores en un posteo en conjunto que muestra el trabajo</p>',1,'2026-02-11 21:43:55','<p><a href=\"https://www.fayerwayer.com/entretenimiento/2024/06/20/la-cuenta-oficial-de-dragon-ball-super-sube-imagenes-sospechosas-del-nuevo-anime-y-pone-en-alerta-a-los-fanaticos/\" target=\"_blank\" rel=\"noopener\"><strong>El arte y la imaginaci&oacute;n&nbsp;</strong></a>de los ilustradores vuela cuando esas mentes brillantes se ponen a pensar. Combinar personajes de distintas series por parecidos f&iacute;sicos y por caracter&iacute;sticas es una de las mejores formas de&nbsp;<a href=\"https://www.fayerwayer.com/entretenimiento/2024/06/17/dragon-ball-anuncia-su-presencia-en-la-comic-con-de-san-diego-2024-que-anuncios-debemos-esperar/\" target=\"_blank\" rel=\"noopener\"><strong>homenajear a dos aventuras completamente diferentes.</strong></a></p>'),
(21,'Botón de acción del iPhone: todo lo que puedes hacer con una simple configuración','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere mi sollicitudin ullamcorper convallis. Praesent justo augue, tempor et nulla et, convallis blandit nisl. Pellentesque in diam pellentesque, tempor dui sed, malesuada metus. Phasellus lacinia urna luctus, tristique risus at, dignissim sapien. Maecenas quis lectus gravida</p>',1,'2025-02-05 01:17:24','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere mi sollicitudin ullamcorper convallis. Praesent justo augue, tempor et nulla et, convallis blandit nisl. Pellentesque in diam pellentesque, tempor dui sed, malesuada metus. Phasellus lacinia urna luctus, tristique risus at, dignissim sapien. Maecenas quis lectus gravida</p>'),
(25,'Tercera verificación de WhatsApp: ¿Qué nos va a alertar este tick azul extra?','<p>hehetheethe</p>',1,'2024-06-27 04:00:28','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere mi sollicitudin ullamcorper convallis. Praesent justo augue, tempor et nulla et, convallis blandit nisl. Pellentesque in diam pellentesque, tempor dui sed, malesuada metus. Phasellus lacinia urna luctus, tristique risus at, dignissim sapien. Maecenas quis lectus gravida</p>'),
(28,'iPhone se actualiza a iOS 18.3: Todas las novedades que llegan con el nuevo sistema operativo de Apple','<p>El sistema operativo<a href=\"https://www.fayerwayer.com/moviles/2025/01/13/boton-de-accion-del-iphone-todo-lo-que-puedes-hacer-con-una-simple-configuracion/\" target=\"_blank\" rel=\"noopener\"><strong>&nbsp;iOS 18.3&nbsp;</strong></a>ya se encuentra disponible para todos los usuarios de&nbsp;<a href=\"https://www.apple.com/cl/\" target=\"_blank\" rel=\"noopener\"><strong>iPhone</strong></a>. La actualizaci&oacute;n les deber&iacute;a aparecer a modo de notificaci&oacute;n en sus celulares, para que la realicen en el momento que crean m&aacute;s oportuno. Si no les aparece, o si por accidente eliminaron el aviso, en este mismo informe les explicamos c&oacute;mo realizarla de manera manual, para que puedan disfrutar de todas las novedades de&nbsp;<strong>Apple</strong>.</p>\r\n<p class=\"c-paragraph\">Una de las novedades m&aacute;s importantes de esta nueva actualizaci&oacute;n, es la implementaci&oacute;n autom&aacute;tica de&nbsp;<strong>Apple Intelligence</strong>, que se activa de forma inmediata cuando actualicen. Esto aplica para quienes tengan desde&nbsp;<a href=\"https://www.fayerwayer.com/moviles/2024/12/17/apple-queda-sorprendido-al-revelar-cual-fue-la-aplicacion-mas-descargada-para-iphone-en-2024/\" target=\"_blank\" rel=\"noopener\"><strong>iPhone 15 para arriba.</strong></a></p>\r\n<div id=\"standard_3\" class=\"st-placement standard_3 inArticle\"></div>\r\n<p class=\"c-paragraph\">Eso no significa que quienes tengan versiones anteriores de iPhone no reciben la actualizaci&oacute;n. Simplemente que algunas de las funciones de la inteligencia artificial de Apple s&oacute;lo est&aacute;n disponibles con un modelo de procesador o chipset m&aacute;s avanzado.</p>',1,'2025-01-30 00:38:15','<p class=\"c-heading b-subheadline\">Te explicamos c&oacute;mo hacer la actualizaci&oacute;n de manera manual, si todav&iacute;a no te aparece la notificaci&oacute;n en tu iPhone.</p>'),
(36,'Test 2026','<p>rjrjrtjrtjrtjrtjrtjrtjrtjr</p>',1,'2026-02-04 21:44:14','<p>htrrtjrtjrtjrtjrtjrt</p>'),
(38,'Prueba 20266666','<p>heherhererh</p>',1,'2026-02-11 21:48:15','<p>greherherherherherher</p>');

ALTER TABLE `posts` ENABLE KEYS;
UNLOCK TABLES;

-- ---------------------------------------------------------
-- Restaurar settings
-- ---------------------------------------------------------
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
SET SQL_NOTES=@OLD_SQL_NOTES;

-- Dump completed
