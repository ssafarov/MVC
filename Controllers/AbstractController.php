<?php
namespace MVC\Controllers;

use MVC\Helpers\Arr;

abstract class AbstractController
{
    protected $post;

    public function __construct()
    {
        $this->setPost();
    }

    /**
     * @param string $action
     * @return string
     */
    public function render($action)
    {
        $action .= 'Action';

        return $this->$action();
    }


    protected function setPost()
    {
        $this->post = $_POST;
        if (!isset($_POST['data']) || !is_array($_POST['data'])) {
            return $this->post;
        }

        if (Arr::is_assoc($_POST['data'])) {
            $data = $_POST['data'];
        } else {
            $data = [];
            foreach ($_POST['data'] as $item) {
                $data[$item['name']] = $item['value'];
            }
        }

        $this->post = Arr::merge($_POST, $data);

        return $this->post;
    }
}