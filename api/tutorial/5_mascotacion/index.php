<?php
/* 
 * Se podría sustituir la palabra «mascotacion» por «personas».
 * 
 * Esta hace una consulta combinando 2 tablas programáticamente y 
 * en "Arrays json" ← la nueva del PHP xD
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
 * 
 * ---------------------------------------------------------------------*
 * 
 * La palabra «mascotacion» (con asento en la o), proviene de la palabra
 * «programacion»; solo que al sustituir "programa" por "mascota",
 * luego, no fue ya mas posible sustituir "programacion" por "personas"
 * 
 * xD
 */

include "../cabeceras.php";
include "../../lib/sql.php";

/*  Ejemplo:
 *      /api/v1/mascotacion/
 */

$mascotacion = query("SELECT * FROM mascotacion ORDER BY ID DESC");
$mascotas = query("SELECT * FROM mascotas");

foreach ($mascotacion as $i=>$casa) {
    $mascotacion[$i]['mascota'] = getMascota($casa['mascota']);
}

die(json_encode($mascotacion));



/*
 * Region de funciones
 */

function getMascota($id) {
    global $mascotas;
    foreach ($mascotas as $i=>$mascota) {
        if ($id==$mascota['ID']) {
            // Hacer que la imagen se envie completamente.
            $mascota['imagen'] = 'https://dummyimage.com/256x256/000000/ff8000.jpg&text=' . $mascota['nombre'];
            return $mascota;
        }
    }
    return $id;
}
