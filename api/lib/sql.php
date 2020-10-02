<?php
/* 
 * Funciones de uso común para las consultas a la base de datos,
 * orientado a API REST.
 *
 * Es importante que se inicialicen las variables 
 * $host_mysql, $basedatos, $usuario y $clave
 * en donde corresponda, antes de que alguna de estas funciones 
 * se ejecuten.
 *
 * ¡Que les sea muy útil!
 * 
 * ---------------------------------------------------------------------*
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                    Version 2, December 2004
 *
 * Copyright (C) 2017 Alexis Caffa <alexiscaffa@loquequieras>
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


function sql_command($sql_command) {
    global $host_mysql, $basedatos, $usuario, $clave;
    try {
        $mbd = new PDO("mysql:host=$host_mysql;dbname=$basedatos", $usuario, $clave);
        $statement = $mbd->prepare($sql_command);
        $statement->execute();
        return $statement;

    } catch (PDOException $e) {
        return "¡Error!: " . $e->getMessage();
    }
}

function query($sql_query) {
    $statement = sql_command($sql_query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function format_columns($columas_list) {
    $selector = '';
    foreach($columas_list as $columna=>$nombre)
    {
        if (!$nombre) {
            $nombre = $columna;
        }
        $selector .= ", $columna AS $nombre";
    }
    return substr($selector,2);
}

function build_query($columas_list, $tabla, $condition='') {
    $selector = format_columns($columas_list);
    if ($condition) {
        $condition .= "WHERE $condition";
    }
    return query("SELECT $selector from $tabla $condition;");
}

function insert($colum_value, $tabla) {
    global $host_mysql, $basedatos, $usuario, $clave;
    $colums = '';
    $values = '';
    foreach ($colum_value as $columna=>$valor) {
        $colums .= ", $columna";
        $valor = str_replace("'", "''", $valor);
        $values .= ", '$valor'";
    }
    $colums = substr($colums,2);
    $values = substr($values,2);
//    return ("INSERT INTO $tabla ($colums) VALUES ($values)");
    try {
        $mbd = new PDO("mysql:host=$host_mysql;dbname=$basedatos", $usuario, $clave);
        $statement = $mbd->prepare("INSERT INTO $tabla ($colums) VALUES ($values)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return "¡Error!: " . $e->getMessage();
    }
}
