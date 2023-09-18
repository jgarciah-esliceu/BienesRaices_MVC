<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if(empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if(!$resultado) {
                    // Mensaje de error si no existe el usuario
                    $errores = Admin::getErrores();
                } else {
                    // Verificar si la contraseña es correcta
                    $autenticado = $auth->comprobarPassword($resultado);

                    if($autenticado) {
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        // Muestra un mensaje de error si la contraseña es incorrecta
                        $errores = Admin::getErrores();
                    }
                }
            }
        }

        $router->render('/auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout() {
        echo "Desde logout";
    }
}