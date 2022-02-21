<?php

/**
 * Definicion de las functiones de Validacion de los datos
 *
 * Archivo que define las funciones con las que se validan los datos
 * del ejercicio.
 *
 * PHP version 7.4
 * @author     Michel Castillo <xthjan@gmail.com>
 * @version    1.0
 */


/**
 * Esta function valida la longitud de un campo, si el campo no es requerido
 * entonces y el valor vacio, entonces no ejecuta la validacion
 * @param FormCampo &$campo  Referencia del campo a validarse.
 * @return boolean Retorno opcional si el campo es valido o no despúes del método
 * @author Michel Castillo <xthjan@gmail.com>
 */
function ValidarLongitud(&$campo, $minimo = 2, $maximo = 150)
{
    //Asignacion del valor a una variable local para mejor manejo
    $campoValor = $campo->valor;
    //Si el campo no es requerido, y esta vacio, entonces no se valida.
    if (!$campo->esRequerido && trim($campoValor) == "") {
        array_push($campo->info, "El " . $campo->leyenda . " no es requerido, y viene vacío");
        return;
    }
    //Si la longitud del valor es menor o igual al minimo, se guarda un error en los errorres del campo,
    if (strlen($campoValor) <= $minimo) {
        array_push($campo->mensajesError, "El campo " . $campo->leyenda . " es muy corto");
    }
    //Si la longitud del valor es menor o igual al maximo, se guarda un error en los errorres del campo
    if (strlen($campoValor) >= $maximo) {
        array_push($campo->mensajesError, "El " . $campo->leyenda . " es muy largo");
    }

    //Si no existe ningun error identificado, guardamos una leyenda de campo valido.
    if (count($campo->mensajesError) == 0) {
        array_push($campo->info, "El " . $campo->leyenda . " se encuentra dentro de la longitud esperada.");
        return true;
    }
    return false;
}

/**
 * Esta function valida la longitud de un NIF español, además 
 * identifica el tipo de dato DNI, NIE, NIF persona física, NIF persona moral
 * 
 * @param FormCampo &$campo  Referencia del campo a validarse.
 * @author Michel Castillo <xthjan@gmail.com>
 */
function ValidarDNI(&$campo)
{
    //Se valida la longitud del DNI/NIE, si no es valido, retorna.
    if (!ValidarLongitud($campo, 8, 10)) {
        return;
    };

    //Asignacion del valor a una variable local para mejor manejo
    $campoValor = $campo->valor;
    //Se extrae el primer dígito
    $primerDigito = substr($campoValor, 0, 1);

    //Si el primer digito es númerico, el valor es un DNI, retorna
    if (is_numeric($primerDigito)) {
        array_push($campo->info, "Se ha introducido un DNI");
        return;
    }

    //Arreglo para identificar NIF persona física 
    $arregloNIF = array("K", "L", "M", "X", "Y", "Z");

    //Se busca el primer dígito, si no se encuentra es un NIF de persona física, retorna
    if (!array_search($primerDigito, $arregloNIF)) {
        array_push($campo->info, "Se ha introducido un NIF de persona moral");
        return;
    }

    //Arreglo para identificar NIE
    $arregloNIE = array("X", "Y", "Z");
    if (array_search($primerDigito, $arregloNIE)) {
        array_push($campo->info, "Se ha introducido un NIE");
        return;
    }
    array_push($campo->info, "Se ha introducido un NIF de persona física");
}

/**
 * Esta function valida la longitud y composicón de un password
 * 
 * @param FormCampo &$campo  Referencia del campo a validarse.
 * @author Michel Castillo <xthjan@gmail.com>
 */
function ValidarPassword(&$campo)
{
    //Se valida la longitud del password, si no es valido, retorna.
    if (!ValidarLongitud($campo, 7, 17)) {
        array_push($campo->mensajesError, "El campo " . $campo->leyenda . " debe tener entre 8 y 16 espacios");
        return;
    };
    //Asignacion del valor a una variable local para mejor manejo
    $campoValor = $campo->valor;

    //Si no existe una minúscula, agrego el error
    if (!preg_match('/[a-z]/',    $campoValor)) {
        array_push($campo->mensajesError, "El " . $campo->leyenda . " no contiene minúsculas");
    } else {
        array_push($campo->info, "El " . $campo->leyenda . " tiene al menos una minúscula");
    }
    //Si no existe una número, agrego el error
    if (!preg_match('/\d/',          $campoValor)) {
        array_push($campo->mensajesError, "El " . $campo->leyenda . " no contiene números");
    } else {
        array_push($campo->info, "El " . $campo->leyenda . " tiene al menos un número");
    }
    //Si no existe una mayúscula, agrego el error
    if (!preg_match('/[A-Z]/',          $campoValor)) {
        array_push($campo->mensajesError, "El " . $campo->leyenda . " no contiene mayúsculas");
    } else {
        array_push($campo->info, "El " . $campo->leyenda . " tiene al menos una mayúscula");
    }
}


/**
 * Esta function valida la edad de la persona en un rago de entre 5 y 120 años
 * 
 * @param FormCampo &$campo  Referencia del campo a validarse.
 * @author Michel Castillo <xthjan@gmail.com>
 */
function ValidarEdad(&$campo)
{
    //Se valida la longitud de la fecha, si no es valido, retorna.
    if (!ValidarLongitud($campo, 9, 11)) {
        return;
    };
    //Asignacion del valor a una variable local para mejor manejo
    $campoValor = $campo->valor;
    //Creo una fecha con formato localizado.
    $date = new DateTime($campoValor);
    $edad = date_diff($date, new DateTime())->y;

    if ($edad < 5) {
        array_push($campo->mensajesError, "Tu edad es " . $edad . " años, no deberías usar este formulario");
    }
    if ($edad > 120) {
        array_push($campo->mensajesError, "Tu edad es " . $edad . " años, ya no deberías usar este formulario");
    }
    if (count($campo->mensajesError) > 0) {
        array_push($campo->mensajesError, "El campo " . $campo->leyenda . " debe proveer de una edad entre 5 y 120 años");
    } else {
        array_push($campo->info, "Tu edad esta entre los 5 y los 120 años");
        array_push($campo->info, "Tu edad es " . $edad . " años");
    }
}
