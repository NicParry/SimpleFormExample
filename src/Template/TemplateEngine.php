<?php

namespace SimpleForm\Template;

class TemplateEngine
{

    public function render($view, $data)
    {
        extract($data);
        include(ROOT . DS . 'src' . DS . 'views' . DS . $view . '.php');
    }
}