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

  function users_get() {
    $user_id = $this->uri->segment(3);
    $this->load->model("Model_internal_users");
    // $users = array(
    //   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
    //   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
    // );
    $users = $this->Model_internal_users->get_by(array("idInternalUser" => $user_id ));
    if (isset($users["idInternalUser"])) {
      $this->response(array("status" => "success", "message" => $users), 200);
    } else {
      $this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
    }


  }

  function user_put() {
    $this->load->library("form_validation");
    $this->form_validation->set_data($this->put());
    if ($this->form_validation->run("user_put") != false) {
      die("good data!");
    } else {
      die("bad data!");
    }
  }


}


 ?>
