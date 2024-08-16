<?php
/**
 * ---------------------------------------------------- *
 * @method remove all "extra" blank space from the given string.
 * @param  string  $value
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('removeAllSpaces')) {
    function removeAllSpaces($text)
    {
        return preg_replace('~(\s|\x{3164}|\x{1160})+~u', ' ', preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $text));
    }
}