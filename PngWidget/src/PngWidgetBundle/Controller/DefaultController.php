<?php

namespace PngWidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\BrowserKit\Response;
use PngWidgetBundle\Classes\Image;
use PngWidgetBundle\Classes\Color;

class DefaultController extends Controller
{
    public function indexAction($hash,$width,$height,$background,$textColor)
    {
       $em = $this->getDoctrine()->getManager();
       $image = new Image($width,$height,$background,$textColor);
       // other way to check and validate parameters instead using regix requirements in route
       $verify =  $image->checkParams();
       if( !is_bool($verify) ) {
            $response = new Response();
            $response->setContent("<html><head><title>HTTP BAD REQUEST</title><body><h1>$verify</h1></body></html>");
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->headers->set('Content-Type', 'text/html');
            // prints the HTTP headers followed by the content
            $response->send(); die;
       }
       // get user by hash
       $user = $em->getRepository('PngWidgetBundle:User')->findOneBy(array('hash'=>$hash));
       if ($user){
            // Check user status 
            if(!$user->getStatus()) {
                $response = new Response();
                $response->setContent("<html><head><title>FORBIDDEN</title><body><h1>Your Account is Disabled</h1></body></html>");
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
                $response->headers->set('Content-Type', 'text/html');
                // prints the HTTP headers followed by the content
                $response->send(); die;
            }
            
            $response = new Response();
            // Create the image
            $im = $this->createImage($image);
            // Set headers
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', 'image/png');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . basename(''.$im) . '";');

            // Send headers before outputting anything
            $response->sendHeaders();
            $response->send(); die;
            //return $response;
        }
        return new Response("User Not Found");
    }
    
    
    // create Image
    private function createImage($image){
        // creating Image
        $im = @ImageCreate ($image->getWidth(), $image->getHeight())
            or die ("Can not create a new GD image stream");
        $bgColor = new Color($image->getBackgroundColor());
        // Get color by red green blue from Hexa and assign background color to the image
        $background_color = ImageColorAllocate ($im, "0x".$bgColor->getRed(), "0x".$bgColor->getGreen(), "0x".$bgColor->getBlue());
        $textColor = new Color($image->getTextColor());
        // Get color by red green blue from Hexa and assign text color to the image
        $text_color = ImageColorAllocate ($im,"0x".$textColor->getRed(), "0x".$textColor->getGreen(), "0x".$textColor->getBlue());
        // put random text to the image and align it in the center based on width lenght text lenght plus the% and font size 
        ImageString ($im, $image->getWidth()/100, ($image->getWidth()/2)-(strlen($image->getText())+10), ($image->getHeight()/2)-3, $image->getText()."%", $text_color);
        ImagePNG ($im);
        return $im;
    }
    
    private function response($message){
        $response = new Response();
        $response->setContent("<html><body><h1>$message</h1></body></html>");
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        $response->headers->set('Content-Type', 'text/html');
        // prints the HTTP headers followed by the content
        $response->send();
        return $response;
    }
}
