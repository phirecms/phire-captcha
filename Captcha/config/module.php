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
                'action'     => 'index',
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
                'name'   => 'app.send',
                'action' => 'Captcha\Model\Captcha::register'
            ]
        ]
    ]
];
