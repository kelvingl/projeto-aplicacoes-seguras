<html>
    <head>
        <title><?php echo $title ?: 'Listagem de Chamados'; ?></title>
    </head>
    <body>
    <a class="btn-cadastrar" href="<?php echo  $container->router->pathFor('chamadosAddGet'); ?>">Cadastrar novo</a>

    <?php if(!empty($chamados)): ?>
            <table border="1">
                <tr>
                    <td>ID</td>
                    <td>Titulo</td>
                    <td>Requerente</td>
                    <td>Setor</td>
                    <td></td>
                </tr>
                <?php foreach($chamados as $chamado): ?>
                    <tr>
                        <td><?php echo $chamado['id']; ?></td>
                        <td><?php echo $chamado['titulo']; ?></td>
                        <td><?php echo $chamado['usuario_nome']; ?></td>
                        <td><?php echo $chamado['setor']; ?></td>
                        <td>
                            <a class="btn-editar" href="<?php echo  $container->router->pathFor('chamadosEditGet', ['id' => $chamado['id']]); ?>">Editar</a>|
                            <a class="btn-excluir" href="<?php echo  $container->router->pathFor('chamadosDeleteGet', ['id' => $chamado['id']]); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </body>
</html>