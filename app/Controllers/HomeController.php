<?php

namespace App\Controllers;


class HomeController extends BaseController {

    /**
     * Ruta / donde se muestra la página de inicio del proyecto.
     *
     * @return string Render de la página
     */
    public function getIndex() {
        return $this->render('formulario.twig', []);
    }


    public function postIndex() {
        $erroresNombre = [];
        $erroresApellidos = [];
        $erroresEdad = [];

        $regExp = "/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$/";


        if (!empty($_POST)) {

            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $edad = $_POST['edad'];

            if (!empty($nombre)) {
                if (strlen($nombre) < 4) {
                    array_push($erroresNombre, 'El nombre tiene que tener un mínimo de 3 letras');
                }
                if (preg_match($regExp, $nombre) == 0) {
                    array_push($erroresNombre, 'El nombre solo puede contener letras y espacios');
                }
                if (ctype_lower(substr($nombre, 0, 1))) {
                    array_push($erroresNombre, 'La primera letra tiene que estar en mayusculas');
                }
            } else {
                array_push($erroresNombre, 'El nombre está vacío');
            }

            if (!empty($apellidos)) {
                if (strlen($apellidos) < 6) {
                    array_push($erroresApellidos, 'El apellido tiene que tener un mínimo de 5 letras');
                }
                if (preg_match($regExp, $apellidos) == 0) {
                    array_push($erroresApellidos, 'Los apellidos solo puede contener letras y espacios');
                }
                if ($apellidos == $nombre) {
                    array_push($erroresApellidos, "El apellido no puede tener el mismo valor que el nombre");
                }
                if (preg_match("/[[:space:]]/", $apellidos) == 0) {
                    array_push($erroresApellidos,'Los apellidos tienen que tener, al menos, un espacio en blanco');
                }
            } else {
                array_push($erroresApellidos, 'El apellido está vacío');
            }

            if (!empty($edad)){
                if (!settype($edad,'int')){
                    array_push($erroresEdad,'La edad no es numérica');
                }
                if ($edad < 19){
                    array_push($erroresEdad,'La edad debe ser mayor de 18');
                }
            }else{
                array_push($erroresEdad,'La edad no puede estar vacía');
            }


            if (isset($_POST['ajax'])) {
                echo json_encode($errores = [$erroresNombre,$erroresApellidos,$edad]);
            } else {
                return $this->render("formulario.twig", [
                    'erroresNombre' => $erroresNombre,
                    'erroresApellidos' => $erroresApellidos,
                    'erroresEdad' => $erroresEdad
                    ]);
            }
        }

        if (isset($_POST['ajax'])) {
            echo json_encode(['formularioVacio'=>'El formulario está vacío']);
        } else {
            return $this->render("formulario.twig", ['formularioVacio' => "El formulario está vacío"]);
        }
    }
}