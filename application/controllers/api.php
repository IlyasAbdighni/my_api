<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller{

  function __construct()
  {
      // Construct the parent class
      parent::__construct();
  }

  function students_get() {
    $students = array(
      1 => array("first_name" => "ilyas", "last_name" => "abdighni"),
      2 => array("first_name" => "ekberjan", "last_name" => "osman")
    );
    $this->response($students);

  }


}


 ?>
