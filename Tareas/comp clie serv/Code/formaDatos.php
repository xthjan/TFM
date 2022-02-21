<?php

/**
 * Definicion de clases FormaDatos y la clase interna FormaCampo
 *
 * Archivo que define las dos clases de datos con las que se construira la interfaz,
 * se validarán los datos, y se mostrán los datos al usuario
 *
 * PHP version 7.4
 * @author     Michel Castillo <xthjan@gmail.com>
 * @version    1.0
 */


/**
 * Clase que define un campo en la forma
 *
 * Esta clase define las propiedades y valor de un campo en la forma.
 *
 * @author     Michel Castillo <xthjan@gmail.com>
 */
class FormCampo
{
    /**
     * Propiedad del valor del campo
     */
    public $valor;
    /**
     * Propiedad Arreglo de errores de validacion, si existen, del valor.
     */
    public $mensajesError;
    /**
     * Propiedad que indica el tipo de campo que se refiere
     */
    public $tipo;
    /**
     * Propiedad que guarda la leyenda que será mostrada en la página.
     */
    public $leyenda;
    /**
     * Propiedad que indica si un campo es requerido o no.
     */
    public $esRequerido;
     /**
     * Propiedad que guarda información de la validacion.
     */
    public $info;


    /**
     * Esta función estática del la clase campo, inicializa una instancia de la clase y la devuelve.
     * 
     * @param object  $valor        Valor del campo.
     * @param string  $tipo         Tipo del campo.
     * @param string  $leyenda      Leyenda del campo.
     * @param boolean $esRequerido  (optional) Indica si el campo es requerido.
     * @return FormCampo Regresa una instancia de la clase con las propiedades definidas.
     * @author Michel Castillo <xthjan@gmail.com>
     */
    public static function CrearDesdeString($valor, $tipo, $leyenda, $esRequerido = false)
    {
        $instancia = new self();
        $instancia->valor = $valor;
        $instancia->tipo = $tipo;
        $instancia->leyenda = $leyenda;
        $instancia->mensajesError = [];
        $instancia->esRequerido = $esRequerido;
        $instancia->info = [];
        return $instancia;
    }
}


/**
 * Clase que define la forma y sus campos
 *
 * Esta clase define la forma, sus campos
 *
 * @author     Michel Castillo <xthjan@gmail.com>
 */
class FormDatos
{
    /**
     * Arreglo dinámico de los datos
     */
    public $campos = [];
    /**
     * Propiedad que indica la forma tiene algún error.
     */
    var bool $tieneError = false;


    /**
     * Esta función estática del la clase campo, inicializa una instancia de la clase y la devuelve.
     * 
     * @param Array  $objPost  Instancia de un arreglo con la coleccion de los campos definidos y su valor, puede ser el objeto $_POST.
     * @return FormDatos Regresa una instancia de la clase con las propiedades definidas.
     * @author Michel Castillo <xthjan@gmail.com>
     */
    public static function CrearInstancia($objPost)
    {
        $instancia = new self();
        $instancia->campos["nombre"] = FormCampo::CrearDesdeString($objPost["nombre"] ?? null, "text", "Nombre", true);
        $instancia->campos["apellidos"] = FormCampo::CrearDesdeString($objPost["apellidos"] ?? null, "text", "Apellido(s)");
        $instancia->campos["email"] = FormCampo::CrearDesdeString($objPost["email"] ?? null, "email", "Correo Electronico", true);
        $instancia->campos["fechaNacimiento"] = FormCampo::CrearDesdeString($objPost["fechaNacimiento"] ?? null, "date", "Fecha de Nacimiento", true);
        $instancia->campos["password"] = FormCampo::CrearDesdeString($objPost["password"] ?? null, "password", "Password", true);
        $instancia->campos["dni"] = FormCampo::CrearDesdeString($objPost["dni"] ?? null, "text", "DNI", true);
        $instancia->campos["tel"] = FormCampo::CrearDesdeString($objPost["tel"] ?? null, "tel", "Teléfono", true);
        $instancia->campos["url"] = FormCampo::CrearDesdeString($objPost["url"] ?? null, "url", "Web Site");
        return $instancia;
    }

    /**
     * Function Interna que busca algun error en los campos y cambia su propiedad
     * 
     * @author Michel Castillo <xthjan@gmail.com>
     */
    public function ValidarForma(){
        while(current($this->campos) && !$this->tieneError){
            $this->tieneError = count(current($this->campos)->mensajesError)>0;
            next($this->campos);
        }
    }
}
