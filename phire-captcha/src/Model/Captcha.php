<?php

namespace Phire\Captcha\Model;

use Phire\Model\AbstractModel;
use Pop\Filter\Random;
use Pop\Image\Gd;
use Pop\Web\Session;

class Captcha extends AbstractModel
{

    /**
     * Create CAPTCHA token
     *
     * @param  int $reload
     * @return Captcha
     */
    public function createToken($reload = null)
    {
        $sess     = Session::getInstance();
        ob_start();
        include __DIR__ . '/../../../phire/view/captcha.phtml';
        $captcha = ob_get_clean();

        // If reload, or captcha token doesn't exist, create new one
        if ((null !== $reload) || !isset($sess->pop_captcha)) {
            $token = [
                'captcha' => $captcha,
                'value'   => Random::create($this->length, Random::ALPHANUM|Random::UPPERCASE),
                'expire'  => (int)$this->expire,
                'start'   => time()
            ];
            $sess->pop_captcha = serialize($token);
        // Else, check existing token
        } else {
            $token = unserialize($sess->pop_captcha);
            if ($token['value'] == '') {
                $token = [
                    'captcha' => $captcha,
                    'value'   => Random::create($this->length, Random::ALPHANUM|Random::UPPERCASE),
                    'expire'  => (int)$this->expire,
                    'start'   => time()
                ];
                $sess->pop_captcha = serialize($token);
            // Check to see if the token has expired
            } else  if ($token['expire'] > 0) {
                if (($token['expire'] + $token['start']) < time()) {
                    $token = [
                        'captcha' => $captcha,
                        'value'   => Random::create($this->length, Random::ALPHANUM|Random::UPPERCASE),
                        'expire'  => (int)$this->expire,
                        'start'   => time()
                    ];
                    $sess->pop_captcha = serialize($token);
                }
            }
        }

        $this->token = $token;
        return $this;
    }

    /**
     * Create CAPTCHA image
     *
     * @return Captcha
     */
    public function createImage()
    {
        $image = new Gd('captcha.gif', $this->width, $this->height);
        $image->setBackgroundColor(255, 255, 255);
        $image->draw()->setStrokeColor($this->lineColor[0], $this->lineColor[1], $this->lineColor[2]);

        // Draw background grid
        for ($y = $this->lineSpacing; $y <= $this->height; $y += $this->lineSpacing) {
            $image->draw()->line(0, $y, $this->width, $y);
        }

        for ($x = $this->lineSpacing; $x <= $this->width; $x += $this->lineSpacing) {
            $image->draw()->line($x, 0, $x, $this->height);
        }

        $image->effect()->border($this->textColor, 0.5);
        $image->type()->setFillColor($this->textColor[0], $this->textColor[1], $this->textColor[2]);

        if (null === $this->font) {
            $image->type()->size(5);
            $textX = round(($this->width - ($this->length * 10)) / 2);
            $textY = round(($this->height - 16) / 2);
        } else {
            $image->type()->font($this->font)
                  ->size($this->size);
            $textX = round(($this->width - ($this->length * ($this->size / 1.5))) / 2);
            $textY = round($this->height - (($this->height - $this->size) / 2) + ((int)$this->rotate / 2));
        }
        $image->type()->xy($textX, $textY)
              ->text($this->token['value']);

        $this->image = $image;

        return $this;
    }

}