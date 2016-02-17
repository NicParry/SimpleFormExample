<?php
/**
 * Created by PhpStorm.
 * User: nicholasp
 * Date: 2016/02/17
 * Time: 7:25 PM
 */

namespace SimpleForm\Entity;


class PersonRepo
{
    public function getAllPeople()
    {
        $people = [];
        $fileContents = file_get_contents(ROOT . '/src/Entity/people-store.csv');
        $lines = explode("\n", $fileContents);
        for ($i = 0; $i < count($lines) - 1; $i++) {
            $line = $lines[$i];
            $attr = explode(",", $line);
            $people[] = new Person($attr[0], $attr[1]);
        }

        return $people;
    }

    /**
     * @param $people Person[]
     */
    public function savePeople($people)
    {
        $fh = fopen(ROOT . '/src/Entity/people-store.csv', "w");
        foreach ($people as $person)
        {
            fputcsv($fh, array($person->getFirstName(), $person->getSurname()), ',');
        }
    }
}