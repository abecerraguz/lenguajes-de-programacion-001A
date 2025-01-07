<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platilla de Blog</title>
    <!-- Javascript Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="../assets/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <!-- Inicio del header -->
    <header>
        <nav class="navbar">
            <div class="container containerNavAdmin">

                <a class="navbar-brand text-uppercase" href="http://localhost/01-sumativa/proyecto-cms/admin/admin_listado.html">
                    <img src="../assets/img/blog.png" alt="" width="50">
                    <span> Publicaciones </span>
                </a>

                <a class="navbar__registrarse" href="index.html"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>

            </div>
        </nav>
    </header>
    <!-- Cierre del header -->
    <main class="container">

        <h1>Administrador de publicaciones</h1>

        <div class="row">
            <div
                class="col-12 d-flex justify-content-between align-items-center mt-5 mb-3 border-bottom border-dark-subtle">
                <div class="d-flex justify-content-between align-items-center info__user"><i
                        class="bi bi-arrow-right-circle"></i><span>Bienvenido, usuario1!</span></div>
                <a href="admin_insertar.html" class="btn-secondary"><i class="bi bi-plus-circle me-2"></i>Nueva publicación</a>
                <!-- <a href="#" class="btn-secondary" data-bs-toggle="modal" data-bs-target="#nuevaPublicacion"><i class="bi bi-plus-circle me-2"></i>Nueva publicación</a> -->
            </div>
        </div>
        <div class="wrapperTable">
            <table class="">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  

                <?php
                        $publicaciones = [

                            [
                                "id" => 1,
                                "titulo" => "Hola Angewomon de Digimon cobra vida como un personaje real en esta brutal versión que hace la inteligencia artificial",
                                "fecha"  => "2024-01-05 13:18:32"
                            ],
                            [
                                "id" => 2,
                                "titulo" => "Este cosplay del Androide 20 de Dragon Ball Z es tan increíble que parece imposible de replicar",
                                "fecha"  => "2023-12-21 15:24:13"
                            ],
                            [
                                "id" => 3,
                                "titulo" => "Ésta es la mini serie de suspenso que te sacará de tu zona de confort si estás harta de lo mismo",
                                "fecha"  => "2024-01-05 13:18:32"
                            ],
                            [
                                "id" => 4,
                                "titulo" => "¡Anímate a imaginar!: Este fin de año construye tu videojuego favorito con los sets de LEGO®",
                                "fecha"  => "2024-01-05 13:18:32"
                            ]

                            ];

                        // var_dump($publicaciones);

                        function parImpar($numero){
                            // if($numero % 2 == 0){
                            //     return ' class="par"';
                            // }else{
                            //     return ' class="impar"';
                            // }
                            return $numero % 2 == 0 ? ' class="par"' : ' class="impar"';
                        }

                        foreach ($publicaciones as $publicacion) {
                            echo "<tr ".parImpar($publicacion['id']).">";
                            echo "<td>{$publicacion['id']}</td>
                           <td>{$publicacion['titulo']}</td>
                           <td>{$publicacion['fecha']}</td>
                        <td>
                            <div class='buttonAction'>
                                <a href='admin_editar.html' class='btn-edit'><i class='bi bi-pencil-square me-1'></i>Editar</a>
                                <a href='#' class='btn-edit' data-bs-toggle='modal' data-bs-target='#editarPublicacion'><i class='bi bi-pencil-square me-1'></i>Editar</a> 
                                <a href='#' class='btn-delete' data-bs-toggle='modal' data-bs-target='#eliminarPublicacion'><i class='bi bi-x-circle me-1'></i>Eliminar</a>
                            </div>
                        </td>";
                        }
                
                ?>
                <!-- <tr>
                        <td>1</td>
                        <td>Hola Angewomon de Digimon cobra vida como un personaje real en esta brutal versión que hace
                            la
                            inteligencia artificial</td>
                        <td>2024-01-05 13:18:32</td>
                        <td>
                            <div class="buttonAction">
                                <a href="admin_editar.html" class="btn-edit"><i class="bi bi-pencil-square me-1"></i>Editar</a>
                                <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editarPublicacion"><i class="bi bi-pencil-square me-1"></i>Editar</a> 
                                <a href="#" class="btn-delete" data-bs-toggle="modal" data-bs-target="#eliminarPublicacion"><i class="bi bi-x-circle me-1"></i>Eliminar</a>
                            </div>
                        </td>
                </tr> -->



                    <!-- <tr>
                        <td>2</td>
                        <td>Este cosplay del Androide 20 de Dragon Ball Z es tan increíble que parece imposible de replicar</td>
                        <td>2023-12-21 15:24:13</td>
                        <td>
                            <div class="buttonAction">
                                <a href="#" class="btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editarPublicacion-31"><i
                                        class="bi bi-pencil-square me-1"></i>Editar</a>
                                <a href="#" class="btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#eliminarPublicacion-31"><i
                                        class="bi bi-x-circle me-1"></i>Eliminar</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Ésta es la mini serie de suspenso que te sacará de tu zona de confort si estás harta de lo mismo</td>
                        <td>2023-12-21 15:25:08</td>
                        <td>
                            <div class="buttonAction">
                                <a href="#" class="btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editarPublicacion-32"><i
                                        class="bi bi-pencil-square me-1"></i>Editar</a>
                                <a href="#" class="btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#eliminarPublicacion-32"><i
                                        class="bi bi-x-circle me-1"></i>Eliminar</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>¡Anímate a imaginar!: Este fin de año construye tu videojuego favorito con los sets de LEGO®</td>
                        <td>2023-12-27 01:17:04</td>
                        <td>
                            <div class="buttonAction">
                                <a href="#" class="btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editarPublicacion-38"><i
                                        class="bi bi-pencil-square me-1"></i>Editar</a>
                                <a href="#" class="btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#eliminarPublicacion-38"><i
                                        class="bi bi-x-circle me-1"></i>Eliminar</a>
                            </div>
                        </td>
                    </tr>   -->



                </tbody>
            </table>
        </div>


    </main>

    <!-- Modales  -->
    <!--Modal nueva publicacion-->
    <div class="modal fade" id="nuevaPublicacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nueva Publicación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="new-post.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Ingrese titulo"
                                required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Ingrese resumen de la publicación"
                                name="excerpt" id="excerpt" style="height: 100px"></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control content" placeholder="Ingrese descripción de la publicación"
                                name="content" id="content" style="height: 200px"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="imagen" id="imagen"
                                placeholder="Ingrese titulo" required>
                        </div>
                        <div class='d-grid gap-2'>
                            <input type="submit" class="btn btn-secondary" value="Guardar la publicación">
                        </div>
                     
                        <!-- <button type="submit" name="submit" id="submit" class="btn btn-primary">Enviar</button> -->
                    </form>
                </div>
                <div class="modal-footer">
             
                </div>
            </div>
        </div>
    </div>
    <!--Cierre Modal nueva publicacion-->

    <!-- Editar Publicacion -->
    <div class='modal fade' id='editarPublicacion' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
        aria-labelledby='staticBackdropLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='staticBackdropLabel'>Editar Publicación</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <form action='#' method='post' enctype='multipart/form-data'>
                        <div class='mb-3'>
                            <label for='title' class='form-label'>Editar título</label>
                            <input type='text' class='form-control' name='title' id='title'
                                value="Hola Angewomon de Digimon cobra vida como un personaje real en esta brutal versión que hace la inteligencia artificial">
                        </div>
                        <hr>
                        <div class='mb-3'>
                            <label for='imagePreview' class='form-label'>Imagen actual</label>
                            <img id='imagePreview' src="../assets/img/xgames-atd-013020-2-1024x768.jpg"" alt='Titulo del post' class='sectionBlog__img-details-form'>
                        </div>
                        <hr>
                        <div class='mb-3'>
                            <label for='excerpt' class='form-label'>Editar resumen</label>
                            <textarea class='form-control' name='excerpt' id='excerpt' style='height: 100px'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ac dolor pharetra, pretium augue non, facilisis elit. Nunc commodo volutpat quam et dictum. Cras dictum purus ac imperdiet molestie. Integer pretium sem a tincidunt euismod. Donec auctor suscipit suscipit. Sed pulvinar orci turpis, eu efficitur risus dapibus quis. Proin tellus diam, hendrerit quis maximus et, convallis non odio. Maecenas pretium at leo sed consequat.</textarea>
                        </div>
                        <hr>
                        <div class='mb-3'>
                            <label for='content' class='form-label'>Editar contenido</label>
                            <textarea class='form-control content' placeholder='Ingrese descripción de la publicación'
                                name='content' id='content' style='height: 200px'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ac dolor pharetra, pretium augue non, facilisis elit. Nunc commodo volutpat quam et dictum. Cras dictum purus ac imperdiet molestie. Integer pretium sem a tincidunt euismod. Donec auctor suscipit suscipit. Sed pulvinar orci turpis, eu efficitur risus dapibus quis. Proin tellus diam, hendrerit quis maximus et, convallis non odio. Maecenas pretium at leo sed consequat.

                                Etiam et mauris nec enim posuere sodales sed aliquet sapien. Morbi erat nulla, egestas nec tellus ac, ultricies pellentesque velit. Praesent sed velit non metus aliquam interdum at nec metus. Vestibulum consequat ultricies porttitor. Duis posuere mi eros, ac ultricies quam consectetur id. Aliquam lobortis nibh lectus, a pretium justo sollicitudin non. Proin sagittis ex urna, scelerisque feugiat lacus pharetra ut. Aliquam eu tristique urna, id scelerisque elit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum orci mauris, imperdiet at ipsum nec, auctor consectetur magna. Nullam suscipit mi a lectus tempus placerat. Mauris nec nisi eget enim faucibus consectetur. Sed a facilisis nisl. Nulla imperdiet, nulla vitae gravida fringilla, neque orci laoreet dolor, congue molestie erat dui non nibh. Suspendisse quis lacus purus.
                                
                                Mauris auctor, ante non venenatis sagittis, tortor magna consequat ante, vitae consectetur risus augue ac erat. Maecenas ac metus leo. Proin tincidunt erat sed odio suscipit aliquet. Praesent elit metus, accumsan id laoreet ut, ultricies a nisl. Curabitur egestas ipsum a orci viverra dignissim. Quisque in orci nec neque ultrices elementum quis quis risus. Etiam non faucibus massa. Vestibulum eget hendrerit magna. Nam imperdiet, nisl at efficitur viverra, quam eros iaculis augue, id finibus mauris odio sit amet dui. Nam dapibus nec sem blandit suscipit. Aliquam viverra commodo justo ac pellentesque. Nullam non nisi et nisl semper scelerisque. Sed vel nunc varius, laoreet sem id, facilisis urna. Sed tellus orci, consequat eu imperdiet ut, varius sit amet massa. Nunc et mi porttitor, efficitur dui vel, bibendum tellus. Ut feugiat finibus velit vitae blandit.
                                
                                Suspendisse vulputate feugiat erat, ac tincidunt tellus scelerisque id. Morbi luctus dolor et elit porttitor, in accumsan sem sodales. Mauris at placerat ante. Integer iaculis dolor eu accumsan ultricies. Aenean a imperdiet nibh. Vivamus tempus id metus eget sagittis. Pellentesque ac lorem in augue maximus malesuada non quis nulla.
                                
                                Integer fermentum, nisi vitae egestas elementum, magna massa viverra tortor, a pulvinar dolor magna quis ante. Nam nisi ipsum, elementum auctor turpis quis, varius aliquet nisi. Nunc convallis nunc dui, non lobortis urna tempus at. Vestibulum non suscipit dui. Pellentesque non condimentum nulla. Ut quis egestas lacus. Ut ut tempor odio, eu gravida libero. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam vitae auctor est, vel congue neque. Ut et ultrices neque. In in arcu lorem. Duis eu arcu ex. Phasellus consequat suscipit velit. Sed a mi pretium libero iaculis aliquam ut eget est.</textarea>
                        </div>
                        <hr>
                        <div class='mb-3'>
                            <label for='imagen' class='form-label'>Cambiar imágen</label>
                            <input type='file' class='form-control' name='imagen' id='imagen'
                                placeholder='Ingrese titulo'>
                        </div>
                        <div class='d-grid gap-2'>
                            <button type='submit' class='btn btn-secondary' name='idPost'>Actualizar publicación</button>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>

                </div>
            </div>
        </div>
    </div>

    <!-- Javascript Bootstrap 5.3.2 -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../assets/js/main.js"></script>

</body>

</html>