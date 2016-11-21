<?php
/**
 * User: Sergey Safarov
 * Date: 02.14.2016
 */
namespace MVC;

use \MVC\Helpers\Arr;

/**
 * Class View
 * @package MVC
 */
class View
{
    const VIEWS_DIR = 'MVC/Views/';
    const EXT = '.phtml';

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * @var string|null
     */
    protected $_file = null;

    /**
     * @param string $file
     * @param array $data
     * @return View
     */
    public static function factory($file = null, array $data = array())
    {
        return new self($file, $data);
    }

    protected static $_global = array();

    public static function setGlobal($name, $value)
    {
        self::$_global[$name] = $value;
    }

    /**
     * @param string $file
     * @param array $data
     */
    public function __construct($file = null, array $data = array())
    {
        $this->_file = $file;
        $this->_data = Arr::merge($this->_data, $data);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->_data[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * @param string $file
     * @return string
     */
    public function render($file = null)
    {
        if (!is_null($file)) {
            $this->_file = $file;
        }
        extract(self::$_global);
        extract($this->_data);
        ob_start();

        $views_dir = get_template_directory() . DIRECTORY_SEPARATOR . self::VIEWS_DIR;
        require($views_dir . $this->_file . self::EXT);

        return ob_get_clean();
    }

    /**
     * @param string $name
     */
    public static function addCSS($name)
    {
        $href = get_template_directory_uri() . '/' . self::VIEWS_DIR . $name;
        if (did_action('admin_init')) {
            echo "<link rel='stylesheet' type='text/css' href='$href'/>";
        } else {
            wp_enqueue_style($name, $href);
        }
    }

    /**
     * @param string $name
     */
    public static function addJS($name)
    {
        if (\MVC\Helpers\Helper::is_protocol($name)) {
            $src = $name;
        } else {
            $src = get_template_directory_uri() . '/' . self::VIEWS_DIR . $name;
        }
        if (did_action('admin_init')) {
            echo "<script src='$src'></script>";
        } else {
            wp_enqueue_script($name, $src);
        }
    }

}