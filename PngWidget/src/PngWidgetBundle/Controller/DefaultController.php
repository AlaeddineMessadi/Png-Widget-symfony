<?php

namespace PngWidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PngWidgetBundle\Classes\Image;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
       $em = $this->getDoctrine()->getManager();
       $image = new Image($width,$height,$background,$textColor);
       // get user by hash
       $user = $em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>$hash));
       if ($user){
            // Check user status 
            if(!$user->getStatus()) return New Response ("Your account is Disabled");
            
            $response = new Response();
            // Create the image
            $im = $this->createImage($image);
            // Set headers
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', 'image/png');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . basename(''.$im) . '";');

            // Send headers before outputting anything
            $response->sendHeaders();
            return $response;
        }
        return new Response("User Not Found");
    }
}
