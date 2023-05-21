<?php
final class MyLib {
    private static $ffi = null;
    function __construct() {
        if (is_null(self::$ffi)) {
            self::$ffi = FFI::scope("MyLib");
        }
    }
    function fibonacci($number) {
       return (int)self::$ffi->fibonacci($number);
    }
    function fibonacci_loop($repeat, $number) {
       return (int)self::$ffi->fibonacci_loop($repeat, $number);
    }
}