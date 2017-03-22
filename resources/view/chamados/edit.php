<html>
<head>
    <title><?php echo $title ?: 'Listagem de Chamados'; ?></title>
</head>
<body>
    <form method="POST" action="<?php echo $container->router->pathFor('chamadosEditPost', ['id' => $chamado['id']]); ?>">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><?php echo $chamado['id']; ?></td>
            </tr>
            <tr>
                <td>Responsável</td>
                <td>
                    <select name="usuario" style="display: inline-block; width: 100%;">
                        <?php foreach($usuarios as $usuario): ?>
                            <option value="<?php echo $usuario['id']; ?>" <?php echo $usuario['id'] == $chamado['usuario'] ? 'selected' : ''; ?>><?php echo $usuario['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
            </tr>
            <tr>
                <td>Título</td>
                <td><input style="display: inline-block; width: 100%;" type="text" name="titulo" value="<?php echo $chamado['titulo']; ?>"></td>
            </tr>
            <tr>
                <td>Setor</td>
                <td><input style="display: inline-block; width: 100%;" type="text" name="setor" value="<?php echo $chamado['setor']; ?>"></td>
            </tr>
            <tr>
                <td>Descrição</td>
                <td><textarea name="descricao" cols="40" rows="20"><?php echo $chamado['descricao']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input style="display: inline-block; width: 100%;"  type="submit" value="Salvar"></td>
            </tr>
        </table>
    </form>
</body>
</html>