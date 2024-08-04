// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('sessionForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Recuperar Contraseña';
});

// Método del evento para cuando se envía el formulario de inicio de sesión.
LOGIN_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    
    // Llamada a la función reCAPTCHA para obtener el token y asignarlo al formulario.
    await reCAPTCHA();
    
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_FORM);
    
    try {
        // Petición para recuperar la información del cliente basado en el correo electrónico
        const response = await fetch('../../helpers/recuperacion.php', {
            method: 'POST',
            body: FORM
        });

        const DATA = await response.json();
        
        // Se comprueba si la respuesta es satisfactoria
        if (DATA.status) {
            // Mostrar mensaje de éxito
            sweetAlert(1, 'Correo electrónico encontrado. Por favor, revise su correo para recuperar la contraseña.', true);
        } else {
            // Mostrar mensaje de error si el cliente no se encuentra
            sweetAlert(2, DATA.error || 'No se pudo recuperar el usuario', false);
        }
    } catch (error) {
        // Manejo del error
        sweetAlert(2, 'Error en la solicitud. Por favor, intente de nuevo.', false);
        console.error(error);
    }
});