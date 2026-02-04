<?php
declare(strict_types=1);

require_once __DIR__ . '/class/config.php';
require_once __DIR__ . '/class/db.php';

/** Escape seguro para HTML */
function e(?string $value): string {
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$baseUrl = rtrim(APP_BASE_URL, '/');

// Conexión
$conn = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_CHARSET);

// Traer artículos + nombre del autor
$articulos = $conn->query("
  SELECT 
    a.a_id,
    a.a_titulo,
    a.a_fecha,
    a.a_resumen,
    u.u_nombre AS autor_nombre
  FROM cms_articulos a
  INNER JOIN cms_usuarios u ON u.u_id = a.a_autor
  ORDER BY a.a_fecha DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plantilla de Blog</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= e($baseUrl . '/assets/css/main.css') ?>">
</head>

<body>
<header>
  <nav class="navbar">
    <div class="container containerNavAdmin">
      <a class="navbar-brand text-uppercase" href="<?= e($baseUrl . '/') ?>">
        <img src="<?= e($baseUrl . '/assets/img/blog.png') ?>" alt="" width="50">
        <span> Publicaciones </span>
      </a>
      <a class="navbar__registrarse" href="<?= e($baseUrl . '/admin/index.html') ?>">
        <i class="bi bi-person-circle"></i> Registrarse
      </a>
    </div>
  </nav>
</header>

<main class="mt-100">
  <div class="container">
    <div class="row">

      <?php if (empty($articulos)): ?>
        <div class="col-12">
          <div class="alert alert-secondary">Aún no hay publicaciones.</div>
        </div>
      <?php endif; ?>

      <?php foreach ($articulos as $articulo): ?>
        <?php
          $id     = (int)$articulo['a_id'];
          $titulo = (string)$articulo['a_titulo'];
          $fecha  = (string)$articulo['a_fecha'];
          $resumen = (string)$articulo['a_resumen'];
          $autor  = (string)$articulo['autor_nombre'];

          // datetime en formato ISO para el atributo datetime=""
          $fechaIso = date('Y-m-d\TH:i:s', strtotime($fecha));

          // Tu BD no trae imagen, usamos placeholder
          $imgSrc = $baseUrl . '/' . ltrim(APP_PLACEHOLDER_IMG, '/');
        ?>

        <article class="sectionBlog">
          <img
            src="<?= e($imgSrc) ?>"
            alt="<?= e($titulo) ?>"
            class="sectionBlog__img"
          >

          <div class="sectionBlog__info">
            <h2 class="sectionBlog__title h4 fw-bold">
              <a href="<?= e($baseUrl . '/detalle.php?id=' . $id) ?>">
                <?= e($titulo) ?>
              </a>
            </h2>

            <div class="sectionBlog__publicacion">
              <span>
                <i class="bi bi-clock me-1"></i>
                Publicado:
                <time datetime="<?= e($fechaIso) ?>"><?= e($fecha) ?></time>
              </span>
              <span class="ms-3">
                <i class="bi bi-person me-1"></i>
                Autor: <?= e($autor) ?>
              </span>
            </div>

            <p class="sectionBlog__text"><?= e($resumen) ?></p>

            <a class="btn btn-secondary btn-sm" href="<?= e($baseUrl . '/detalle.php?id=' . $id) ?>">
              Saber más
            </a>
          </div>
        </article>

      <?php endforeach; ?>

    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3 class="text-uppercase border-bottom border-white mb-3">Contacto</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
        <p><i class="bi bi-geo-alt-fill"></i> 1234 Calle Falsa, Springfield</p>
        <p><i class="bi bi-telephone-fill"></i> 1234-5678</p>
        <p><i class="bi bi-envelope-fill"></i> contacto@gmail.com</p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="<?= e($baseUrl . '/assets/js/main.js') ?>"></script>
</body>
</html>

<?php $conn->close(); ?>
