// Constantes para completar la ruta de la API.
const PRODUCTOS_API = 'services/public/producto.php';
const ORDER_API = 'services/public/order.php';
const COMENTARIOS_API = 'services/public/comentario.php';
const CALIFICACIONES_API = 'services/public/calificacion.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAM = new URLSearchParams(location.search);
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const SHOPPING_FORM = document.getElementById('shoppingForm');
// Constante para establecer el formulario de comentarios.
const COMMENT_FORM = document.getElementById('commentForm');
// Constante para establecer el contenedor de comentarios.
const COMMENTS_LIST = document.getElementById('commentsList');
// Constante para establecer las estrellas de calificación.
const RATING_STARS = document.querySelectorAll('#rating .bi-star');

// Método del eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Detalles del producto';
    // Constante tipo objeto con los datos del producto seleccionado.
    const FORM = new FormData();
    FORM.append('idProducto', PARAM.get('id'));
    // Petición para solicitar los datos del producto seleccionado.
    const DATA = await fetchData(PRODUCTOS_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
        document.getElementById('imagenProducto').src = SERVER_URL.concat('images/productos/', DATA.dataset.imagen_producto);
        document.getElementById('nombreProducto').textContent = DATA.dataset.nombre_producto;
        document.getElementById('descripcionProducto').textContent = DATA.dataset.descripcion_producto;
        document.getElementById('precioProducto').textContent = DATA.dataset.precio_producto;
        document.getElementById('existenciasProducto').textContent = DATA.dataset.existencias_producto;
        document.getElementById('idProducto').value = DATA.dataset.id_producto;
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
        // Se limpia el contenido cuando no hay datos para mostrar.
        document.getElementById('detalle').innerHTML = '';
    }

    // Manejo de la calificación de productos
    RATING_STARS.forEach(star => {
        star.addEventListener('click', async (e) => {
            const value = e.target.getAttribute('data-value');
            RATING_STARS.forEach(s => s.classList.remove('bi-star-fill', 'text-warning'));
            for (let i = 0; i < value; i++) {
                RATING_STARS[i].classList.add('bi-star-fill', 'text-warning');
            }
            const FORM = new FormData();
            FORM.append('idProducto', PARAM.get('id'));
            FORM.append('calificacion', value);
            try {
                const DATA = await fetchData(CALIFICACIONES_API, 'create', FORM);
                if (!DATA.status) {
                    sweetAlert(2, DATA.error, false);
                }
            } catch (error) {
                sweetAlert(2, 'Error al enviar la calificación', false);
                console.error(error);
            }
        });
    });

    // Manejo del envío de comentarios
    COMMENT_FORM.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userComment = document.getElementById('userComment').value;
        const FORM = new FormData();
        FORM.append('idProducto', PARAM.get('id'));
        FORM.append('comentario', userComment);
        try {
            const DATA = await fetchData(COMENTARIOS_API, 'create', FORM);
            if (DATA.status) {
                const commentElement = document.createElement('div');
                commentElement.classList.add('mb-2');
                commentElement.innerHTML = `<p>${userComment}</p>`;
                COMMENTS_LIST.appendChild(commentElement);
                COMMENT_FORM.reset();
            } else {
                sweetAlert(2, DATA.error, false);
            }
        } catch (error) {
            sweetAlert(2, 'Error al enviar el comentario', false);
            console.error(error);
        }
    });
});

// Método del evento para cuando se envía el formulario de agregar un producto al carrito.
SHOPPING_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SHOPPING_FORM);
    
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(ORDER_API, 'createDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
    if (DATA.status) {
        sweetAlert(1, DATA.message, false, 'pedido.html');
    } else if (DATA.session) {
        sweetAlert(2, DATA.error, false);
    } else {
        sweetAlert(3, DATA.error, true, 'login.html');
    }
});
