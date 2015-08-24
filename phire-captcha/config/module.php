<?php
/**
 * Module Name: phire-captcha
 * Author: Nick Sagona
 * Description: This is the CAPTCHA module for Phire CMS 2
 * Version: 1.0
 */
return [
    'phire-captcha' => [
        'prefix'     => 'Phire\Captcha\\',
        'src'        => __DIR__ . '/../src',
        'routes'     => [
            '/captcha[/]' => [
                'controller' => 'Phire\Captcha\Controller\IndexController',
                'action'     => 'captcha',
            ]
        ],
        'install' => function() {
            copy(__DIR__ . '/../view/captcha.phtml', __DIR__ . '/../../phire/view/captcha.phtml');
        },
        'uninstall' => function() {
            if (file_exists(__DIR__ . '/../../phire/view/captcha.phtml')) {
                unlink(__DIR__ . '/../../phire/view/captcha.phtml');
            }
        },
        'config'     => [
            'expire'      => 300,
            'length'      => 4,
            'width'       => 71,
            'height'      => 26,
            'lineSpacing' => 5,
            'lineColor'   => [175, 175, 175],
            'textColor'   => [0, 0, 0],
            'font'        => null,
            'size'        => 0,
            'rotate'      => 0
        ],
        'events' => [
            [
                'name'   => 'app.send.pre',
                'action' => 'Phire\Captcha\Event\Captcha::addCaptcha'
            ]
        ]
    ]
];
