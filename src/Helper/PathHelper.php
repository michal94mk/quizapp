<?php

namespace App\Helper;

class PathHelper {
    private static $basePath = __DIR__ . '/../../views/';

    public static function view($path) {
        return self::$basePath . $path;
    }

    public static function layout($path) {
        return self::$basePath . 'layouts/' . $path;
    }
}
