<?php

namespace SimpleForm\Controller;


class BasicController
{
    public function formAction()
    {
        include(ROOT . DS . 'src' . DS . 'views' . DS . 'basic-input-form.php');
    }
}