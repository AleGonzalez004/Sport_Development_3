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
    document.getElementById('recoveryForm').addEventListener('submit', function (event) {
        event.preventDefault(); 

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

    document.getElementById('passwordChangeForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('../../api/helpers/recuperacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                swal('Éxito', data.message, 'success').then(() => {
                    window.location.href = '../../views/public/login.html'; 
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
