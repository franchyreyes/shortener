<?php

if (!function_exists('generateKey')) {
    function generateKey($number)
    {
        $lenght = 52;
        $result = '';
        for ($index = 1; $number >= 0 && $index < 10; $index++) {
            $result = chr(0x41 + ($number % pow($lenght, $index) / pow($lenght, $index - 1))) . $result;
            $number -= pow($lenght, $index);
        }
        return $result;
    }
}
