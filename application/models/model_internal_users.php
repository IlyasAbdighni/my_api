<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Model_internal_users extends MY_Model{

    protected $_table = "internaluser";
    protected $primary_key = "idInternalUser";
    protected $return_type = "array";

    protected $after_get = array("remove_sensitive_data");

    protected function remove_sensitive_data($user) {
      unset($user["InternalUserPassword"]);
      unset($user["InternalUserConfirmPassword"]);
      return $user;
    }




  }


 ?>
