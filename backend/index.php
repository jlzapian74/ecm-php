<?php
  ini_set('display_error', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once 'config/Database.php';
  require_once 'models/Usuario.php';
  require_once 'repositories/UsuarioRepository.php';
  require_once 'services/UsuarioService.php';
  require_once 'controllers/UsuarioController.php';

  $database = new \Backend\Config\Database();
  $db = $database->connect();

  $usuarioRepo = new \Backend\Repositories\UsuarioRepository($db);
  $usuarioService = new \Backend\Services\UsuarioService($usuarioRepo);
  $usuarioController = new \Backend\Controllers\UsuarioController($usuarioService);

  $method = $_SERVER['REQUEST_METHOD'];
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $basePath = '/ecm-php/backend/index.php';
  $route = str_replace($basePath, '', $uri);

  if ($method === 'POST' && $route === '/login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuarioController->login($data);
  }

  if ($method === 'POST' && $route === '/create') {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuarioController->create($data);
  }

  if ($method === 'GET' && $route === '/usuarios') {
    $usuarioController->getAll();
  }

  if ($method === 'GET' && preg_match('#^/usuario/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    $usuarioController->getById($id);
  }

  if ($method === 'PUT' && preg_match('#^/usuario/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    $data = json_decode(file_get_contents('php://input'), true);
    $usuarioController->update($id, $data);
  }

  if ($method === 'DELETE' && preg_match('#^/usuario/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    $usuarioController->delete($id);
  }