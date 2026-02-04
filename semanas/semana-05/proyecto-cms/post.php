
<main class="mt-100">
        <div class="container">
            <div class="row">
                <?php
                        include_once('class/config.php');
                        include_once('class/db.php');
                        
                        $conn = new db( $host, $username, $password, $dbaname );
                        
                            $articulos = $conn->query('SELECT * FROM posts')->fetchAll();
                            foreach( $articulos as $articulo ){
                                echo "<article class=sectionBlog><div class=sectionBlog__info><h2 class='fw-bold h4 sectionBlog__title'><a href=#>{$articulo['title']}</a></h2><div class=sectionBlog__publicacion><span><i class='bi bi-clock me-1'></i>Publicado: <time datetime=''>{$articulo['publish_date']}</time></span></div><p>{$articulo['excerpt']}</p><a href=detalle.php?id={$articulo['post_id']} class='btn btn-secondary btn-sm'target=_self>Saber más</a></div></article>";
                            }

                        $conn->close();
                    
                ?>
            </div>
        </div>
    </main>
