<?php

namespace Captcha\Controller;

use Captcha\Model;
use Phire\Controller\AbstractController;

class IndexController extends AbstractController
{

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $captcha = new Model\Captcha($this->application->module('Captcha')['config']);
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