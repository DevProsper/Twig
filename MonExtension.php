<?php

/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 20/04/2018
 * Time: 16:32
 */
//Gère les fonctions et filter de twig
class MonExtension extends Twig_Extension
{

    public function getFonctions(){
        return [
            new Twig_SimpleFunction('markdowm', [$this, 'markdowmParse'], ['is_safe' => ['html']])
        ];
    }

    public function markdowmParse($value){
        return \Michelf\MarkdownExtra::defaultTransform($value);
    }

}