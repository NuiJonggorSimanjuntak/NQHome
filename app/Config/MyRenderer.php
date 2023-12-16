<?php

namespace Config;

use Kenjis\CI4Twig\TwigRenderer;

class MyRenderer extends TwigRenderer
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // Initialize Twig
        $loader = new \Kenjis\CI4Twig\TwigLoader();
        $this->twig = new \Kenjis\CI4Twig\TwigEnvironment($loader, [
            'cache' => WRITEPATH . 'cache',
            'debug' => ENVIRONMENT !== 'production',
        ]);
    }
}
