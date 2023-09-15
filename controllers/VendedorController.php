<?php

namespace Controllers;
use Model\Vendedor;
use MVC\Router;

class VendedorController {
    public static function crear(Router $router) {
        
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
    
            // Validar que no haya campos vacios
            $errores = $vendedor->validar();
    
            // No hay errores
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar() {
        echo "Actualizar Vendedor";
    }

    public static function eliminar() {
        echo "Eliminar Vendedor";
    }
}