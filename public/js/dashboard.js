const usuario = localStorage.getItem('usuario')
if (!usuario) {
  window.location.href = 'index.html'
}

const tabla = document.getElementById('tablaUsuarios')
const crearForm = document.getElementById('crearUsuarioForm')
const editarForm = document.getElementById('editarUsuarioForm')

const cargaUsuarios = async () => {
  try {
    const res = await fetch('http://localhost:8888/ecm-php/backend/index.php/usuarios')
    const usuarios = await res.json()
    console.log('@@@ usuarios => ', usuarios)
    tabla.innerHTML = ''
    usuarios.data.forEach((item) => {
      const tr = document.createElement('tr')
      tr.innerHTML =
      `
        <td>${item.usuario}</td>
        <td>${item.nombre} ${item.apaterno} ${item.amaterno}</td>
        <td>${item.rol}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="abrirEditar({ id: ${item.id}, nombre: '${item.nombre}', apaterno: '${item.apaterno}', amaterno: '${item.amaterno}', direccion: '${item.direccion}', telefono: '${item.telefono}', ciudad: '${item.ciudad}', estado: '${item.pais}', usuario: '${item.usuario}', rol: '${item.rol}' })">
            Editar
          </button>
          |
          <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${item.id})">
            Borrar
          </button>
        </td>
      `
      tabla.appendChild(tr)
    })
  } catch (error) {
    mostrarAlerta(error, 'error')
  }
}

const eliminarUsuario = async id => {
  const confirmation = confirm('¿Estas seguro?')
  if (confirmation) {
    try {
      const response = await fetch(`http://localhost:8888/ecm-php/backend/index.php/usuario/${id}`, {
        method: 'DELETE'
      })
      const result = await response.json()
      mostrarAlerta(result.message || 'Usuario Eliminado', 'success')
      cargaUsuarios()
    } catch (error) {
      mostrarAlerta(error, 'error')
    }
  }
}

crearForm.addEventListener('submit', async (event) => {
  event.preventDefault()
  const formData = new FormData(crearForm)
  const dataObj = Object.fromEntries(formData.entries())

  try {
    const response = await fetch('http://localhost:8888/ecm-php/backend/index.php/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dataObj) 
    })

    const result = await response.json()

    if (result.message === 'success' && result.data === 'Usuario creado exitosamente') {
      mostrarAlerta('Usuario Creado Exitosamente', 'success')
      crearForm.reset()
      bootstrap.Modal.getInstance(document.getElementById('crearModal')).hide()
      cargaUsuarios()
    } else {
      mostrarAlerta(result.message || 'Error al crear el usuario', 'error')
    }
  } catch (error) {
    mostrarAlerta(error, 'error')
  }
})

const abrirEditar = (usuario) => {
  console.log('@@@ usuario => ', usuario)
  document.getElementById('editarnombre').value = usuario.nombre
  document.getElementById('editarapaterno').value = usuario.apaterno
  document.getElementById('editaramaterno').value = usuario.amaterno
  document.getElementById('editardireccion').value = usuario.direccion
  document.getElementById('editartelefono').value = usuario.telefono
  document.getElementById('editarciudad').value = usuario.ciudad
  document.getElementById('editarpais').value = usuario.pais
  document.getElementById('editarusuario').value = usuario.usuario
  document.getElementById('editarpassword').value = ''
  document.getElementById('editarrol').value = usuario.rol

  const modalEdita = new bootstrap.Modal(document.getElementById('editarModal'))
  modalEdita.show()

  editarForm.onsubmit = async (event) => {
    event.preventDefault()
    const formData = new FormData(editarForm)
    const dataObj = Object.fromEntries(formData.entries())

    try {
      const response = await fetch(`http://localhost:8888/ecm-php/backend/index.php/usuario/${usuario.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataObj) 
      })

      const result = await response.json()

      mostrarAlerta('Usuario Actualizado Exitosamente', 'success')
      editarForm.reset()
      cargaUsuarios()
      bootstrap.Modal.getInstance(document.getElementById('editarModal')).hide()
    } catch (error) {
      mostrarAlerta(error, 'error')
    }
  }
}

cargaUsuarios()