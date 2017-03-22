<html>
    <head>
        <title><?php echo $title ?: 'Listagem de Grupos'; ?></title>
        <link rel="stylesheet" href="resources/jquery-ui-1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="resources/jquery-ui-1.12.1/jquery-ui.theme.min.css" />
    </head>
    <body>
    <div id="dialog-form" title="Adicionar/Editar grupo">
        <form id="form">
            <fieldset><input type="hidden" id="_target" disabled="disabled" />
                <label for="name">Nome</label><br>
                <input type="text" name="nome" id="nome" value="Exemplo" class="text ui-widget-content ui-corner-all">
                <br>
                <label for="admin">Administrador?</label><br>
                <select name="admin" id="admin"  class="text ui-widget-content ui-corner-all">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>

    <a class="btn-cadastrar" href="#" data-href="<?php echo  $container->router->pathFor('gruposPost'); ?>">Cadastrar novo</a>

    <?php if(!empty($grupos)): ?>
            <table border="1">
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Admin?</td>
                    <td></td>
                </tr>
                <?php foreach($grupos as $grupo): ?>
                    <tr>
                        <td><?php echo $grupo['id']; ?></td>
                        <td data-field="nome"><?php echo $grupo['nome']; ?></td>
                        <td data-field="admin" data-value="<?php echo $grupo['admin'] ?>"><?php echo $grupo['admin'] ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <a class="btn-editar" href="#" data-href="<?php echo  $container->router->pathFor('gruposPut', ['id' => $grupo['id']]); ?>">Editar</a>|
                            <a class="btn-excluir" href="#" data-href="<?php echo  $container->router->pathFor('gruposDelete', ['id' => $grupo['id']]); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <script src="resources/jquery-3.2.0.min.js" type="text/javascript"></script>
        <script src="resources/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="js/grupo/add_edit.js" type="text/javascript"></script>
    </body>
</html>