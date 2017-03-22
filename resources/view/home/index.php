<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <ul>
            <li><a href="<?php echo $container->router->pathFor('chamadosGet'); ?>">Chamados</a></li>
            <?php if($_SESSION['grupo_admin'] == 1): ?>
                <li><a href="<?php echo $container->router->pathFor('usuariosGet'); ?>">Usuários</a></li>
                <li><a href="<?php echo $container->router->pathFor('gruposGet'); ?>">Grupos</a></li>
            <?php endif; ?>
        </ul>
    </body>
</html>