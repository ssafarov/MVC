<?php
namespace MVC\Helpers;

class Logs
{
    public static function error($type, $data = null)
    {
        $err = $type . ' :: ' . date('Y-m-d H:i:s') . ' :: ' . print_r($data, true) . "\n";

        $dir = wp_upload_dir();
        $file = '_fuel_' . date('Y-m-d') . '.log';
        file_put_contents($dir['basedir'] . '/' . $file, $err, FILE_APPEND);

        return error_log($err);
    }
}