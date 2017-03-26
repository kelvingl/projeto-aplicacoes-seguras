<?php
$app->get('/grupos', function($request, $response) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $this->renderer->render($response, 'grupos/list.php', [
        'grupos' => $this->db->query('SELECT * FROM grupos')->fetch_all(MYSQLI_ASSOC),
        'container' => $this,
        'title' => 'Lista de grupos'
    ]);
})->setName('gruposGet');

$app->put('/grupos/{id}', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $toSave = array_intersect_key($request->getParsedBody(), array_flip(['nome', 'admin']));
    $encodeFunc = $this->encodeData;
    $toSave = array_map($encodeFunc, $toSave);
    $sql = 'UPDATE grupos SET';
    foreach ($toSave as $key => $value)
        $sql .= " $key = \"$value\", ";
    $sql = substr($sql, 0, strlen($sql) - 2);
    $sql .= ' WHERE id = ' . $data['id'];
    $success = $this->db->query($sql);
    return $response->withJson(['success' => $success], $success ? 200 : 400);
})->setName('gruposPut');

$app->delete('/grupos/{id}', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $sql = 'DELETE FROM grupos WHERE id = ' . (int) $data['id'];
    $success = $this->db->query($sql);
    return $response->withJson(['success' => $success], $success ? 200 : 400);
})->setName('gruposDelete');

$app->post('/grupos', function($request, $response, $data) {
    if(($role = $this->auth) !== 1){
        if($role === null) {
            return $response->withRedirect($this->router->pathFor('login'));
        } else {
            return $response->withRedirect($this->router->pathFor('unauthorized'));
        }
    }
    $toSave = array_intersect_key($request->getParsedBody(), array_flip(['nome', 'admin']));
    $encodeFunc = $this->encodeData;
    $toSave = array_map($encodeFunc, $toSave);
    $sql = 'INSERT INTO grupos (' . implode(', ', array_keys($toSave)) . ') VALUES ("' . implode('", "', array_values($toSave)) . '")';
    $success = $this->db->query($sql);
    $toSave['id'] = mysqli_insert_id($this->db);
    return $response->withJson(['success' => $success, 'data' => $toSave], $success ? 200 : 400);
})->setName('gruposPost');