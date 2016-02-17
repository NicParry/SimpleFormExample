<?php

namespace SimpleForm\Template;

class TemplateEngine
{

    public function render($view, $data)
    {
        extract($data);
        include(ROOT . '/src/views/' . $view . '.php');
    }
}