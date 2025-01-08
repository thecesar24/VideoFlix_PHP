$(document).ready(function(){
    $('.slider-container').slick({
        infinite: true,
        slidesToShow: 3,  // Número de tarjetas visibles
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,  // Velocidad del desplazamiento
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

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById('eliminarContenido')) {
        document.getElementById('eliminarContenido').addEventListener('click', function(event) {
            console.log("Botón de eliminar contenido clickeado"); // Depuración
            if (!confirm('¿Estás seguro de que deseas eliminar el contenido?')) {
                event.preventDefault(); // Prevenir la acción predeterminada si el usuario cancela
            }
        });
    }
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

if (document.getElementById('youtube-iframe')) {
    let player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-iframe', {
            events: {
                onStateChange: onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING) {
            addToSeguirViendo();
        }
    }

    function addToSeguirViendo() {
        const xhr = new XMLHttpRequest();
        const baseURL = 'http://localhost/VideoFlix_PHP/';
        const url = baseURL + 'SeguirViendo/Add?slug=' + slug;
        
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send();

        // xhr.onreadystatechange = function () {
        //     if (xhr.readyState === 4 && xhr.status === 200) {
        //         console.log("Añadido a 'Seguir viendo'");
        //     } else if (xhr.readyState === 4) {
        //         console.error("Error al añadir a 'Seguir viendo'");
        //     }
        // };
    }
}

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

if (document.getElementById('año_nuevoContenido')) {
    
    document.addEventListener('DOMContentLoaded', function() {
        const añoInput = document.getElementById('año_nuevoContenido');

        const valor = añoInput.value;
        const partes = valor.split(' ');
        const año = partes[2]; 
        añoInput.value = año;
        añoInput.setAttribute('value', año);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const tipoContenido = document.getElementById("tipo_contenido");
        const duracionContainer = document.getElementById("duracion-container");
        const temporadasContainer = document.getElementById("temporadas-container");
        const capitulosContainer = document.getElementById("capitulos-container");
        const sinopsisContainer = document.getElementById("sinopsis-container");
        const puntuacionContainer = document.getElementById("puntuacion-container");

        tipoContenido.addEventListener("change", function () {
            const selectedValue = tipoContenido.value;

            duracionContainer.style.display = "none";
            temporadasContainer.style.display = "none";
            capitulosContainer.style.display = "none";
            sinopsisContainer.style.display = "block";
            puntuacionContainer.style.display = "block";

            if (selectedValue === "series") {
                temporadasContainer.style.display = "block";
                capitulosContainer.style.display = "block";
            } else {
                duracionContainer.style.display = "block";
            }

            if (selectedValue === "cortos" || selectedValue === "documentales") {
                sinopsisContainer.style.display = "none";
                puntuacionContainer.style.display = "none";
            }else {
                sinopsisContainer.style.display = "block";
                puntuacionContainer.style.display = "block";
            }
        });

        if (document.getElementById('reset-Button')) {
            document.getElementById('reset-Button').addEventListener('click', function() {

                document.getElementById('formulario_nuevo_contenido').reset();

                document.getElementById('duracion-container').style.display = 'block';
                document.getElementById('temporadas-container').style.display = 'none';
                document.getElementById('capitulos-container').style.display = 'none';

                document.getElementById('tipo_contenido').value = '';

                document.getElementById('titulo').value = '';
                document.getElementById('año_nuevoContenido').value = '';
                document.getElementById('sinopsis').value = '';
                document.getElementById('generos').value = '';
                document.getElementById('duracion').value = '';
                document.getElementById('temporadas').value = '';
                document.getElementById('capitulos').value = '';
                document.getElementById('nuevo_director').value = '';
                document.getElementById('puntuacion').value = '';
                document.getElementById('Poster').style.display = 'none';
            });
        }
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
        let mensajeDiv = document.getElementById('mensaje-temporal');
        if (mensajeDiv) {
            mensajeDiv.remove();
        }
    
        mensajeDiv = document.createElement('div');
        mensajeDiv.id = 'mensaje-temporal';
        mensajeDiv.textContent = mensaje;

        document.body.appendChild(mensajeDiv);

        setTimeout(() => {
            ocultarMensaje(mensajeDiv);
        }, 2000);
    }

    if (document.getElementById('tooltip')) {
        document.getElementById('tooltip-container').addEventListener('click', function(){
            const tooltip = document.getElementById('tooltip');

            if (tooltip.classList.contains('tooltip-clicked')) {
                tooltip.classList.remove('tooltip-clicked');
            } else {
                tooltip.classList.add('tooltip-clicked');
            }
        });
    }
};

if (document.querySelectorAll('.formulario-iniciar-sesion input')) {
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.formulario-iniciar-sesion input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (this.classList.contains('error-input')) {
                    this.classList.remove('error-input');
                }

                const errorSpan = this.nextElementSibling;
                if (errorSpan && errorSpan.classList.contains('error-span')) {
                    errorSpan.textContent = '';
                }
            });
        });
    });
}

if (document.getElementById('inputGroupFile01')) {
    
    document.addEventListener("DOMContentLoaded", function () {
        const inputFile = document.getElementById('inputGroupFile01');
        const imagePreview = document.getElementById('imagePreview');
        
        inputFile.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            if (file) {
                reader.readAsDataURL(file);
            }
            
            reader.onload = function() {
                imagePreview.src = '';
                imagePreview.src = reader.result;
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.temporadas button');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const temporada = this.getAttribute('data-temporada');
            mostrarCapitulos(temporada);
        });
    });

    function mostrarCapitulos(temporada) {
        const capitulos = document.querySelectorAll('.capitulos');
        capitulos.forEach(cap => cap.style.display = 'none'); 

        const capitulosTemporada = document.getElementById(`capitulos-temporada-${temporada}`);
        if (capitulosTemporada) {
            capitulosTemporada.style.display = 'block'; 
        }
    }
});