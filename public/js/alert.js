const mostrarAlerta = (message, tipo = 'success') => {
    const alerta = document.createElement('div')
    alerta.classList.add('alert', `alert-${tipo}`, 'alert-dismissible', 'fade', 'show')
    alerta.setAttribute('role', 'alert')
  
    alerta.innerHTML =
    `
      <strong>${message}</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    `
  
    const contenedorAlerta = document.getElementById('contenedorAlertas')
    contenedorAlerta.appendChild(alerta)
    setTimeout(() => {
      alerta.remove()
    }, 3000)
  }