<?php

/**
 * Converts an integer into the alphabet base (A-Z).
 *
 * @param int $number This is the number to convert.
 * @return string 
 * 
 */
if (!function_exists('generateKey')) {
    function generateKey($number)
    {
        $lenght = 26;
        $result = '';
        for ($index = 1; $number >= 0 && $index < 10; $index++) {
            $result = chr(0x41 + ($number % pow($lenght, $index) / pow($lenght, $index - 1))) . $result;
            $number -= pow($lenght, $index);
        }
        return $result;
    }
}
