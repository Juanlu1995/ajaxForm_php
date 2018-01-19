function comprobarErrores() {
    let miXHR = new XMLHttpRequest();


    let nombre = document.getElementById('nombre');
    let apellidos = document.getElementById('apellidos');
    let edad = document.getElementById('edad');
    let form = document.getElementById('formulario');

    function crearError(errores, elemento) {
        let elementoPadre = $(elemento).parent();
        let mostrarError;

        for (let error of errores) {

            mostrarError =
                ` <div class="alert alert-danger alert-dismissible error" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>${error}</strong>
                </div>`;

            elementoPadre.append(mostrarError);
        }
    }

    function imprimirErrores(errores) {

        if (errores.erroresNombre.length > 0) {
            if ($(nombre).next(".error").length === 0) {
                crearError(errores.erroresNombre, nombre);
            } else {
                $(nombre).nextAll().remove();
                crearError(errores.erroresNombre, nombre);
            }
        } else {
            $(nombre).nextAll().remove();
        }

        if (errores.erroresApellidos.length > 0) {
            if ($(apellidos).next(".error").length === 0) {
                crearError(errores.erroresApellidos, apellidos);
            } else {
                $(apellidos).nextAll().remove();
                crearError(errores.erroresApellidos, apellidos);
            }
        } else {
            $(apellidos).nextAll().remove();

        }

        if (errores.erroresEdad.length > 0) {
            if ($(edad).nextAll(".error").length === 0) {
                crearError(errores.erroresEdad, edad);
            } else {
                $(edad).nextAll().remove();
                crearError(errores.erroresEdad, edad);
            }
        } else {
            $(edad).nextAll().remove();

        }

    }


    function estadoPeticion(e) {
        if (miXHR.readyState == 4 && miXHR.status == 200) {
            let erroresParseados = JSON.parse(miXHR.responseText);
            if (erroresParseados.erroresNombre.length > 0 || erroresParseados.erroresApellidos.length > 0 || erroresParseados.erroresEdad.length > 0) {
                imprimirErrores(erroresParseados);
                e.preventDefault();
                return false;
            }
        }
    }


    function erroresFormulario(e) {
        let datos = `nombre=${nombre.value}&apellidos=${apellidos.value}&edad=${edad.value}&ajax=ajax`;
        miXHR.open('POST', '/');
        miXHR.onreadystatechange = function (e) {
            estadoPeticion(e);
        };
        miXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        miXHR.send(datos);
    }

    nombre.addEventListener('change', () => erroresFormulario());
    apellidos.addEventListener('change', () => erroresFormulario());
    edad.addEventListener('change', () => erroresFormulario());
    form.addEventListener('submit', function (e) {
        erroresFormulario(e);
    });

}

window.onload = comprobarErrores();
