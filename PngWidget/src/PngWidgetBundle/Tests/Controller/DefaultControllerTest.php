<?php

namespace PngWidgetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PngWidgetBundle\Classes\Color;
use PngWidgetBundle\Classes\Image;

class DefaultControllerTest extends WebTestCase
{
    //http://127.0.0.1:8000/web/app_dev.php/2d87b0018eaff7a8cf7cf63d5c067e44/w100-h100-bC74343-tECF019
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/hello/Fabien');
//
//        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
        
    public function testRenderPng()
    {
        $client = static::createClient();
        // 1d87b0018eaff7a8cf7cf63d5c067e44 Existing User with enabled status 
        $crawler = $client->request('GET', '/1d87b0018eaff7a8cf7cf63d5c067e44/w100-h100-bC74343-tECF019');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($client->getResponse()->headers->contains(
                                                                    'Content-Type',
                                                                    'image/png'
                                                                    )
                         );
    }
    
    public function testUserDisabled()
    {
        $client = static::createClient();
        // 9193ce3b31332b03f7d8af056c692b84 Existing User with disabled status 
        $crawler = $client->request('GET', '/9193ce3b31332b03f7d8af056c692b84/w100-h100-bC74343-tECF019');
        $this->assertEquals(403,$client->getResponse()->getStatusCode());  
        $this->assertTrue($client->getResponse()->isForbidden());
    }
    
    public function testUserNotFound()
    {
        $client = static::createClient();
        // 2d87b0018eaff7a8cf7cf63d5c067e44 user not found
        $crawler = $client->request('GET', '/2d87b0018eaff7a8cf7cf63d5c067e44/w100-h100-bC74343-tECF019');
        $this->assertEquals(404,$client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isNotFound());
    }
    
    public function testWidthNotValid()
    {
        // try width 1000 which is > than 500
        $client = static::createClient();
        $crawler = $client->request('GET', '/1d87b0018eaff7a8cf7cf63d5c067e44/w1000-h100-bC74343-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("The Width must be between 100 and 500")')->count()
        );
    }
    
    public function testHeightNotValid()
    {
        // try height 1000 which is > than 500
        $client = static::createClient();
        $crawler = $client->request('GET', '/1d87b0018eaff7a8cf7cf63d5c067e44/w100-h1000-bC74343-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("The Height must be between 100 and 500")')->count()
        );
    }
    
    public function testHexBackgroundColor()
    {
        // try height 1000 which is > than 500
        $client = static::createClient();
        $crawler = $client->request('GET', '/1d87b0018eaff7a8cf7cf63d5c067e44/w100-h100-bRESDC-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Please check your backgroundcolor Hexa Code")')->count()
        );
    }
    
    public function testHexTextColor()
    {
        // try height 1000 which is > than 500
        $client = static::createClient();
        $crawler = $client->request('GET', '/1d87b0018eaff7a8cf7cf63d5c067e44/w100-h100-bC74343-tbest');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Please check your TextColor Hexa Code")')->count()
        );
    }
    
    public function testColor() {
        $im = new Image(100, 100, 'FFF', 'FEF');
        $bgcolor = new Color($im->getBackgroundColor());
        $textcolor = new Color($im->getTextColor());
        
        $this->assertEquals("FFFFFF", $bgcolor->getRed().$bgcolor->getGreen().$bgcolor->getBlue());
        $this->assertEquals("FFEEFF", $textcolor->getRed().$textcolor->getGreen().$textcolor->getBlue());
    }
    
    public function testHex() {
        $color = new Color("FAE");
        $this->assertEquals("FF", $color->getRed());
        $this->assertEquals("AA", $color->getGreen());
        $this->assertEquals("EE", $color->getBlue());
    }
    
    
}
