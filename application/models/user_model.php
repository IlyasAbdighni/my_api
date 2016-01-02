<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model
{
    protected $_table = "internaluser";
    public $validate = array(
        array( 'field' => 'email',
               'label' => 'email',
               'rules' => 'required|valid_email|is_unique[users.email]' ),
        array( 'field' => 'password',
               'label' => 'password',
               'rules' => 'required' ),
        array( 'field' => 'password_confirmation',
               'label' => 'confirm password',
               'rules' => 'required|matches[password]' ),
    );
}

 ?>
