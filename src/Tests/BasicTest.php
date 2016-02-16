<?php

namespace SimpleForm\Tests;


use Goutte\Client;

class BasicTest extends \PHPUnit_Framework_TestCase
{

    public function testFirst()
    {
        $client = new Client();
        $client->request('GET', 'http://localhost');
        $this->assertEquals('Dummy index.php output', $client->getResponse()->getContent());
    }
}