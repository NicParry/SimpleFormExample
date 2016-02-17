<?php

namespace SimpleForm\Tests;


use Goutte\Client;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->setUpFixtures();
    }

    public function testFormIsDisplayed()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $this->assertCount(1, $crawler->filter('form'));
    }

    public function testFormValuesAreDerivedFromFile()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $form = $crawler->selectButton('OK')->form();
        $values = $form->getValues();
        $this->assertEquals('Leonard', $values['people[0][firstname]']);
        $this->assertEquals('Hofstader', $values['people[0][surname]']);

        $this->assertEquals('Sheldon', $values['people[1][firstname]']);
        $this->assertEquals('Cooper', $values['people[1][surname]']);

        $this->assertEquals('Raj', $values['people[2][firstname]']);
        $this->assertEquals('Koothrapali', $values['people[2][surname]']);

        $this->assertEquals('Howard', $values['people[3][firstname]']);
        $this->assertEquals('Wolowitz', $values['people[3][surname]']);

        $this->assertEquals('Penny', $values['people[4][firstname]']);
        $this->assertEquals('', $values['people[4][surname]']);
    }

    public function testSubmitFormOk()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $form = $crawler->selectButton('OK')->form();
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatus());
        $this->assertEquals('Data successfully submitted', $crawler->filter('.message')->text());
    }

    public function testSubmitFormDisplaysNewValues()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $form = $crawler->selectButton('OK')->form();
        $formValues = array(
            'people[0][firstname]' => 'Leslie',
            'people[0][surname]' => 'Winkle'
        );
        $crawler = $client->submit($form, $formValues);
        $form = $crawler->selectButton('OK')->form();
        $values = $form->getValues();
        $this->assertEquals('Leslie', $values['people[0][firstname]']);
        $this->assertEquals('Winkle', $values['people[0][surname]']);
    }

    private function setUpFixtures()
    {
        $people = [
            ['Leonard', 'Hofstader'],
            ['Sheldon', 'Cooper'],
            ['Raj', 'Koothrapali'],
            ['Howard', 'Wolowitz'],
            ['Penny', ''],
        ];

        $fh = fopen('/vagrant/src/Entity/people-store.csv', "w");
        foreach ($people as $person) {
            fputcsv($fh, array($person[0], $person[1]), ',');
        }
    }
}