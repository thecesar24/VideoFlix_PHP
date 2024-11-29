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

window.onload = function() {

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
        }, 3000); // 3 segundos antes de comenzar a ocultar
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
                    console.log('Estado de favorito actualizado: ' + favorito + ' idContenido: ' + idContenido);
                } else {
                    console.log('Hubo un error al actualizar el estado.');
                }
            };
        });
    });
    

};
    

