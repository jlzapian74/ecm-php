const registerForm = document.getElementById('registerForm')

registerForm.addEventListener('submit', async (event) => {
  event.preventDefault()

  const data = {
    nombre: document.getElementById('nombre').value,
    apaterno: document.getElementById('apaterno').value,
    amaterno: document.getElementById('amaterno').value,
    direccion: document.getElementById('direccion').value,
    telefono: document.getElementById('telefono').value,
    ciudad: document.getElementById('ciudad').value,
    estado: document.getElementById('pais').value,
    usuario: document.getElementById('usuario').value,
    password: document.getElementById('password').value,
    rol: document.getElementById('rol').value
  }

   const response = await fetch('http://localhost:8888/ecm-php/backend/index.php/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data) 
    })

    const result = await response.json()

    if (result.message === 'success' && result.data === 'Usuario creado exitosamente') {
      mostrarAlerta('Usuario Creado Exitosamente', 'success')
      window.location.href = 'index.html'
    } else {
      mostrarAlerta(result.message || 'Error al crear el usuario', 'error')
    }
})