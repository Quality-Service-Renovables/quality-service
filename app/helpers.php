<?php

if (! function_exists('create_slug')) {
    function create_slug(string $string): string
    {
        // Primero, reemplazar los caracteres no latinos por "-"
        $slug = preg_replace('~[^\pL\d]+~u', '_', $string);

        // A continuación, transcribimos cualquier carácter latino a ASCII
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

        // Entonces, eliminamos los caracteres indeseables
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        // Finalmente, convertimos el slug a minúscula y lo recortamos
        return strtolower(trim($slug, '-'));
    }
}
