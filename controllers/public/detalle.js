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

// Método del eventos para cuando el documento ha cargado.
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
        // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
        document.getElementById('imagenProducto').src = SERVER_URL.concat('images/productos/', DATA.dataset.imagen_producto);
        document.getElementById('nombreProducto').textContent = DATA.dataset.nombre_producto;
        document.getElementById('descripcionProducto').textContent = DATA.dataset.descripcion_producto;
        document.getElementById('precioProducto').textContent = DATA.dataset.precio_producto;
        EXISTENCIAS_INPUT.textContent = DATA.dataset.existencias_producto;
        document.getElementById('idProducto').value = DATA.dataset.id_producto;
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
        // Se limpia el contenido cuando no hay datos para mostrar.
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

document.addEventListener('DOMContentLoaded', function() {
    const colorSelect = document.getElementById('colorProducto');

    // Supongamos que estos colores se obtienen de una base de datos o API
    const colores = ['Rojo', 'Azul', 'Verde', 'Negro', 'Blanco', 'Amarillo'];

    // Añadir opciones al combobox de colores
    colores.forEach(color => {
        const option = document.createElement('option');
        option.value = color.toLowerCase();
        option.textContent = color;
        colorSelect.appendChild(option);
    });
});

// Obtener el nombre del usuario de la API y agregarlo al comentario
let username = '';

const getUserData = async () => {
    const DATA = await fetchData(USER_API, 'getUser');
    if (DATA.session) {
        username = DATA.username;
        // Inicializar las estrellas vacías
        updateStars('0');
    } else {
        console.error('Usuario no autenticado.');
    }
};

function updateStars(rating) {
    const starsContainer = document.getElementById('stars');
    starsContainer.innerHTML = ''; // Limpiar estrellas existentes
    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.className = 'bi bi-star';
        if (i <= rating) {
            star.classList.add('active');
        }
        starsContainer.appendChild(star);
    }
}

document.getElementById('rating').addEventListener('input', function(event) {
    // Asegurarse de que solo se permita un número del 1 al 5
    let value = event.target.value;
    if (/^[1-5]$/.test(value)) {
        updateStars(value);
    } else {
        event.target.value = value.slice(0, -1); // Eliminar el último carácter si no es válido
    }
});

document.getElementById('commentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener los valores del formulario
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('userComment').value;

    // Validar que la calificación sea un único número del 1 al 5
    if (!/^[1-5]$/.test(rating)) {
        alert('La calificación debe ser un único número del 1 al 5.');
        return;
    }

    // Crear un nuevo elemento de lista para el comentario
    const commentItem = document.createElement('li');
    
    commentItem.innerHTML = ` <img src="../../resources/img/user.png" width="50"><b>Usuario: ${username}</b> <div class="stars">Calificación: ${'⭐'.repeat(rating)}</div> Comentario: ${comment}`;

    // Agregar el comentario a la lista de comentarios
    document.getElementById('comments').appendChild(commentItem);

    // Limpiar el formulario
    document.getElementById('commentForm').reset();
    updateStars(''); // Limpiar estrellas
});

// Inicializar la carga de datos del usuario
getUserData();
