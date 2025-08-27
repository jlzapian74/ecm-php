<?php
  namespace Backend\Repositories;

  use Backend\Models\Usuario;
  use PDO;

  class UsuarioRepository {
    private $conn;

    public function __construct(PDO $conn) {
      $this->conn = $conn;
    }

    public function create(Usuario $usuario) {
      $sql = "INSERT INTO usuarios (nombre, apaterno, amaterno, direccion, telefono, ciudad, pais, usuario, password, rol)
              VALUES (:nombre, :apaterno, :amaterno, :direccion, :telefono, :ciudad, :pais, :usuario, :password, :rol)";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':nombre', $usuario->nombre);
      $query_execute->bindParam(':apaterno', $usuario->apaterno);
      $query_execute->bindParam(':amaterno', $usuario->amaterno);
      $query_execute->bindParam(':direccion', $usuario->direccion);
      $query_execute->bindParam(':telefono', $usuario->telefono);
      $query_execute->bindParam(':ciudad', $usuario->ciudad);
      $query_execute->bindParam(':pais', $usuario->pais);
      $query_execute->bindParam(':usuario', $usuario->usuario);
      $query_execute->bindParam(':password', $usuario->password);
      $query_execute->bindParam(':rol', $usuario->rol);

      return $query_execute->execute();
    }

    public function getAll() {
      $sql = "SELECT * FROM usuarios";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->execute();
      return $query_execute->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
      $sql = "SELECT * FROM usuarios WHERE id = :id";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':id', $id);
      $query_execute->execute();
      return $query_execute->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername($usuario) {
      $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':usuario', $usuario);
      $query_execute->execute();

      $data = $query_execute->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        return null;
      }

      return new Usuario(
        $data['id'],
        $data['nombre'],
        $data['apaterno'],
        $data['amaterno'],
        $data['direccion'],
        $data['telefono'],
        $data['ciudad'],
        $data['pais'],
        $data['usuario'],
        $data['password'],
        $data['rol']
      );
    }

    public function update(Usuario $usuario) {
      $sql = "SELECT * FROM usuarios WHERE id = :id";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':id', $usuario->id);
      $query_execute->execute();
      $result = $query_execute->fetch(PDO::FETCH_ASSOC);
      $passwordActual = $result['password'] ?? '';

      if (!password_verify($usuario->password, $passwordActual)) {
        $usuario->password = password_hash($usuario->password, PASSWORD_DEFAULT);
      }

      $sql = "UPDATE usuarios SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, direccion = :direccion, telefono = :telefono, ciudad = :ciudad, pais = :pais, usuario = :usuario, password = :password, rol = :rol WHERE id = :id";

      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':nombre', $usuario->nombre);
      $query_execute->bindParam(':apaterno', $usuario->apaterno);
      $query_execute->bindParam(':amaterno', $usuario->amaterno);
      $query_execute->bindParam(':direccion', $usuario->direccion);
      $query_execute->bindParam(':telefono', $usuario->telefono);
      $query_execute->bindParam(':ciudad', $usuario->ciudad);
      $query_execute->bindParam(':pais', $usuario->pais);
      $query_execute->bindParam(':usuario', $usuario->usuario);
      $query_execute->bindParam(':password', $usuario->password);
      $query_execute->bindParam(':rol', $usuario->rol);
      $query_execute->bindParam(':id', $usuario->id);

      return $query_execute->execute();
    }

    public function delete($id) {
      $sql = "DELETE FROM usuarios WHERE id = :id";
      $query_execute = $this->conn->prepare($sql);
      $query_execute->bindParam(':id', $id);
      return $query_execute->execute();
    }
  }