<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	/**
	 * UserController constructor.
	 * Loads necessary models, helpers, and libraries.
	 *
	 * @author [Your Name]
	 */
	public function __construct()
	{
		/**
		 * Calls the parent constructor.
		 */
		parent::__construct();

		/**
		 * Loads the UserModel.
		 */
		$this->load->model('UserModel');
		/**
		 * Loads the validation helper.
		 */
		$this->load->helper('validation');

		/**
		 * Loads the form validation library.
		 */
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	/**
	 * Registers a new user.
	 *
	 * @return void
	 * @throws \Exception If an error occurs during registration.
	 */
	public function register()
	{
		/**
		 * Sets the validation rules for the registration form.
		 *
		 * @param string $field The field name.
		 * @param string $label The label for the field.
		 * @param string $rule The validation rule.
		 * @param array $params Additional parameters for the validation rule.
		 * @param array $errors Custom error messages for the field.
		 */
		$this->form_validation->set_rules(
			'email',
			'Email',
			'required|valid_email|is_unique[users.email]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

		if ($this->form_validation->run() === FALSE) {

			/**
			 * Returns a JSON response with validation errors.
			 *
			 * @return void
			 */
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}

		$data = array(
			'password' 	 	=> $this->input->post('password'),
			'first_name' 	=> $this->input->post('first_name'),
			'last_name'  	=> $this->input->post('last_name'),
			'username' 		=> $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
			'email' 	 	=> $this->input->post('email'),
			'phone' 	 	=> $this->input->post('phone'),
			'birth_date' 	=> $this->input->post('birth_date'),
			'profile_image' => '',
		);

		$upload_path 			 = 'uploads/';
		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|webp|avif';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('profile_image')) {
			$error = array('error' => $this->upload->display_errors());

			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode($error));
		} else {
			$image_file = $this->upload->data();

			$data['profile_image'] = $upload_path . $image_file["file_name"];
		}

		$data['password'] = md5($data['password']);

		try {
			/**
			 * Registers a new user using the provided data.
			 *
			 * @param array $data The data for the new user.
			 * @return void
			 */
			$created = $this->UserModel->register_user($data);


			$this->session->set_userdata($this->user_session_data, $created);

			/**
			 * Returns a JSON response with a status code indicating successful creation.
			 *
			 * @return void
			 */
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('CREATED'))
				->set_output(json_encode($created));
		} catch (\Exception $e) {

			/**
			 * Returns a JSON response with an error message and status code.
			 *
			 * @param \Exception $e The exception that occurred during registration.
			 * @return void
			 */
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => $e->getMessage()
					)
				));
		}
	}
}
