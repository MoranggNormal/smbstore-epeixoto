<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('UserModel');
		$this->load->helper('validation');
		$this->load->library('form_validation');

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register()
	{
		$this->form_validation->set_rules(
			'email',
			'Email',
			'required|valid_email|is_unique[users.email]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('birth_date', 'Birth Date', 'required');
		$this->form_validation->set_rules('profile_image', 'Profile Image', 'required');

		if ($this->form_validation->run() === FALSE) {

			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}

		$data = array(
			'username' 		=> $this->input->post('username'),
			'password' 	 	=> $this->input->post('password'),
			'first_name' 	=> $this->input->post('first_name'),
			'last_name'  	=> $this->input->post('last_name'),
			'email' 	 	=> $this->input->post('email'),
			'phone' 	 	=> $this->input->post('phone'),
			'birth_date' 	=> $this->input->post('birth_date'),
			'profile_image' => $this->input->post('profile_image'),
		);

		$data['password'] = md5($data['password']);

		try {
			$this->UserModel->register_user($data);

			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('CREATED'));
		} catch (\Exception $e) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => json_encode($e->getMessage())
					)
				));
		}
	}

}
