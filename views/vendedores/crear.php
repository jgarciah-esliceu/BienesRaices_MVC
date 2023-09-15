<main class="contenedor seccion">
        <h1>Registrar Vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form action="/vendedores/crear" method="POST" class="formulario">
            <?php include 'formulario.php'; ?>
            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
        </form>
</main>