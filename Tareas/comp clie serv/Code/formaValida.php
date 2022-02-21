<?php

/**
 * Página de forma Valida
 *
 * Archivo del ejercicio de validacion del formulario que muestra el resultado de la validacion de los campos.
 *
 * PHP version 7.4
 * @author     Michel Castillo <xthjan@gmail.com>
 * @version    1.0
 */


//Inicio Sesion
session_start();
include 'formaDatos.php';
$formaLocal = FormDatos::CrearInstancia([]);

//Se obtiene la forma desde session
if (isset($_SESSION['datosValidados'])) {
    global $formaLocal;
    $formaLocal = unserialize($_SESSION["datosValidados"]);
    unset($_SESSION['datosValidados']);
}
else{
    header("Location:index.php");
}
?>


<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Realización de una página web utilizando PHP</title>
    <style>
        .panel {
            margin-top: 25px;
            border: solid #333 1px;
            padding: 30px 20px;
            border-radius: 5px;
        }

        .nav-title .small {
            clear: both;
            font-size: 1em;
            display: block;
            color: #999;
        }

        .info-validacion {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
        }

        .control-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light nav-title">
            <section class="navbar-brand mb-0 h1">Fomulario de práctica PHP</section>
            <section class="small"> Introduce tus datos para validación</section>
        </nav>
    </header>
    <section class="container">
        <section class="panel panel-default">
            <fieldset>
                <section class="panel-body">
                    <?php while ($campo = current($formaLocal->campos)) {
                        $index = array_search(key($formaLocal->campos), array_keys($formaLocal->campos));
                        if ($index == 0 or $index % 2 == 0) {
                            echo '<div class="form-group row">';
                        }
                    ?>
                        <section class="col-md-6 col-xs-12">
                            <label class="control-label" for="<?php echo key($formaLocal->campos) ?>"><?php echo $campo->leyenda ?></label>
                            <label id="<?php echo key($formaLocal->campos) ?>">
                                <?php if (isset($campo->valor)) echo $campo->valor; ?>
                            </label>
                            <?php if (isset($formaLocal->campos["nombre"]->info)) {
                                    //Si existen mensajes de error los muestro
                                    foreach ($campo->info as $info) {
                                ?>
                                        <section class="info-validacion text-success">
                                            <?php echo $info ?>
                                        </section>
                                <?php   }
                                } ?>
                        </section>
                    <?php if ($index % 2 != 0) {
                            echo '</div>';
                        }
                        next($formaLocal->campos);
                    } ?>

                    <section class="form-group row">
                        <section class="col-md-6 col-xs-12">
                            <button type="button" id="btnRegresar" class="btn btn-primary">Regresar</button>
                        </section>
                    </section>
                </section>
            </fieldset>
        </section>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnRegresar').on("click", function() {
                window.location = "index.php";
            });
        });
    </script>
</body>

</html>