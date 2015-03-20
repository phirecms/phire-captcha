<?php
/**
 * Module Name: Captcha
 * Author: Nick Sagona
 * Description: This is the CAPTCHA module for Phire CMS 2
 * Version: 1.0
 */
return [
    'Captcha' => [
        'prefix'     => 'Captcha\\',
        'src'        => __DIR__ . '/../src',
        'routes'     => [
            '/captcha[/]' => [
                'controller' => 'Captcha\Controller\IndexController',
                'action'     => 'captcha',
            ]
        ],
        'install'    => 'Captcha\Event\Captcha::install',
        'uninstall'  => 'Captcha\Event\Captcha::uninstall',
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
                'name'   => 'app.send',
                'action' => 'Captcha\Event\Captcha::addCaptcha'
            ]
        ]
    ]
];
