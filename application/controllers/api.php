<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller{

	function __construct()
	{
			// Construct the parent class
			parent::__construct();
			$this->load->helper("my_api", "date");
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
				$data = remove_unknown_fields( $this->post(), $this->form_validation->get_field_names ("user_post"));
				$this->form_validation->set_data($data);
				//$this->form_validation->set_message("is_unique[internaluser.InternalUserEmail]", "This email is already exist!");
				if ($this->form_validation->run("user_post") != false) {
					$this->load->model("Model_internal_users");

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
		$this->load->model("model_internal_users");
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
			$this->load->model("model_internal_users");
			// validate email address if it exists
//			$email_address_exist = $this->Model_internal_users->get_by(array("InternalUserEmail" => $this->put("user_email")));
//			if ($email_address_exist) {
//				$this->response(array("status" => "failed", "message" => "fdsaf"));
//			}
			// insert the put data to the database
            $fields = array(
                "InternalUserName" => $this->put("user_name"),
                "InternalUserEmail" => $this->put("user_email"),
                "InternalUserPassword" => $this->put("password"),
                "InternalUserPhone" => $this->put("user_phone"),
                "InternalUserAddress" => $this->put("user_address"),
            );
			$internalUser_id = $this->model_internal_users->insert($fields);
			if (!$internalUser_id) {
				$this->response( array("status" => "failed", "message" => preg_replace("#[\n]+#", "", "An ucexpected error occured when inserting to the database.")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
			} else {
				$this->response(array("status" => "success", "message" => preg_replace('#[\n]+#', '', 'successfully inserted to the database')), REST_Controller::HTTP_OK);
			}
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response( array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)), REST_Controller::HTTP_BAD_REQUEST );
		}


	}



	public function userLogin_post() {

		$this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules("user_name", "user name", "trim|required|callback_validate_credentials");
		$this->form_validation->set_rules("password", "Password", "trim|required|md5");
		//$this->form_validation->set_message("required", "shit");

		if ($this->form_validation->run()) {
			$this->load->model("Model_internal_users");
            $user_name = $this->post("user_name");
            $user = $this->model_internal_users->get_by(array("InternalUserName" => $user_name));
            $user_id = $user["idInternalUser"];
			$this->response(array("status" => "success", "message" => array(
                "success message" => "you loged in!",
                "user_id" => $user_id,
            )), REST_Controller::HTTP_OK);
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)));
		}


	}


	public function validate_credentials() {

		$this->load->model("model_internal_users");

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

		$this->form_validation->set_rules("university_name", "Name of the university", "trim|required|is_unique[university.UniversityName]");
		$this->form_validation->set_rules("university_address", "Address of the university", "trim|required");
		$this->form_validation->set_rules("university_phone", "Phone number of the university", "trim|required|min_length[7]|max_length[20]");
		$this->form_validation->set_rules("university_website", "the website of the university", "trim");
		$this->form_validation->set_rules("university_logo", "logo of the university", "trim");
		//$this->form_validation->set_message("required", "shit");

		if ($this->form_validation->run()) {
            $fields = array(
                "UniversityName" => $this->post("university_name"),
                "UniversityAddress" => $this->post("university_address"),
                "UniversityPhoneNumber" => $this->post("university_phone"),
                "UniversityWebsite" => $this->post("university_website"),
                "UniversityLogoURL" => $this->post("university_logo"),
            );

			$this->load->model("model_university");
            $university_id = $this->model_university->insert($fields);
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
		$this->load->model("model_university");
		// $users = array(
		//   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
		//   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
		// );
		$universities = $this->model_university->get_all();
		if (isset($universities)) {


			$this->response(array("status" => "success", "message" => $universities), REST_Controller::HTTP_OK);
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}
	}


    public function getAUniversity_get() {
		$university_id = $this->uri->segment(3);
		$this->load->model("model_university");
		// $users = array(
		//   1 => array("first_name" => "constant_ilyas", "last_name" => "constant_abdighni"),
		//   2 => array("first_name" => "constant_gvlmerem", "last_name" => "constant_mutellip"),
		// );
		$university = $this->model_university->get_by(array("idUniversity" => $university_id) );
		if (isset($university)) {


			$this->response(array("status" => "success", "message" => $university), REST_Controller::HTTP_OK);
		} else {
			$this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}
	}




    public function addRecord_post () {
        $this->load->library("form_validation");
				$this->load->model("model_record");

		$this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($this->post());

		$this->form_validation->set_rules("university_id", "id of the university", "trim|required");
		$this->form_validation->set_rules("category_type", "type of this record", "trim|required");
		$this->form_validation->set_rules("user_id", "user id is required", "trim|required");
		$this->form_validation->set_rules("content", "content of this record", "trim|required");

		if ($this->form_validation->run()) {

      $university_id = $this->post("university_id");
      $category_id = $this->post("category_type");
      $user_id = $this->post("user_id");
      $content = $this->post("content");
			if ($this->post("record_id")) {
				$record_id = $this->post("record_id");
				$this->db->where(array(
					"University_idUniversity" => $university_id,
					"Catagory_idCatagory" => $category_id,
				));
				$record_result = $this->db->get("record");
				if ($record_result->num_rows() == 0) {
					$this->response( array("status" => "failed", "message" => "Could not find the record you are updating."));
				}
			}
			else {
				$record_id = $this->model_record->insert(array(
						"University_idUniversity" => $university_id,
						"Catagory_idCatagory" => $category_id,
						"LikeNumber" => 0,
						"DislikeNumber" => 0,
				));
			}
      if (!$record_id) {
				$this->response( array("status" => "failed", "message" => "An ucexpected error occured when inserting university id and category id to record table."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
			} else {

        $this->load->model("model_internal_users");
        $user = $this->model_internal_users->get_by(array("idInternalUser" => $user_id));
        if (isset($user["idInternalUser"])) {

            $user_type = $user["InternalUserType_idInternalUserType"];

            $fields = array(
                "Record_idRecord" => $record_id,
                "Record_University_idUniversity" => $university_id,
                "Record_Catagory_idCatagory" => $category_id,
                "InternalUser_idInternalUser" => $user_id,
                "InternalUser_InternalUserType_idInternalUserType" => $user_type,
                "Status_idStatus" => 2,

            );

            $this->load->model("model_history");
            $history_id = $this->model_history->insert($fields);
            if (!$history_id) {
                $this->response( array("status" => "failed", "message" => "Could not update history table."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
            } else {
                $this->load->model("model_content");
                $content_fields = array(
                    "ContentDescription" => $content,
                    "History_idHistoty" => $history_id
                );
                $content_id = $this->model_content->insert($content_fields);
                if(!$content_id) {
                    $this->response( array("status" => "failed", "message" => "Could not update content table."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
                } else {
                    $this->response(array("status" => "success", "message" => "successfully updated"), REST_Controller::HTTP_OK);
                }

            }
        } else {
            $this->response(array("status" => "failed", "message" => "The specified user could not be found."), REST_Controller::HTTP_NOT_FOUND);
        }
			}
		} else {
			$error_message = $this->form_validation->first_error();
			$this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)));
		}
    }




    function getRecord_get() {
        //SELECT history.idHistoty AS history_id, record.idRecord as record_id, record.University_idUniversity as university_id, record.Catagory_idCatagory AS category_type, history.Status_idStatus as status, history.InternalUser_idInternalUser as user_id FROM record INNER JOIN history ON record.idRecord = history.Record_idRecord WHERE history.Status_idStatus = 1  ORDER BY history.idHistoty DESC


        //SELECT history.idHistoty AS history_id, record.idRecord as record_id, record.University_idUniversity as university_id, record.Catagory_idCatagory AS category_type, history.Status_idStatus as status, history.InternalUser_idInternalUser as user_id FROM record INNER JOIN history ON record.idRecord = history.Record_idRecord WHERE (record.idRecord, history.Status_idStatus) IN ((18,1)) ORDER BY history.idHistoty DESC
        // query for get record

		$university_id = $this->uri->segment(3);

        $this->load->model("model_university");
        $requested_university = $this->model_university->get_by(array("idUniversity" => $university_id));
        if ($requested_university["idUniversity"]) {

            $records = $this->db->query("SELECT idRecord as record_id FROM record WHERE University_idUniversity = {$university_id}");
            if ($records->num_rows() > 0) {

                //$data = new ArrayObject();
                $data = array();
                //$data = new ArrayObject();

                foreach ($records->result() as $row) {
                    //array_push($data, $row->record_id);
                    //$data->append(array("record_id" => $row->record_id));
                    //$data = $row->record_id;

                    $record_id = $row->record_id;

                    $query = "SELECT ";
                    $query .= "history.idHistoty AS history_id, ";
                    //$query .= "record.idRecord as record_id, ";
                    $query .= "record.Catagory_idCatagory AS category_type, ";
                    $query .= "history.Status_idStatus as status, ";
                    $query .= "history.InternalUser_idInternalUser as user_id, ";
                    $query .= "record.LikeNumber as likes, ";
                    $query .= "record.DislikeNumber as dislikes, ";
                    $query .= "content.ContentDescription as content ";
                    $query .= "FROM history ";
                    $query .= "INNER JOIN record ON ";
                    $query .= "record.idRecord = history.Record_idRecord ";
                    $query .= "INNER JOIN content ON ";
                    $query .= "history.idHistoty = content.History_idHistoty ";
                    $query .= "WHERE (record.idRecord, history.Status_idStatus) IN (({$record_id},1)) ";
                    $query .= "ORDER BY history.idHistoty DESC";

                    $query_result = $this->db->query($query);

                    if ($query_result->num_rows() > 0 ) {
                        array_push($data, array( "record_id" => $record_id,"record_info" => $query_result->row()));
                        //$data->append(array("record_id" => $record_id, "record_info" => $query_result->row()));
                    }

                }

            }

            if (!$data) {
                $this->response( array("status" => "failed", "message" => "Could not find the university history content."), REST_Controller::HTTP_INTERNAL_SERVER_ERROR );
            } else {
                $this->response(array("status" => "success", "message" => $data), REST_Controller::HTTP_OK);
            }


        } else {
            $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', 'The univeristy doesn\'t exist')));
        }



	}



    function getCategory_get() {
		//$user_id = $this->uri->segment(3);
		$this->load->model("model_category");
		$category = $this->model_category->get_all();
        //$query = $this->db->query("SELECT * FROM category ORDER BY idCategory DESC LIMIT 1;");
        //$query->row()
		if (isset($category)) {
			$this->response(array("status" => "success", "message" => $category), REST_Controller::HTTP_OK);
		} else {
			$this->response(array("status" => "failed", "message" => "The category could not be found."), REST_Controller::HTTP_NOT_FOUND);
		}


    }




    function addVote_post () {

        $this->load->library("form_validation");
		$this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($this->post());

		$this->form_validation->set_rules("user_id", "id of the user ", "trim|required");
		$this->form_validation->set_rules("history_id", "id of the record", "trim|required");
		$this->form_validation->set_rules("vote", "user id is required", "trim|required");

        if ($this->form_validation->run()) {

            $user_id = $this->post("user_id");
            $history_id = $this->post("history_id");
            $vote = $this->post("vote");

            $this->load->model("model_history");
            $history = $this->model_history->get_by(array("idHistoty" => $history_id));
            if (!$history["idHistoty"]) {
                $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "Could not find speicfied history")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $record_id = $history["Record_idRecord"];

                $this->load->model("model_record");
                $record = $this->model_record->get_by(array("idRecord" => $record_id));
                switch ($vote) {
                    case 1:         //add likes
                        $record_like = $record["LikeNumber"];
                        $record_like += 1;
                        $resulet = $this->model_record->update($record_id, array("LikeNumber" => $record_like, "LikeTimeStamp" => date("Y-m-d h:i:s")));
                        break;
                    case 2:         //add dislikes
                        $record_dislike = $record["DislikeNumber"];
                        $record_dislike += 1;
                        $resulet = $this->model_record->update($record_id, array("DislikeNumber" => $record_dislike, "DislikeTimeStamp" => date("Y-m-d h:i:s")));
                        break;
                    case 3:         //undo a like
                        $record_like = $record["LikeNumber"];
                        $record_like -= 1;
                        $resulet = $this->model_record->update($record_id, array("LikeNumber" => $record_like, "LikeTimeStamp" => date("Y-m-d h:i:s")));
                        break;
                    case 4:         //undo a dislike
                        $record_dislike = $record["DislikeNumber"];
                        $record_dislike -= 1;
                        $resulet = $this->model_record->update($record_id, array("DislikeNumber" => $record_dislike, "DislikeTimeStamp" => date("Y-m-d h:i:s")));
                        break;
                    default:
                        $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "Could not update the number of likes or dislikes in record table")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }

                if (!$resulet) {
                    $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "Could not update the number of likes in record table")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                } else {
                    $records = $this->model_record->get_by(array("idRecord" => $record_id));
                    $university_id = $records["University_idUniversity"];
                    $category_type = $records["Catagory_idCatagory"];

                    $this->load->model("model_internal_users");
                    $user = $this->model_internal_users->get_by(array("idInternalUser" => $user_id));
                    $user_type = $user["InternalUserType_idInternalUserType"];

                    $this->load->model("model_history");
                    $new_history_id = $this->model_history->insert(array(
                        "Status_idStatus" => 1,
                        "Record_idRecord" => $record_id,
                        "Record_University_idUniversity" => $university_id,
                        "Record_Catagory_idCatagory" => $category_type,
                        "InternalUser_idInternalUser" => $user_id,
                        "InternalUser_InternalUserType_idInternalUserType" => $user_type,

                    ));

                    if (!$new_history_id) {

                        $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "Could not update the number of likes in record table")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } else {

                        $this->load->model("model_content");
                        $content = $this->model_content->get_by(array("History_idHistoty" => $history_id));
                        $content_id = $content["idContent"];
                        $updated_content = $this->model_content->update($content_id, array(
                            "History_idHistoty" => $new_history_id,
                        ));

                        if (!$updated_content) {
                            $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "Could not update the content table")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        } else {
                            $this->response(array("status" => "success", "message" => "Successfully updated the vites."), REST_Controller::HTTP_OK);
                        }

                    }

                }

            }

        } else {
            $error_message = $this->form_validation->first_error();
			$this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', $error_message)), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function getMyRecord_get () {
        //SELECT internaluser.idInternalUser as user_id, history.idHistoty as history_id, history.Status_idStatus as status, record.LikeNumber as like_num, record.DislikeNumber as dislike_num, internaluser.InternalUserType_idInternalUserType as user_type, content.ContentDescription as content FROM history INNER JOIN internaluser ON history.InternalUser_idInternalUser = internaluser.idInternalUser INNER JOIN content ON history.idHistoty = content.History_idHistoty INNER JOIN record ON history.Record_idRecord = record.idRecord WHERE internaluser.idInternalUser = 26

        $user_id = $this->uri->segment(3);

        $query = "SELECT ";
        //$query .= "internaluser.idInternalUser as user_id, ";
        $query .= "history.idHistoty as history_id, ";
        $query .= "record.idRecord as record_id, ";
        $query .= "history.Status_idStatus as status, ";
        $query .= "record.LikeNumber as like_num, ";
        $query .= "record.DislikeNumber as dislike_num, ";
        $query .= "internaluser.InternalUserType_idInternalUserType as user_type, ";
        $query .= "content.ContentDescription as content ";
        $query .= "FROM history ";

        $query .= "INNER JOIN internaluser ON ";
        $query .= "history.InternalUser_idInternalUser = internaluser.idInternalUser ";

        $query .= "INNER JOIN content ON ";
        $query .= "history.idHistoty = content.History_idHistoty ";

        $query .= "INNER JOIN record ON ";
        $query .= "record.idRecord = history.Record_idRecord ";

        $query .= "WHERE ";
        $query .= "internaluser.idInternalUser = {$user_id} ";
        //$query .= "ORDER BY history.idHistoty DESC";

        $my_record = $this->db->query($query);

        if ($my_record->num_rows() > 0 ) {

            $data = $my_record->result();
            $this->response(array("status" => "success", "message" => array(
                "user_id" => $user_id,
                "about_user_contributions" => $data,
            )), REST_Controller::HTTP_OK);

        } else {

            $this->response(array("status" => "failed", "message" => preg_replace('#[\n]+#', '', "This user has no contributions.")), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

        }
    }





}


 ?>
