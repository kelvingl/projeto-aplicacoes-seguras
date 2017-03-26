<html>
<head>
    <title><?php echo $title ?: 'Listagem de Grupos'; ?></title>
    <link rel="stylesheet" href="resources/jquery-ui-1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="resources/jquery-ui-1.12.1/jquery-ui.theme.min.css" />
</head>
<body>
<div id="dialog-form" title="Adicionar/Editar usuario">
    <form id="form">
        <fieldset><input type="hidden" id="_target" disabled="disabled" />
            <label for="name">Nome</label><br>
            <input type="text" name="nome" id="nome" value="Exemplo" class="text ui-widget-content ui-corner-all">
            <br><br>
            <label for="senha">Senha</label><br>
            <input type="password" name="senha" id="senha" value="" class="text ui-widget-content ui-corner-all">
            <br><br>
            <label for="grupo">Grupo</label><br>
            <select name="grupo" id="grupo"  class="text ui-widget-content ui-corner-all">
                <?php if(!empty($grupos)): ?>
                    <?php foreach($grupos as $grupo): ?>
                        <option value="<?php echo $grupo['id']; ?>"><?php echo $grupo['nome']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

<a class="btn-cadastrar" href="#" data-href="<?php echo  $container->router->pathFor('usuariosPost'); ?>">Cadastrar novo</a>

<?php if(!empty($usuarios)): ?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Login</td>
            <td>Grupo</td>
            <td></td>
        </tr>
        <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td data-field="nome"><?php echo $usuario['nome']; ?></td>
                <td data-field="login"><?php echo $usuario['login']; ?></td>
                <?php
                    foreach($grupos as $grupo) { if($grupo['id'] == $usuario['grupo']){ $nomeGrupo = $grupo['nome']; break;}}
                ?>
                <td data-field="grupo" data-grupo="<?php echo $usuario['grupo']; ?>"><?php echo $nomeGrupo; ?></td>
                <td>
                    <a class="btn-editar" href="#" data-href="<?php echo  $container->router->pathFor('usuariosPut', ['id' => $usuario['id']]); ?>">Editar</a>|
                    <a class="btn-excluir" href="#" data-href="<?php echo  $container->router->pathFor('usuariosDelete', ['id' => $usuario['id']]); ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<script src="resources/jquery-3.2.0.min.js" type="text/javascript"></script>
<script src="resources/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="js/usuarios/add_edit.js" type="text/javascript"></script>
</body>
</html>