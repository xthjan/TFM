<?php

/**
 * Formulario de Validacion
 *
 * Archivo del ejercicio de validacion del formulario.
 *
 * PHP version 7.4
 * @author     Michel Castillo <xthjan@gmail.com>
 * @version    1.0
 */

//Inicio Sesion
session_start();
//Incluyo los archivos necesarios
include 'formaDatos.php';
include 'validarForma.php';

//Se crea una instancia del formulario
$formaLocal = FormDatos::CrearInstancia([]);


//Si es un post, entonces aplicacamos las validaciones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $formaLocal;
    $formaLocal = FormDatos::CrearInstancia($_POST);
    ValidarLongitud($formaLocal->campos["nombre"]);
    ValidarLongitud($formaLocal->campos["apellidos"]);
    ValidarLongitud($formaLocal->campos["email"], 8, 120);
    ValidarLongitud($formaLocal->campos["tel"], 6, 20);
    ValidarLongitud($formaLocal->campos["url"], 5, 520);
    ValidarDNI($formaLocal->campos["dni"]);
    ValidarPassword($formaLocal->campos["password"]);
    ValidarEdad($formaLocal->campos["fechaNacimiento"]);
    $formaLocal->ValidarForma();
    //Si la forma no tiene error, entonces redirecciono a la página de forma valida
    if (!$formaLocal->tieneError) {
        $_SESSION['datosValidados'] = serialize($formaLocal);
        header('Location: formaValida.php');
    }else{
        reset($formaLocal->campos);
    }
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

        .error-validacion {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
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
        <form class="well form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="contacto">
            <section class="panel panel-default">
                <fieldset>
                    <section class="panel-body">
                        <?php
                        //Si la forma tiene error muestro una alerta
                        if ($formaLocal->tieneError) {
                        ?>
                            <section class="alert alert-danger" role="alert" id="errorMessage">Ha ocurrido un error de
                                validacion con los datos enviados</section>
                        <?php
                        }
                        ?>
                    
                        <?php 
                        //Creación automática de los campos en base a los campos asignados en la forma
                        while ($campo = current($formaLocal->campos)) {
                            $index = array_search(key($formaLocal->campos), array_keys($formaLocal->campos));
                            if ($index == 0 or $index % 2 == 0) {
                                echo '<div class="form-group row">';
                            }
                        ?>
                            <section class="col-md-6 col-xs-12">
                                <label class="control-label" for="<?php echo key($formaLocal->campos) ?>"><?php echo $campo->leyenda ?></label>
                                <input id="<?php echo key($formaLocal->campos) ?>" type="<?php echo $campo->tipo ?>" name="<?php echo key($formaLocal->campos) ?>" placeholder="<?php echo $campo->leyenda ?>" class="form-control" <?php if (isset($campo->valor)) echo 'value="' . $campo->valor . '"'; ?> <?php if ($campo->esRequerido) echo "required"; ?>>

                                <?php if (isset($formaLocal->campos["nombre"]->mensajesError)) {
                                    //Si existen mensajes de error los muestro
                                    foreach ($campo->mensajesError as $mensajeError) {
                                ?>
                                        <section class="error-validacion">
                                            <?php echo $mensajeError ?>
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
                                <button type="submit" class="btn btn-success">Enviar Formulario</button>
                            </section>
                        </section>
                    </section>
                </fieldset>
            </section>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#fechaNacimiento').attr("max", new Date().toISOString().split("T")[0])
        });
    </script>
</body>

</html>