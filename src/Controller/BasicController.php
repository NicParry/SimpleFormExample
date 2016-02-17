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
            $people = $this->getPeopleFromFormData($formData);
            $this->repo->savePeople($people);
            $message = 'Data successfully submitted';
        } else {
            $people = $this->repo->getAllPeople();
            $message = false;
        }
        $this->template->render('basic-input-form', array('message' => $message, 'people' => $people));
    }

    private function getPeopleFromFormData($formData)
    {
        $people = [];
        foreach ($formData['people'] as $submittedPerson) {
            $people[] = new Person($submittedPerson['firstname'], $submittedPerson['surname']);
        }
        return $people;
    }
}