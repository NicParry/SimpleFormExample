<?php

namespace SimpleForm\Tests;


use Goutte\Client;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testFormIsDisplayed()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $this->assertCount(1, $crawler->filter('form'));
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
}