<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller{

  function __construct()
  {
      // Construct the parent class
      parent::__construct();
      $this->load->helper("my_api");
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
      $this->response(array("status" => "success", "message" => $users), REST_Controller::HTTP_OK);
    } else {
      $this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
    }


  }

  //create a new internalUser
  function user_put() {
    $this->load->library("form_validation");
    $data = remove_unknown_fields( $this->put(),             $this->form_validation->get_field_names("user_put"));
    $this->form_validation->set_data($data);
    //$this->form_validation->set_message("is_unique[internaluser.InternalUserEmail]", "This email is already exist!");
    if ($this->form_validation->run("user_put") != false) {
      $this->load->model("Model_internal_users");
      // validate email address if it exists
      $email_address_exist = $this->Model_internal_users->get_by(array("InternalUserEmail" => $this->put("InternalUserEmail")));
      if ($email_address_exist) {
        $this->response(array("status" => "failed", "message" => "fdsaf"));
      }
      // insert the put data to the database
      $internalUser_id = $this->Model_internal_users->insert($data);
      if (!$internalUser_id) {
        $this->response( array("status" => "failed", "message" => "An ucexpected error uccred when inserting to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
      } else {
        $this->response(array("status" => "success", "message" => "successfully inserted to the database"), REST_Controller::HTTP_OK);
      }
    } else {
      $this->response( array("status" => "failed", "message" => $this->form_validation->get_errors_as_array()), REST_Controller::HTTP_BAD_REQUEST );
    }
  }

  function user_post() {
    $user_id = $this->uri->segment(3);
    $this->load->model("Model_internal_users");
    // $users = array(
    //   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
    //   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
    // );
    $user = $this->Model_internal_users->get_by(array("idInternalUser" => $user_id ));
    if (isset($user["idInternalUser"])) {
        $this->load->library("form_validation");
        $data = remove_unknown_fields( $this->post(),             $this->form_validation->get_field_names("user_post"));
        $this->form_validation->set_data($data);
        //$this->form_validation->set_message("is_unique[internaluser.InternalUserEmail]", "This email is already exist!");
        if ($this->form_validation->run("user_post") != false) {
          $this->load->model("Model_internal_users");
          // validate email address if it exists
          $safe_email_address = !isset($data["InternalUserEmail"]) || $data["InternalUserEmail"] == $user["InternalUserEmail"] || !$this->Model_internal_users->get_by(array("InternalUserEmail" => $data["InternalUserEmail"]));
          if (!$safe_email_address) {
            $this->response( array("status" => "failed", "message" => "This email address is already in use."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
          }
          // insert the post data to the database
          $updated = $this->Model_internal_users->update($user_id, $data);
          if (!$updated) {
            $this->response( array("status" => "failed", "message" => "An ucexpected error uccred when updating to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
          } else {
            $this->response(array("status" => "success", "message" => "successfully inserted to the database"), REST_Controller::HTTP_OK);
          }
        } else {
          $this->response( array("status" => "failed", "message" => $this->form_validation->get_errors_as_array()), REST_Controller::HTTP_BAD_REQUEST );
        }
    } else {
      $this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
    }


  }



}


 ?>
