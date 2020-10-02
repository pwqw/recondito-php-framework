<?php
/* 
 * Un insertado en la base de datos
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

include "../../lib/sql.php";
/*
$data = [
    'nombre'=> 'Cosme Fulanito',
    'texto' => "¡¡Argentina tricampeón!!",
    'IDD'   => 578,
    'ver'   => 'si',
    'IP'    => '0.1.2.3',
];

die(insert($data, 'comentarios'));
*/

sql_command("UPDATE comentarios SET IDD='625' WHERE id=38");
