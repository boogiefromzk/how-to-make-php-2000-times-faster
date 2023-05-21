<?php
FFI::load(dirname(__DIR__) . "/mylib/mylib.h");
opcache_compile_file(__DIR__ . "/mylib.php");