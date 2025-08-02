<?php

if (! function_exists('create_slug')) {
    /**
     * Creates a slug for a given string.
     *
     * @param  string  $string  The string to create a slug from.
     * @return string The generated slug.
     */
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

if (! function_exists('has_results')) {
    /**
     * Checks if a section has results.
     *
     * @param  object  $section  The section to check.
     * @return int Returns true if results are found, otherwise returns false.
     */
    function has_results($section) {
        // Checa si hay campos con resultado
        foreach ($section->fields as $field) {
            if (!empty($field->result)) {
                return true;
            }
        }
        // Checa subsecciones recursivamente
        if (isset($section->subSections)) {
            foreach ($section->subSections as $subSection) {
                if (has_results($subSection)) {
                    return true;
                }
            }
        }
        return false;
    }
}
