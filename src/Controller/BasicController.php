<?php

namespace SimpleForm\Controller;


class BasicController
{
    public function formAction($method)
    {
        if ($method === 'POST') {
            $message = 'Data successfully submitted';
        } else {
            $message = false;
        }
        include(ROOT . DS . 'src' . DS . 'views' . DS . 'basic-input-form.php');
    }
}