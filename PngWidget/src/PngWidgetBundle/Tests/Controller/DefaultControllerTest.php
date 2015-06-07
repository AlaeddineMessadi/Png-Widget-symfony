<?php

namespace PngWidgetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PngWidgetBundle\Classes\Color;
use PngWidgetBundle\Classes\Image;
use PngWidgetBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    //http://127.0.0.1:8000/web/app_dev.php/09a50fd6acdf3983da36988c804ae041/w100-h100-bC74343-tECF019
    
    /**
     * @var EntityManager
     */
    private $_em;

    protected function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
//        $this->_em->beginTransaction();
    }

        
    public function testRenderPng()
    {
        // Inisialise two users and insert them to the database
        $u1 = new User();
        $u1->setHash("Hash1");
        $u1->setStatus(true);
        if(!$this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>$u1->getHash()))){
            $this->_em->persist($u1);
            $this->_em->flush();
        }
        
        $client = static::createClient();
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u1->getHash()));
        // var_dump($entity);
        // $entity Existing User with enabled status 
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w100-h100-bC74343-tECF019');
//        var_dump('/'.$entity->getHash().'/w100-h100-bC74343-tECF019');
//        var_dump($client->getResponse()->getContent());
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($client->getResponse()->headers->contains(
                                                                    'Content-Type',
                                                                    'image/png'
                                                                    )
                         );
        
    }
    
    public function testUserDisabled()
    {
        $u2 = new User();
        $u2->setHash("Hash2");
        $u2->setStatus(false);
       if(!$this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>$u2->getHash()))){
            $this->_em->persist($u2);
            $this->_em->flush();
        }
        
        $client = static::createClient();
        //  Existing User with disabled status
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u2->getHash()));
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w100-h100-bC74343-tECF019');
        $this->assertEquals(403,$client->getResponse()->getStatusCode());  
        $this->assertTrue($client->getResponse()->isForbidden());
    }
    
    public function testUserNotFound()
    {
        $client = static::createClient();
        //  user not found
        
        $crawler = $client->request('GET', '/'.  md5("no one").'/w100-h100-bC74343-tECF019');
        $this->assertEquals(404,$client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isNotFound());
    }
    
    public function testWidthNotValid()
    {
        $u1 = new User();
        $u1->setHash("Hash1");
        $u1->setStatus(true);
        
        // try width 1000 which is > than 500
        $client = static::createClient();
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u1->getHash()));
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w1000-h100-bC74343-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("The Width must be between 100 and 500")')->count()
        );
    }
    
    public function testHeightNotValid()
    {
        $u1 = new User();
        $u1->setHash("Hash1");
        $u1->setStatus(true);
        
        // try height 1000 which is > than 500
        $client = static::createClient();
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u1->getHash()));
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w100-h1000-bC74343-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("The Height must be between 100 and 500")')->count()
        );
    }
    
    public function testHexBackgroundColor()
    {
        $u1 = new User();
        $u1->setHash("Hash1");
        $u1->setStatus(true);
        
        // try height 1000 which is > than 500
        $client = static::createClient();
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u1->getHash()));
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w100-h100-bRESDC-tECF019');
        $this->assertEquals(400,$client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Please check your backgroundcolor Hexa Code")')->count()
        );
    }
    
    public function testHexTextColor()
    {
        $u1 = new User();
        $u1->setHash("Hash1");
        $u1->setStatus(true);
        
        // try height 1000 which is > than 500
        $client = static::createClient();
        $entity = $this->_em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>  $u1->getHash()));
        $crawler = $client->request('GET', '/'.$entity->getHash().'/w100-h100-bC74343-tbest');
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
    
    
    /**
     * Rollback changes.
     */
    public function tearDown()
    {
//        $this->_em->rollback();
    }
}
