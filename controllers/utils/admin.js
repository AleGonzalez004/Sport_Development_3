/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar la plantilla del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/admin/administrador.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Sport Development - Dashboard';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #245C9D;">
                        <div class="container">
                            <a class="navbar-brand text-white" href="dashboard.html">
                                <img src="../../resources/img/logo.png" alt="CoffeeShop" width="50">
                                Sport Development
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="colores.html">Colores</a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link text-white" href="generos.html">Generos</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link text-white" href="marcas.html">Marcas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="producto.html">Productos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="categoria.html">Categorías</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="administrador.html">Administradores</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="cliente.html">Clientes</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" aria-expanded="false">Cuenta: <b>${DATA.username}</b></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item text-dark" href="perfil.html">Editar perfil</a></li>
                                            <li><hr class="dropdown-divider text-dark"></li>
                                            <li><a class="dropdown-item text-dark" href="#" onclick="logOut()">Cerrar sesión</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>
            `);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
                <footer>
                    <nav class="navbar fixed-bottom bg-dark">
                        <div class="container">
                            <div>
                                <p><a class="nav-link text-white" href="https://github.com/dacasoft/coffeeshop" target="_blank"><i class="bi bi-github"></i>Sport Development</a></p>
                                <p><a class="bi bi-c-square-fill text-white"></i> 2018-2024 Todos los derechos reservados</a>
                            </div>
                            <div>
                                <p><a class="nav-link text-white" href="../public/" target="_blank"><i class="bi bi-cart-fill"></i> Sitio público</a></p>
                                <p><a class="bi bi-envelope-fill text-white"></i> dacasoft@outlook.com</a>
                            </div>
                        </div>
                    </nav>
                </footer>
            `);
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname.endsWith('index.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #245C9D;">
                        <div class="container">
                            <a class="navbar-brand text-white" href="index.html">
                                <img src="../../resources/img/logo.png" alt="inventory" width="50">
                                Sport Development
                            </a>
                        </div>
                    </nav>
                </header>
            `);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
                <footer>
                    <nav class="navbar fixed-bottom bg-dark">
                        <div class="container">
                            <p><a class="nav-link text-white" href="https://github.com/dacasoft/coffeeshop" target="_blank"><i class="bi bi-github"></i> Sport Development</a></p>
                            <a class="text-white"><i class="bi bi-envelope-fill text-white"></i> dacasoft@outlook.com</a>
                        </div>
                    </nav>
                </footer>
            `);
        } else {
            location.href = 'index.html';
        }
    }
}