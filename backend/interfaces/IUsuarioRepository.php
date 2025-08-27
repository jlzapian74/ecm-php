<?php
  namespace Backend\Interfaces;

  use Backend\Models\Usuario;

  interface IUsuarioRepository {
    public function login(string $usuario, string $password): Usuario|null;
    public function create(Usuario $usuario): bool;
    public function getAll(): array;
    public function getById(int $id): Usuario|null;
    public function update(Usuario $usuario): bool;
    public function delete(int $id): bool;
  }