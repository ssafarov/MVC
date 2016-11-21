<?php
namespace MVC;

trait Singleton
{
    /**
     * @return $this
     */
    public static function instance()
    {
        static $instance;
        if (is_null($instance)) {
            $instance = new static();
        }

        return $instance;
    }
}