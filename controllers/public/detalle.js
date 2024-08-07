// Constantes para completar la ruta de la API.
const PRODUCTO_API = 'services/public/producto.php';
const PEDIDO_API = 'services/public/pedido.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const SHOPPING_FORM = document.getElementById('shoppingForm');
// Constante para establecer el campo de cantidad del producto.
const CANTIDAD_INPUT = document.getElementById('cantidadProducto');
// Constante para establecer el campo de existencias del producto.
const EXISTENCIAS_INPUT = document.getElementById('existenciasProducto');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Detalles del producto';

    // Constante tipo objeto con los datos del producto seleccionado.
    const FORM = new FormData();
    FORM.append('idProducto', PARAMS.get('id'));

    // Petición para solicitar los datos del producto seleccionado.
    const DATA = await fetchData(PRODUCTO_API, 'readOne', FORM);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se colocan los datos del producto en la página web de acuerdo con el producto seleccionado previamente.
        document.getElementById('imagenProducto').src = SERVER_URL.concat('images/productos/', DATA.dataset.imagen_producto);
        document.getElementById('nombreProducto').textContent = DATA.dataset.nombre_producto;
        document.getElementById('descripcionProducto').textContent = DATA.dataset.descripcion_producto;
        document.getElementById('precioProducto').textContent = DATA.dataset.precio_producto;
        EXISTENCIAS_INPUT.textContent = DATA.dataset.existencias_producto;
        document.getElementById('idProducto').value = DATA.dataset.id_producto;

        // Ahora solicitamos los comentarios del producto.
        const COMMENTS_DATA = await fetchData(PRODUCTO_API, 'readComments', FORM);

        // Se comprueba si la respuesta para los comentarios es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (COMMENTS_DATA.status) {
            const commentsContainer = document.getElementById('commentsContainer'); // Contenedor donde se mostrarán los comentarios.
            commentsContainer.innerHTML = ''; // Limpiar contenedor antes de agregar nuevos comentarios.

            // Iterar sobre los comentarios y mostrarlos.
            COMMENTS_DATA.dataset.forEach(comment => {
                // Crear elementos HTML para cada comentario.
                const commentElement = document.createElement('div');
                commentElement.classList.add('comment');

                const ratingElement = document.createElement('p');
                ratingElement.classList.add('comment-rating');
                ratingElement.textContent = `Calificación: ${comment.calificacion_producto}`;
                commentElement.appendChild(ratingElement);

                const textElement = document.createElement('p');
                textElement.textContent = `Comentario: ${comment.comentario_producto}`;
                commentElement.appendChild(textElement);

                const dateElement = document.createElement('p');
                dateElement.classList.add('comment-date');
                dateElement.textContent = `Fecha: ${new Date(comment.fecha_valoracion).toLocaleDateString()}`;
                commentElement.appendChild(dateElement);

                // Agregar el comentario al contenedor.
                commentsContainer.appendChild(commentElement);
            });
        } else {
            // Se presenta un mensaje de error cuando no existen comentarios.
            document.getElementById('commentsContainer').innerHTML = `<p>${COMMENTS_DATA.error}</p>`;
        }
    } else {
        // Se presenta un mensaje de error cuando no existen datos del producto.
        document.getElementById('mainTitle').textContent = DATA.error;
        document.getElementById('detalle').innerHTML = '';
    }
});



// Método del evento para cuando se envía el formulario de agregar un producto al carrito.
SHOPPING_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SHOPPING_FORM);
    // Obtiene el valor de la cantidad ingresada.
    const CANTIDAD = parseInt(CANTIDAD_INPUT.value);
    // Obtiene el valor de las existencias del producto.
    const EXISTENCIAS = parseInt(EXISTENCIAS_INPUT.textContent);
    // Verifica si la cantidad supera las existencias.
    if (CANTIDAD > EXISTENCIAS) {
        sweetAlert(2, 'La cantidad a comprar no puede ser mayor que las existencias', false);
        return;
    }
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PEDIDO_API, 'createDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
    if (DATA.status) {
        sweetAlert(1, DATA.message, false, 'carrito.html');
    } else if (DATA.session) {
        sweetAlert(2, DATA.error, false);
    } else {
        sweetAlert(3, DATA.error, true, 'login.html');
    }
});

