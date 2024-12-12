$(document).ready(function(){
    $('.slider-container').slick({
        infinite: true,
        slidesToShow: 3,  // Número de tarjetas visibles
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,  // Velocidad del desplazamiento
        responsive: [
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
});

function ocultarMensaje(elemento) {
    if (!elemento) return;
    elemento.style.opacity = "0"; // Reduce opacidad a 0
    console.log("Iniciando transición de ocultación."); // Depuración
    setTimeout(() => {
        elemento.style.display = "none"; // Oculta después de la transición
        console.log("Mensaje oculto."); // Confirmación en consola
    }, 500); // Tiempo suficiente para permitir la transición
}

// Mensaje temporal
const mensajeTemporal = document.getElementById('mensaje-temporal');
if (mensajeTemporal) {
    mensajeTemporal.addEventListener("click", function() {
        ocultarMensaje(mensajeTemporal);
    });
    setTimeout(() => {
        ocultarMensaje(mensajeTemporal);
    }, 2000); // 3 segundos antes de comenzar a ocultar
}

// Ocultar mensajes de error automáticamente
const errorElements = document.querySelectorAll('.error');
errorElements.forEach(errorElement => {
    errorElement.addEventListener("click", function() {
        ocultarMensaje(errorElement);
    });
    setTimeout(() => {
        ocultarMensaje(errorElement);
    }, 3000); // Oculta automáticamente después de 3 segundos
});

if (document.getElementById('mostrar-comentarios')) {
    document.getElementById('mostrar-comentarios').addEventListener('click', function () {
        const comentarios = document.getElementById('comentarios');
        
        if (comentarios.style.display === 'flex') {
            comentarios.style.opacity = '0'; // Cambiar opacidad a 0 para transición
            setTimeout(() => {
                comentarios.style.display = 'none'; // Ocultar después de la transición
            }, 500); // Tiempo igual al de la transición en CSS
        } else {
            comentarios.style.display = 'flex'; // Mostrar inmediatamente
            setTimeout(() => {
                comentarios.style.opacity = '1'; // Cambiar opacidad para mostrar
            }, 0); // Pequeño retraso para activar la transición
        }
    });
    
    const inputComentario = document.getElementById('idComentario');
    const contador = document.getElementById('contador');
    const maxLength = inputComentario.getAttribute('maxlength');
    
    inputComentario.addEventListener('input', function () {
        const currentLength = inputComentario.value.length;
        contador.textContent = `${currentLength}/${maxLength}`;
    });    
}

// window.addEventListener('message', function(event) {
//     // Asegurarse de que el mensaje provenga del iframe de OK.ru
//     if (!event.data || typeof event.data !== 'object') return;

//     // Verificar el tipo de mensaje
//     if (event.data.type === 'player_state') {
//         switch (event.data.state) {
//             case 'playing':
//                 console.log('El video está reproduciéndose.');
//                 break;
//             case 'paused':
//                 console.log('El video está en pausa.');
//                 break;
//             case 'ended':
//                 console.log('El video ha terminado.');
//                 break;
//             default:
//                 console.log('Estado desconocido:', event.data.state);
//         }
//     }
// });

// // Enviar comandos al reproductor si lo necesitas
// function sendCommandToPlayer(command) {
//     const iframe = document.getElementById('youtube-iframe');
//     iframe.contentWindow.postMessage({ method: command }, '*');
// }

// Detectar el enlace activo al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.paginas-buttons .nav-link');
    
    // Obtén el path actual de la URL (sin dominio)
    const currentPath = window.location.pathname;

    links.forEach(link => {
        const linkPath = new URL(link.href).pathname;

        // Si es la URL base, activa solo el enlace de inicio
        if (currentPath === '/' || currentPath === '/VideoFlix_PHP/') {
            if (link.id === 'inicio') {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        } 
        // Para otras rutas, activa el enlace que coincida
        else if (linkPath === currentPath) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }

        // Cambia la clase activa al hacer clic
        link.addEventListener('click', () => {
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const añoInput = document.getElementById('año_nuevoContenido');

    const valor = añoInput.value;
    const partes = valor.split(' '); // Divide la cadena en partes usando espacios
    const año = partes[2]; // La tercera parte es el año
    añoInput.value = año;
});

document.addEventListener("DOMContentLoaded", function () {
    const tipoContenido = document.getElementById("tipo_contenido");
    const duracionContainer = document.getElementById("duracion-container");
    const temporadasContainer = document.getElementById("temporadas-container");
    const capitulosContainer = document.getElementById("capitulos-container");

    tipoContenido.addEventListener("change", function () {
        const selectedValue = tipoContenido.value;

        duracionContainer.style.display = "none";
        temporadasContainer.style.display = "none";
        capitulosContainer.style.display = "none";

        if (selectedValue === "series") {
            temporadasContainer.style.display = "block";
            capitulosContainer.style.display = "block";
        } else {
            duracionContainer.style.display = "block";
        }
    });

    document.getElementById('reset-Button').addEventListener('click', function() {
        // Restablecer todos los valores de los campos del formulario
        document.getElementById('formulario_nuevo_contenido').reset();

        // Restablecer la visibilidad de los campos según el tipo de contenido
        document.getElementById('duracion-container').style.display = 'block';
        document.getElementById('temporadas-container').style.display = 'none';
        document.getElementById('capitulos-container').style.display = 'none';

        // Restablecer el valor del select a su opción predeterminada
        document.getElementById('tipo_contenido').value = ''; // Cambiar a otro valor si lo prefieres

        // Reiniciar todos los inputs y valores, incluyendo los valores vacíos de texto
        document.getElementById('titulo').value = '';
        document.getElementById('año_nuevoContenido').value = '';
        document.getElementById('sinopsis').value = '';
        document.getElementById('generos').value = '';
        document.getElementById('duracion').value = '';
        document.getElementById('temporadas').value = '';
        document.getElementById('capitulos').value = '';
        document.getElementById('nuevo_director').value = '';
        document.getElementById('puntuacion').value = '';
    });
});

window.onload = function() {

    document.querySelectorAll('.favorito').forEach(item => {
        item.addEventListener('click', function() {
            const isFavorite = this.classList.contains('clicked');
            
            this.classList.toggle('clicked');

            const favorito = isFavorite ? 0 : 1; 

            const idContenido = this.getAttribute('data-id');

            const baseURL = 'http://localhost/VideoFlix_PHP/';
            const url = baseURL + 'ContenidoFavorito/AniadirFavorito';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.send('favorito=' + favorito + '&idContenido=' + idContenido);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const mensaje = response.mensaje;

                    // Mostrar el mensaje al usuario
                    mostrarMensaje(mensaje);

                    console.log('Estado de favorito actualizado: ' + favorito + ' idContenido: ' + idContenido);
                } else {
                    console.log('Hubo un error al actualizar el estado.');
                }
            };
        });
    });

    function mostrarMensaje(mensaje) {
        // Verificar si ya hay un mensaje temporal y eliminarlo
        let mensajeDiv = document.getElementById('mensaje-temporal');
        if (mensajeDiv) {
            mensajeDiv.remove();
        }
    
        // Crear un nuevo div para el mensaje
        mensajeDiv = document.createElement('div');
        mensajeDiv.id = 'mensaje-temporal';
        mensajeDiv.textContent = mensaje;

        document.body.appendChild(mensajeDiv);

        setTimeout(() => {
            ocultarMensaje(mensajeDiv);
        }, 2000);
    }

    document.getElementById('tooltip-container').addEventListener('click', function(){
        const tooltip = document.getElementById('tooltip');
    
        if (tooltip.classList.contains('tooltip-clicked')) {
            tooltip.classList.remove('tooltip-clicked');
        } else {
            tooltip.classList.add('tooltip-clicked');
        }
    });
    
};
