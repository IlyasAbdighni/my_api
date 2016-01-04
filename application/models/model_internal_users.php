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

    public function can_log_in() {

      $this->db->where('InternalUserName', $this->input->post("InternalUserName"));
      $this->db->where('InternalUserPassword', md5($this->input->post("InternalUserPassword")));
      $query = $this->db->get("internaluser");

      if ($query->num_rows() == 1) {
        return true;
      } else {
        return false;
      }
    }




  }


 ?>
