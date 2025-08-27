<?php
  namespace Backend\Services;

  use Backend\Repositories\UsuarioRepository;
  use Backend\Models\Usuario;

  class UsuarioService {
    private $usuarioRepo;

    public function __construct(UsuarioRepository $usuarioRepo) {
      $this->usuarioRepo = $usuarioRepo;
    }

    public function create(Usuario $usuario) {
      $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
      return $this->usuarioRepo->create($usuario);
    }

    public function getAll() {
      return $this->usuarioRepo->getAll();
    }

    public function getById($id) {
      return $this->usuarioRepo->getById($id);
    }

    public function update(Usuario $usuario) {
      return $this->usuarioRepo->update($usuario);
    }

    public function delete($id) {
      return $this->usuarioRepo->delete($id);
    }

    public function login($usuario, $password) {
      $user = $this->usuarioRepo->getByUsername($usuario);
      if (!$user) {
        return false;
      }

      if (!password_verify($password, $user->password)) {
        return false;
      }

      return $user;
    }
  }