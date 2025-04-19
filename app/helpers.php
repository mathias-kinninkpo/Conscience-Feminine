<?php

if (! function_exists('setting')) {
    /**
     * Récupère une valeur de paramètre de configuration.
     *
     * @param string $key La clé du paramètre (par exemple "site_name")
     * @param mixed $default La valeur par défaut si le paramètre n'existe pas.
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // Ici, nous récupérons la valeur depuis le fichier de config "settings"
        return config('settings.' . $key, $default);
    }
}
