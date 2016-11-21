<?php

namespace MVC\Helpers;

/**
 * Class Arr
 * @package MVC\Helpers
 */
class Arr
{

    /**
     * @param array $array
     * @return bool
     */
    public static function is_assoc(array $array)
    {
        // Keys of the array
        $keys = array_keys($array);

        // If the array keys of the keys match the keys, then the array must
        // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
        return array_keys($keys) !== $keys;
    }

    /**
     * @param $array1
     * @param $array2
     * @return array
     */
    public static function merge($array1, $array2)
    {
        if (Arr::is_assoc($array2)) {
            foreach ($array2 as $key => $value) {
                if (is_array($value)
                    AND isset($array1[$key])
                    AND is_array($array1[$key])
                ) {
                    $array1[$key] = Arr::merge($array1[$key], $value);
                } else {
                    $array1[$key] = $value;
                }
            }
        } else {
            foreach ($array2 as $value) {
                if (!in_array($value, $array1, true)) {
                    $array1[] = $value;
                }
            }
        }

        if (func_num_args() > 2) {
            foreach (array_slice(func_get_args(), 2) as $array2) {
                if (Arr::is_assoc($array2)) {
                    foreach ($array2 as $key => $value) {
                        if (is_array($value)
                            AND isset($array1[$key])
                            AND is_array($array1[$key])
                        ) {
                            $array1[$key] = Arr::merge($array1[$key], $value);
                        } else {
                            $array1[$key] = $value;
                        }
                    }
                } else {
                    foreach ($array2 as $value) {
                        if (!in_array($value, $array1, true)) {
                            $array1[] = $value;
                        }
                    }
                }
            }
        }

        return $array1;
    }

}
