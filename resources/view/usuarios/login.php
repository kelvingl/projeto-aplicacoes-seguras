<html>
<head>
    <title><?php echo $title ?></title>
    <?php if(isset($_GET['error'])): ?>
        <script type="text/javascript">alert('Usuário ou senha inválido(s)');</script>
    <?php endif; ?>
</head>
<body>
    <form id="form" method="POST" action="<?php $container->router->pathFor('loginPost'); ?>">
        <table border="1">
        <tr>
            <td>Usuário</td>
            <td><input type="text" name="login"></td>
        </tr>
        <tr>
            <td>Senha</td>
            <td><input type="password" name="senha"></td>
        </tr>
        <tr><td colspan="2"><input type="submit" value="Login"></td></tr>
    </table>
    </form>
</body>
</html>