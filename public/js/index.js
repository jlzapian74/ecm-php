const loginForm = document.getElementById('loginForm')

loginForm.addEventListener('submit', async (event) => {
  event.preventDefault()

  const usuario = document.getElementById('usuario').value
  const password = document.getElementById('password').value

  const response = await fetch('http://localhost:8888/ecm-php/backend/index.php/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({usuario, password})
  })

  const data = await response.json()
  console.log('@@@ data => ', data)
  if (data.message === 'success') {
    const usuario = {
      id: data.data.id,
      usuario: data.data.usuario,
      rol: data.data.rol
    }
    mostrarAlerta('Login Exitoso', 'success')
    localStorage.setItem('usuario', JSON.stringify(usuario))
    window.location.href = 'dashboard.html'
  } else {
    mostrarAlerta(data.message || 'Credenciales Invalidas', 'success')
  }
})