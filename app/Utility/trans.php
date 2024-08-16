<?php

/**
 * ---------------------------------------------------- *
 * @method tr
 * @summary normal translate
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('tr')) {
    function tr($words, $data = [])
    {
        $text = '';
        $explodeWord = explode(',', $words);
        foreach ($explodeWord as $key => $value) {
            $text .= $key === 0 ? __($value, $data) : ' ' . __($value, $data);
        }
        return removeAllSpaces($text);
    }
}

/**
 * ---------------------------------------------------- *
 * @method tr_first
 * @summary first letter translate
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('tr_first')) {
    function tr_first($words, $data = [])
    {
        $text = '';
        $explodeWord = explode(',', $words);
        foreach ($explodeWord as $key => $value) {
            $text .= $key === 0 ? ucfirst(__($words, $data)) : ' ' . ucfirst(__($words, $data));
        }
        return removeAllSpaces($text);
    }
}

/**
 * ---------------------------------------------------- *
 * @method tr_uc
 * @summary ucwords translate
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('tr_uc')) {
    function tr_uc($words, $data = [])
    {
        $text = '';
        $explodeWord = explode(',', $words);
        foreach ($explodeWord as $key => $value) {
            $text .= $key === 0 ? ucwords(__($words, $data)) : ' ' . ucwords(__($words, $data));
        }
        return removeAllSpaces($text);
    }
}

/**
 * ---------------------------------------------------- *
 * @method tr_lower
 * @summary str to lower translate
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('tr_lower')) {
    function tr_lower($words, $data = [])
    {
        $text = '';
        $explodeWord = explode(',', $words);
        foreach ($explodeWord as $key => $value) {
            $text .= $key === 0 ? strtolower(__($words, $data)) : ' ' . strtolower(__($words, $data));
        }
        return removeAllSpaces($text);
    }

}

/**
 * ---------------------------------------------------- *
 * @method tr_upper
 * @summary str to upper translate
 * @return string
 * ---------------------------------------------------- *
 */
if (!function_exists('tr_upper')) {
    function tr_upper($words, $data = [])
    {
        $text = '';
        $explodeWord = explode(',', $words);
        foreach ($explodeWord as $key => $value) {
            $text .= $key === 0 ? strtoupper(__($words, $data)) : ' ' . strtoupper(__($words, $data));
        }
        return removeAllSpaces($text);
    }
}