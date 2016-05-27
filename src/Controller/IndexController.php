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
namespace Phire\Captcha\Controller;

use Phire\Captcha\Model;
use Phire\Controller\AbstractController;

/**
 * Captcha Index Controller class
 *
 * @category   Phire\Captcha
 * @package    Phire\Captcha
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class IndexController extends AbstractController
{

    /**
     * Captcha action method
     *
     * @return void
     */
    public function captcha()
    {
        $captcha = new Model\Captcha($this->application->module('phire-captcha')['config']);
        $captcha->createToken($this->request->getQuery('reload'))
                ->createImage();

        $this->prepareView('image.phtml');
        $this->view->image = $captcha->image;
        $this->response->setBody($this->view->render());

        $this->send(200, ['Content-Type' => 'image/gif']);
    }

    /**
     * Prepare view
     *
     * @param  string $template
     * @return void
     */
    protected function prepareView($template)
    {
        $this->viewPath = __DIR__ . '/../../view';
        parent::prepareView($template);
    }

}
