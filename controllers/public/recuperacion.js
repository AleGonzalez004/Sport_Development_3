// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('sessionForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Recupera contraseña';
});

document.addEventListener('DOMContentLoaded', function () {
    // Manejar el envío del formulario de recuperación
    document.getElementById('recoveryForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        let formData = new FormData(this);

        fetch('../../api/helpers/recuperacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                swal('Éxito', data.message, 'success');
            } else {
                swal('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            swal('Error', 'Hubo un problema al procesar la solicitud.', 'error');
        });
    });

    // Manejar el envío del formulario de cambio de contraseña en el modal
    document.getElementById('passwordChangeForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        let formData = new FormData(this);

        fetch('../../api/helpers/recuperacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                swal('Éxito', data.message, 'success').then(() => {
                    // Redirigir al usuario a la página de inicio de sesión
                    window.location.href = '../../path/to/login.html'; // Cambia esta ruta a la URL de tu página de inicio de sesión
                });
            } else {
                swal('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            swal('Error', 'Hubo un problema al procesar la solicitud.', 'error');
        });
    });
});

/*
*   Función para obtener un token del reCAPTCHA y asignarlo al formulario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function reCAPTCHA() {
    // Método para generar el token del reCAPTCHA.
    grecaptcha.ready(() => {
        // Constante para establecer la llave pública del reCAPTCHA.
        const PUBLIC_KEY = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
        // Se obtiene un token para la página web mediante la llave pública.
        grecaptcha.execute(PUBLIC_KEY, { action: 'homepage' }).then((token) => {
            // Se asigna el valor del token al campo oculto del formulario
            document.getElementById('gRecaptchaResponse').value = token;
        });
    });
}
