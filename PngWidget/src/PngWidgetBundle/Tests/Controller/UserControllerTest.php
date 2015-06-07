<?php

namespace PngWidgetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/user/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'pngwidgetbundle_user[hash]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $hash = md5('Test');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("'.$hash.'")')->count());

        
        
        $crawler = $client->click($crawler->selectLink('edit')->link());
        var_dump($client->getResponse()->getContent());
        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

    }

    
}
