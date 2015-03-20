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

    /**
     * Install method
     */
    public static function install()
    {
        copy(__DIR__ . '/../../view/captcha.phtml', __DIR__ . '/../../../phire/view/captcha.phtml');
    }

    /**
     * Uninstall method
     */
    public static function uninstall()
    {
        if (file_exists(__DIR__ . '/../../../phire/view/captcha.phtml')) {
            unlink(__DIR__ . '/../../../phire/view/captcha.phtml');
        }
    }

}