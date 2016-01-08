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

	//get request
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
		$data = remove_unknown_fields( $this->put(),
		$this->form_validation->get_field_names("user_put"));
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
            $this->response( array("status" => "failed", "message" => "An ucexpected error uccred when                      inserting to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
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
					// $safe_email_address = !isset($data["InternalUserEmail"]) || $data["InternalUserEmail"] == $user["InternalUserEmail"] || !$this->Model_internal_users->get_by(array("InternalUserEmail" => $data["InternalUserEmail"]));
					// if (!$safe_email_address) {
					//   $this->response( array("status" => "failed", "message" => "This email address is already in use."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
					// }

					// insert the post data to the database
					$updated = $this->Model_internal_users->update($user_id, $data);
					if (!$updated) {
						$this->response( array("status" => "failed", "message" => "An ucexpected error uccred when updating to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
					} else {
						$this->response(array("status" => "success", "message" => "successfully updated to the database"), REST_Controller::HTTP_OK);
					}

				} else {
					$this->response( array("status" => "failed", "message" => $this->form_validation->get_errors_as_array()), REST_Controller::HTTP_BAD_REQUEST );
				}
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}


	}

	//delete request
	function user_delete() {
		$user_id = $this->uri->segment(3);
		$this->load->model("Model_internal_users");
		// $users = array(
		//   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
		//   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
		// );
		$user = $this->Model_internal_users->get_by(array("idInternalUser" => $user_id ));
		if (isset($user["idInternalUser"])) {
			$delete = $this->Model_internal_users->delete($user_id);
			if (!$delete) {
				$this->response( array("status" => "failed", "message" => "An ucexpected error uccred when try to delete to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
			} else {
				$this->response(array("status" => "success", "message" => "successfully deleted from the database"), REST_Controller::HTTP_OK);
			}
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}


	}


	function userRegister_put() {
		//$this->load->helper(array('form', 'url'));
		$this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($this->put());
		//$this->form_validation->set_message("is_unique[internaluser.InternalUserEmail]", "This email is already exist!");
		if ($this->form_validation->run("user_register_put") != false) {
			$this->load->model("Model_internal_users");
			// validate email address if it exists
			$email_address_exist = $this->Model_internal_users->get_by(array("InternalUserEmail" => $this->put("InternalUserEmail")));
			if ($email_address_exist) {
				$this->response(array("status" => "failed", "message" => "fdsaf"));
			}
			// insert the put data to the database
			$internalUser_id = $this->Model_internal_users->insert($this->put());
			if (!$internalUser_id) {
				$this->response( array("status" => "failed", "message" => "An ucexpected error occured when inserting to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
			} else {
				$this->response(array("status" => "success", "message" => "successfully inserted to the database"), REST_Controller::HTTP_OK);
			}
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response( array("status" => "failed", "message" => $error_message), REST_Controller::HTTP_BAD_REQUEST );
		}


	}



	public function userLogin_post() {

		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules("InternalUserName", "Email", "trim|required|callback_validate_credentials");
		$this->form_validation->set_rules("InternalUserPassword", "Password", "trim|required|md5");
		//$this->form_validation->set_message("required", "shit");

		if ($this->form_validation->run()) {
			//$this->load->model("Model_internal_users");
			$this->response(array("status" => "success", "message" => "you loged in!"), REST_Controller::HTTP_OK);
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)));
		}


	}


	public function validate_credentials() {

		$this->load->model("Model_internal_users");

		if ($this->model_internal_users->can_log_in()) {
			return true;

		} else {
			$this->form_validation->set_message("validate_credentials", preg_replace('#[\n]+#', '', "Incorrect username/password."));
			return false;
		}

	}
    
    
    public function addUniversity_post() {

		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($this->post());

		$this->form_validation->set_rules("UniversityName", "Name of the university", "trim|required|is_unique[university.UniversityName]");
		$this->form_validation->set_rules("UniversityAddress", "Address of the university", "trim|required");
		$this->form_validation->set_rules("UniversityPhoneNumber", "Address of the university", "trim|required|min_length[7]|max_length[20]");
		$this->form_validation->set_rules("UniversityDescription", "Discription of the university", "trim");
		//$this->form_validation->set_message("required", "shit");

		if ($this->form_validation->run()) {
			$this->load->model("Model_university");
            $university_id = $this->model_university->insert($this->post());
            if (!$university_id) {
				$this->response( array("status" => "failed", "message" => "An ucexpected error occured when inserting the univeristy to the database."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
			} else {
				$this->response(array("status" => "success", "message" => "The university is successfully inserted to the database"), REST_Controller::HTTP_OK);
			}
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)));
		}


	}
    
    
    
    public function getUniversities_get() {
		//$user_id = $this->uri->segment(3);
		$this->load->model("Model_university");
		// $users = array(
		//   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
		//   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
		// );
		$universities = $this->Model_university->get_all();
		if (isset($universities)) {
            
            
			$this->response(array("status" => "success", "message" => $universities), REST_Controller::HTTP_OK);
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}
	}
    
    
    public function getAUniversity_get() {
		$university_id = $this->uri->segment(3);
		$this->load->model("Model_university");
		// $users = array(
		//   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
		//   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
		// );
		$university = $this->Model_university->get_by(array("idUniversity" => $university_id) );
		if (isset($university)) {
            
            
			$this->response(array("status" => "success", "message" => $university), REST_Controller::HTTP_OK);
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}
	}
		






}


 ?>
