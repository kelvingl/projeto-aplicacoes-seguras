<?php
$app->get('/chamados', function($request, $response) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $where = ($role != 1) ?" WHERE u.id = " . $_SESSION['usuario_id'] : "";
    $this->renderer->render($response, 'chamados/list.php', [
        'chamados' => $this->db->query('SELECT c.*, u.nome as usuario_nome FROM chamados c INNER JOIN usuarios u ON u.id = c.usuario' . $where)->fetch_all(MYSQLI_ASSOC),
        'container' => $this,
        'title' => 'Lista de chamados'
    ]);
})->setName('chamadosGet');

$app->get('/chamados/add', function($request, $response) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $this->renderer->render($response, 'chamados/add.php', [
        'usuarios' => $this->db->query('SELECT * FROM  usuarios')->fetch_all(MYSQLI_ASSOC),
        'container' => $this,
        'title' => 'Cadastro de chamados'
    ]);
})->setName('chamadosAddGet');

$app->get('/chamados/edit/{id}', function($request, $response, $data) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $where = ($role != 1) ?" AND u.id = " . $_SESSION['usuario_id'] : "";
    $chamado = $this->db->query('SELECT c.*,u.nome AS responsavel  FROM chamados c INNER JOIN usuarios u ON u.id = c.usuario WHERE c.id = '. $data['id'] . $where)->fetch_assoc();
    if(!$chamado) {
        return $response->withRedirect($this->router->pathFor('indexGet'));
    }
    $this->renderer->render($response, 'chamados/edit.php', [
        'chamado' => $chamado,
        'usuarios' => $this->db->query('SELECT * FROM  usuarios')->fetch_all(MYSQLI_ASSOC),
        'container' => $this,
        'title' => 'Edição do chamado #' . $data['id']
    ]);
})->setName('chamadosEditGet');

$app->post('/chamados/edit/{id}', function($request, $response, $data) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $encodeFunc = $this->encodeData;
    $toSave = $request->getParsedBody();
    $sql = "UPDATE chamados SET ";
    foreach ($toSave as $k => $v) {
        $k = $encodeFunc($k);
        $v = $encodeFunc($v);
        $sql .= " $k = \"$v\", ";
    }
    $sql = substr($sql, 0, strlen($sql) - 2) . " WHERE id = " . $data['id'];
    $this->db->query($sql);
    return $response->withRedirect($this->router->pathFor('chamadosEditGet', ['id' => $data['id']]));
 })->setName('chamadosEditPost');

$app->get('/chamados/delete/{id}', function($request, $response, $data) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $this->db->query('DELETE FROM chamados WHERE id = '. $data['id']);
    return $response->withRedirect($this->router->pathFor('chamadosGet'));
})->setName('chamadosDeleteGet');

$app->post('/chamados/add', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $toSave = $request->getParsedBody();
    $encodeFunc = $this->encodeData;
    $toSave = array_map($encodeFunc, $toSave);
    $sql = 'INSERT INTO chamados (' . implode(', ', array_keys($toSave)) . ') VALUES ("' . implode('", "', array_values($toSave)) . '")';
    $success = $this->db->query($sql);
    return $response->withRedirect($this->router->pathFor('chamadosEditGet', ['id' => mysqli_insert_id($this->db)]));
})->setName('chamadosAddPost');

$app->get('/home/index', function($request, $response) {
    if(($role = $this->auth) === null){
        return $response->withRedirect($this->router->pathFor('login'));
    }
    $this->renderer->render($response, 'home/index.php', [
        'title' => 'Index',
        'container' => $this
    ]);
})->setName('indexGet');