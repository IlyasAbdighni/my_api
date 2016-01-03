<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
  "user_put" => array(
    array( "field" => "InternalUserName",
           "label" => "User name",
           "rules" => "trim|required|is_unique[internaluser.InternalUserName]"),
    array( "field" => "InternalUserEmail",
           "label" => "email_address",
           "rules" => "trim|required|valid_email|is_unique[internaluser.InternalUserEmail]"),
    array( "field" => "InternalUserPassword",
           "label" => "password",
           "rules" => "trim|required|min_length[6]|max_length[16]"),
    array( 'field' => 'InternalUserConfirmPassword',
           'label' => 'confirm password',
           'rules' => 'required|matches[InternalUserPassword]' ),
  ),
  "user_post" => array(
    array( "field" => "InternalUserName",
           "label" => "User name",
           "rules" => "trim|is_unique[internaluser.InternalUserName]"),
    array( "field" => "InternalUserEmail",
           "label" => "email_address",
           "rules" => "trim|valid_email|is_unique[internaluser.InternalUserEmail]"),
  ),
);


 ?>