<?php

class Functions
{

    public static function contains($str, $content, $ignorecase = true)
    {
        if ($ignorecase) {
            $str = strtolower($str);
            $content = strtolower($content);
        }
        if (strpos($str, $content) === false) {
            return false;
        } else {
            return true;
        }
    }
}
?>