<?php

/**
 * Created by PhpStorm.
 * User: Eklect
 * Date: 3/5/2016
 * Time: 1:05 PM
 */
class CapController extends \Phalcon\Mvc\Controller {

    public function indexAction(){
        $this->assets->addJs('/js/CAP');
    }
    
}