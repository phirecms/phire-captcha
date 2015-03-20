<?php

namespace Captcha\Event;

class Captcha
{

    /**
     * Add CAPTCHA image for register form
     *
     * @param  \Phire\Controller\AbstractController $controller
     * @param  \Phire\Application                   $application
     * @return void
     */
    public static function addCaptcha(\Phire\Controller\AbstractController $controller, \Phire\Application $application)
    {
        if (($controller->hasView()) && (null !== $controller->view()->form) &&
            ($controller->view()->form instanceof \Pop\Form\Form) && (null !== $controller->view()->form->getElement('captcha'))) {
            $captcha = new self($application->module('Captcha')['config']);
            $captcha->createToken();
            $controller->view()->form->getElement('captcha')->setToken($captcha->token, 'Enter Code');
        }
    }

}