<?php
$app->get('/usuarios', function($request, $response) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $this->renderer->render($response, 'usuarios/list.php', [
        'usuarios' => $this->db->query('SELECT * FROM usuarios')->fetch_all(MYSQLI_ASSOC),
        'grupos' => $this->db->query('SELECT * FROM grupos')->fetch_all(MYSQLI_ASSOC),
        'container' => $this,
        'title' => 'Lista de usuários'
    ]);
})->setName('usuariosGet');

$app->put('/usuarios/{id}', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $toSave = array_intersect_key($request->getParsedBody(), array_flip(['nome', 'login', 'senha', 'grupo']));
    if(empty($toSave['senha'])) unset($toSave['senha']);
    $sql = 'UPDATE usuarios SET';
    foreach ($toSave as $key => $value)
        $sql .= " $key = \"$value\", ";
    $sql = substr($sql, 0, strlen($sql) - 2);
    $sql .= ' WHERE id = ' . $data['id'];
    $success = $this->db->query($sql);
    return $response->withJson(['success' => $success], $success ? 200 : 400);
})->setName('usuariosPut');

$app->delete('/usuarios/{id}', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $sql = 'DELETE FROM usuarios WHERE id = ' . $data['id'];
    $success = $this->db->query($sql);
    return $response->withJson(['success' => $success], $success ? 200 : 400);
})->setName('usuariosDelete');

$app->post('/usuarios', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $toSave = array_intersect_key($request->getParsedBody(), array_flip(['nome', 'login', 'senha', 'grupo']));
    $sql = 'INSERT INTO usuarios (' . implode(', ', array_keys($toSave)) . ') VALUES ("' . implode('", "', array_values($toSave)) . '")';
    $success = $this->db->query($sql);
    $toSave['id'] = mysqli_insert_id($this->db);
    return $response->withJson(['success' => $success, 'data' => $toSave], $success ? 200 : 400);
})->setName('usuariosPost');

$app->get('/login', function($request, $response, $data) {
    return $this->renderer->render($response, 'usuarios/login.php', [
        'container' => $this,
        'title' => 'Login'
    ]);
})->setName('login');

$app->post('/login', function($request, $response, $data) {
    $data = array_merge([
        'login' => '',
        'senha' => ''
    ], $request->getParsedBody());
    $sql = "SELECT u.id, g.admin FROM usuarios u INNER JOIN grupos g ON g.id = u.grupo WHERE u.login = \"" . $data['login'] . "\" AND u.senha = \"" . $data['senha'] . "\"";
    $result = $this->db->query($sql);
    if ($result->num_rows == 0) {
        return $response->withRedirect($this->router->pathFor('login', [], ['error' => 1]));
    }
    $result = $result->fetch_assoc();
    $_SESSION['usuario_id'] = $result['id'];
    $_SESSION['grupo_admin'] = $result['admin'];
    return $response->withRedirect($this->router->pathFor('indexGet'));
})->setName('loginPost');