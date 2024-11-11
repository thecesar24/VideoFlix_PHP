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
        item.addEventListener('click', function(event) {
            event.preventDefault();  // Prevenir la acción predeterminada de enlaces
            
            // Alternar la clase 'clicked' para cambiar el estado del favorito
            this.classList.toggle('clicked');
        });
    });
    

};
    

