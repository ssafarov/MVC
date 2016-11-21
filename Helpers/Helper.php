<?php

namespace MVC\Helpers;

/**
 * Class Helper
 * @package Blackhawk
 */
class Helper
{

    /**
     * @param string $file
     * @return bool
     */
    public static function is_protocol($file)
    {
        return (strpos($file, '://') !== false);
    }

    /**
     * @param array $data
     * @param string $container
     * @return string
     */
    public static function arrayToXml(array $data, $container = '')
    {
        $xml = '';
        if (!Arr::is_assoc($data) && $container) {
            foreach ($data as $value) {
                if (is_array($value)) {
                    $xml .= self::arrayToXml($value, $container);
                } else {
                    $value = htmlspecialchars($value); // todo ?
                    $xml .= "<$container>$value</$container>";
                }
            }

            return $xml;
        }

        foreach ($data as $name => $value) {
            if (is_array($value)) {
                $xml .= self::arrayToXml($value, $name);
            } else {
                $value = htmlspecialchars($value);
                $xml .= "<$name>$value</$name>";
            }
        }
        if ($container) {
            $xml = "<$container>$xml</$container>";
        }

        return $xml;
    }


    /**
     * @param string $xmlStr
     * @return array|string;
     */
    public static function xmlToArray($xmlStr)
    {
        $xml = simplexml_load_string($xmlStr);
        $xml2 = @simplexml_load_string((string)$xml);
        if ($xml2) {
            $xml = $xml2;

            return json_decode(json_encode((array)$xml), 1);
        }

        return (string)$xml;
    }

}
