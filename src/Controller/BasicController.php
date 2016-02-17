<?php

namespace SimpleForm\Controller;


use SimpleForm\Entity\Person;
use SimpleForm\Entity\PersonRepo;
use SimpleForm\Template\TemplateEngine;

class BasicController
{
    /**
     * @var TemplateEngine
     */
    private $template;
    /**
     * @var PersonRepo
     */
    private $repo;

    public function __construct(TemplateEngine $templateEngine, PersonRepo $repo)
    {
        $this->template = $templateEngine;
        $this->repo = $repo;
    }

    public function formAction($method, $formData = array())
    {
        if ($method === 'POST') {
            $message = 'Data successfully submitted';
            $people = [];
            $fh = fopen(ROOT . DS . 'src' . DS . 'Entity' . DS . 'people-store.csv', "w");
            foreach ($formData['people'] as $submittedPerson) {
                $people[] = new Person($submittedPerson['firstname'], $submittedPerson['surname']);
                fputcsv($fh, array($submittedPerson['firstname'], $submittedPerson['surname']), ',');
            }
        } else {
            $message = false;
            $people = [];
            $fileContents = file_get_contents(ROOT . DS . 'src' . DS . 'Entity' . DS . 'people-store.csv');
            $lines = explode("\n", $fileContents);
            for ($i = 0; $i < count($lines) - 1; $i++) {
                $line = $lines[$i];
                $attr = explode(",", $line);
                $people[] = new Person($attr[0], $attr[1]);
            }
        }
        $this->template->render('basic-input-form', array('message' => $message, 'people' => $people));
    }
}