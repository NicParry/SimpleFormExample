<?php

namespace SimpleForm\Tests;


use Goutte\Client;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    public function testFormIsDisplayed()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://localhost');
        $this->assertCount(1, $crawler->filter('form'));
    }
}