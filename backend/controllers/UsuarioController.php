<?php
  namespace Backend\Controllers;

  use Backend\Services\UsuarioService;
  use Backend\Models\Usuario;
  use Exception;

  class UsuarioController {
    private UsuarioService $service;

    public function __construct(UsuarioService $service) {
      $this->service = $service;
    }

    public function login($data) {
      try {
        if (is_array($data)) {
          $data = (object) $data;
        }

        $response = $this->service->login($data->usuario, $data->password);
        if ($response) {
          echo json_encode([
            'message' => 'success',
            'data' => $response
          ]);
        } else {
          echo json_encode([
            'message' => 'error',
            'error' => 'Credenciales Inválidas'
          ]);
        }
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }

    public function create($data) {
      try {
        if (is_array($data)) {
          $data = (object) $data;
        }

        $usuario = new Usuario(
          null,
          $data->nombre,
          $data->apaterno,
          $data->amaterno,
          $data->direccion,
          $data->telefono,
          $data->ciudad,
          $data->pais,
          $data->usuario,
          $data->password,
          $data->rol
        );

        $respuesta = $this->service->create($usuario);

        echo json_encode([
          'message' => $respuesta ? 'success' : 'error',
          'data' => $respuesta ? 'Usuario creado exitosamente' : null,
          'error' => $respuesta ? null : 'No se pudo crear el usuario'
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }

    public function getAll() {
      try {
        $usuarios = $this->service->getAll();

        echo json_encode([
          'message' => 'success',
          'data' => $usuarios
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }

    public function getById($id) {
      try {
        $usuario = $this->service->getById($id);

        echo json_encode([
          'message' => $usuario ? 'success' : 'error',
          'data' => $usuario ? $usuario : null,
          'error' => $usuario ? null : 'Usuario no encontrado'
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }

    public function update($id, $data) {
      try {
        if (is_array($data)) {
          $data = (object) $data;
        }

        $usuario = new Usuario(
          $id,
          $data->nombre,
          $data->apaterno,
          $data->amaterno,
          $data->direccion,
          $data->telefono,
          $data->ciudad,
          $data->pais,
          $data->usuario,
          $data->password,
          $data->rol
        );
        $respuesta = $this->service->update($usuario);

        echo json_encode([
          'message' => $respuesta ? 'success' : 'error',
          'data' => $respuesta ? 'Usuario actualizado exitosamente' : null,
          'error' => $respuesta ? null : 'No se pudo actualizar el usuario'
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }

    public function delete($id) {
      try {
        $respuesta = $this->service->delete($id);

        echo json_encode([
          'message' => $respuesta ? 'success' : 'error',
          'data' => $respuesta ? 'Usuario eliminado exitosamente' : null,
          'error' => $respuesta ? null : 'No se pudo eliminar el usuario'
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'message' => 'error',
          'error' => $e->getMessage()
        ]);
      }
    }
  }