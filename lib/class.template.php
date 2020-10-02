<?php
/* 
 * PHP templates
 *
 * Este código es tan simple como complejo al mismo tiempo,
 * y reside en la CALIDAD de implementar un sistema de plantillas
 * con variables en un leguaje púramente de plantillado como es PHP.
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

class Template {

    public $template;

    function __construct($filepath)
    {
        if ($filepath) {
            $this->load($filepath);
        }
    }

    function load($filepath) {

        $this->template = file_get_contents($filepath);

    }

    function replace($var, $content) {

        $this->template = str_replace('{'.$var.'}', $content, $this->template);

    }

    function parse() {

        return $this->template;

    }

}
