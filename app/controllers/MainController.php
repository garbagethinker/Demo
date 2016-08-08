<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MainController
 *
 * @author twist
 */
require_once '../app/models/MainModel.php';

class MainController {

    private $model;

    public function __construct() {

        $this->model = new MainModel();
    }

    public function getMap() {
        require_once '../app/views/MainView.php';
        $this->model->getMap();
    }

    public function test() {
        require_once 'test.php';
    }

    public function fun() {
        require_once 'fun.php';
    }

}
