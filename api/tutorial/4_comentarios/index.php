<?php
/* 
 * Esta es una validación de parámetros que vienen,
 * y una query a la base de datos bien piola
 * 
 * ---------------------------------------------------------------------*
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                    Version 2, December 2004
 *
 * Copyright (C) 2017 pwqw <no@email>
 *
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 */

include "../cabeceras.php";
include "../../lib/sql.php";

/*
 *  Parametros:
 *      - [cosa] {Entero} indica la cosa a la que pertenecen
 *
 *  Ejemplo:
 *      /api/v1/comentarios/?cosa=559
 */

if ( valid_params_or_die() ) {

    $data = getComentarios($_GET["cosa"]);

    die(json_encode($data));
}



/*
 * Region de funciones
 */

function valid_params_or_die() {
    $errores = [];

    $cosa=$_GET["cosa"];
    if(strlen($cosa)>10){ array_push($errores,'{"id":"0","parametro":"cosa","mensaje":"Error en longitud del parametro"}'); }
    if(!is_numeric($cosa)){ array_push($errores,'{"id":"1","parametro":"cosa","mensaje":"Error en el tipo de parametro"}'); }
    if(!((int) $cosa == $cosa)){ array_push($errores,'{"id":"2","parametro":"cosa","mensaje":"Error en el tipo de parametro debe ser entero"}') ;}
    if($cosa<1){ array_push($errores,'{"id":"3","parametro":"cosa","mensaje":"Error en el rango de parametro"}') ;}

    if ($errores) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            header("HTTP/1.0 405 Method Not Allowed");
        }
        die('{ "errores": [ '. join(',', $errores) .' ] }');
    }
    return true;
}

function getComentarios($cosa) {
    $CATIDAD = 100;

    $columnas = format_columns([
        'comentarios.ID'=>'id',
        'comentarios.nombre'=>'nombre',
        'comentarios.texto'=>'texto',
    ]);
    return query("SELECT $columnas FROM comentarios
        WHERE ver='si' AND comentarios.IDD = $cosa
        ORDER BY comentarios.ID DESC 
        LIMIT $CATIDAD OFFSET 0");
}
