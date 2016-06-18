<?php
/**
 * Phire Captcha Module
 *
 * @link       https://github.com/phirecms/phire-captcha
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\Captcha\Event;

use Phire\Controller\AbstractController;
use Pop\Application;

/**
 * Captcha Event class
 *
 * @category   Phire\Captcha
 * @package    Phire\Captcha
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class Captcha
{

    /**
     * Add CAPTCHA image to form with a CAPTCHA field
     *
     * @param  AbstractController $controller
     * @param  Application        $application
     * @return void
     */
    public static function addCaptcha(AbstractController $controller, Application $application)
    {
        if (($controller->hasView()) && (null !== $controller->view()->form) && ($controller->view()->form !== false) &&
            ($controller->view()->form instanceof \Pop\Form\Form) && (null !== $controller->view()->form->getElement('captcha'))) {
            $captcha = new \Phire\Captcha\Model\Captcha($application->module('phire-captcha')['config']);
            $captcha->createToken();
            $controller->view()->form->getElement('captcha')->setToken($captcha->token, 'Enter Code');
        }
    }

}
