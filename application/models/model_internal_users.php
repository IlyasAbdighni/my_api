<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Model_internal_users extends MY_Model{

    protected $_table = "internaluser";
    protected $primary_key = "idInternalUser";
    protected $return_type = "array";

    protected $after_get = array("remove_sensitive_data");
    protected $before_create = array("prep_data");

    protected function remove_sensitive_data($user) {
      unset($user["InternalUserPassword"]);
      unset($user["InternalUserConfirmPassword"]);
      return $user;
    }

    protected function prep_data($user) {
      $user["InternalUserPassword"] = md5($user["InternalUserPassword"]);
      $user["InternalUserConfirmPassword"] = md5($user["InternalUserConfirmPassword"]);
      //$user["ip_address"] = $this->input->ip_address();
      //$user["created_at"] = date("Y-m-d: H:i:s");
      return $user;
    }




  }


 ?>
