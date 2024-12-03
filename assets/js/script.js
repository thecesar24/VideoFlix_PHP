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
};
