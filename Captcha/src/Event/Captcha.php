<?php

namespace Captcha\Event;

use Phire\Controller\AbstractController;
use Pop\Application;

class Captcha
{

    /**
     * Add CAPTCHA image for register form
     *
     * @param  AbstractController $controller
     * @param  Application        $application
     * @return void
     */
    public static function addCaptcha(AbstractController $controller, Application $application)
    {
        if (($controller->hasView()) && (null !== $controller->view()->form) &&
            ($controller->view()->form instanceof \Pop\Form\Form) && (null !== $controller->view()->form->getElement('captcha'))) {
            $captcha = new \Captcha\Model\Captcha($application->module('Captcha')['config']);
            $captcha->createToken();
            $controller->view()->form->getElement('captcha')->setToken($captcha->token, 'Enter Code');
        }
    }

}
