<?php
/* 
 * Consulta simple a la base de datos, 
 * se le agrega un campo manual
 * y se construye un JSON artesanal al final.
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

$artesanias = query("SELECT * FROM artesanias"); // WHERE home REGEXP '^[0-9]+$' order by orden ASC, id ASC

foreach($artesanias as $i => $artesania) {
    $artesanias[$i]['imagen'] = 'https://dummyimage.com/256x256/000000/ff8000.jpg&text=Imágen ejemplo';
}

$json_artesanias = json_encode($artesanias);

die('{
    "version": '. crc32($json_artesanias) .',
    "artesanias": '. $json_artesanias .'    
}');
