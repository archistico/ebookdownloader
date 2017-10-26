<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OpereControllerTest extends WebTestCase
{
    public function testNuovaopera()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nuovaopera');
    }

    public function testListaopere()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listaopere');
    }

}
