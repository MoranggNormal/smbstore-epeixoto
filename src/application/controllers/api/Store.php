<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{
	/**
	 * UserController constructor.
	 * Loads necessary models, helpers, and libraries.
	 *
	 * @author Euler Peixoto
	 */
	public function __construct()
	{
		/**
		 * Calls the parent constructor.
		 */
		parent::__construct();

		/**
		 * Loads the StoreModel.
		 */
		$this->load->model('StoreModel');

		/**
		 * Loads the form validation library.
		 */
		$this->load->library('form_validation');
	}

	public function index()
	{
		$stores_and_users = $this->StoreModel->get_store_and_active_users();

		if (!$stores_and_users) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Failed to retrieve stores and users'
					)
				));
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('OK'))
			->set_output(json_encode($stores_and_users));
	}

	public function get_stores()
	{
		$stores = $this->StoreModel->get_stores();

		if (!$stores) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Failed to retrieve stores'
					)
				));
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('OK'))
			->set_output(json_encode($stores));
	}

	/**
	 * Registers a new store.
	 *
	 * @return void
	 */
	public function register()
	{
		/**
		 * Set validation rules for the store name.
		 * The name field is required and must be unique in the store table.
		 */
		$this->form_validation->set_rules(
			'name',
			'Name',
			'required|is_unique[store.name]',
			array(
				'required'      => 'You have not provided %s.',
				'is_unique'     => 'This %s already exists.'
			)
		);

		/**
		 * Run the form validation.
		 * If the validation fails, return a JSON response with the validation errors.
		 */
		if ($this->form_validation->run() === FALSE) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}

		/**
		 * Prepare the data for the new store.
		 * Get the name from the POST data.
		 */
		$data = array(
			'name' => $this->input->post('name'),
		);

		/**
		 * Register the new store using the StoreModel.
		 * If the registration fails, return a JSON response with an error message.
		 */
		$created = $this->StoreModel->register_store($data);

		if (!$created) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Store registration failed'
					)
				));
		}


		/**
		 * If the registration is successful, return a JSON response with a success status.
		 */
		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('CREATED'));
	}

	public function create_user()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('birth_date', 'Birth Date', 'required');
		$this->form_validation->set_rules('store_id', 'Store ID', 'required|integer');

		if ($this->form_validation->run() == FALSE) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}

		$data = array(
			'store_id' 		=> $this->input->post('store_id'),
			'username' 		=> $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'email' 		=> $this->input->post('email'),
			'phone' 		=> $this->input->post('phone'),
			'birth_date' 	=> $this->input->post('birth_date'),
			'profile_image' => ""
		);

		$upload_path 			 = 'uploads/';
		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|webp|avif';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('profile_image')) {
			$error = array('error' => $this->upload->display_errors());

			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode($error));
		}

		$image_file = $this->upload->data();

		$data['profile_image'] = $upload_path . $image_file["file_name"];

		$created = $this->StoreModel->register_user_on_store($data);

		if (!$created) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(array('status' => 'error', 'message' => 'Failed to create user')));
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('CREATED'))
			->set_output(json_encode(array('status' => 'success', 'message' => 'User created successfully')));
	}

	public function edit_user()
	{
		$this->form_validation->set_rules('user_id', 'UserId', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');

		if ($this->form_validation->run() == FALSE) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}
		$data = array(
			'id' => $this->input->post('user_id'),
		);

		if ($this->input->post('store_id')) {
			$data['store_id'] = $this->input->post('store_id');
		}

		if ($this->input->post('first_name') && $this->input->post('last_name')) {
			$data['username'] = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
			$data['first_name'] = $this->input->post('first_name');
			$data['last_name'] = $this->input->post('last_name');
		}

		if ($this->input->post('email')) {
			$data['email'] = $this->input->post('email');
		}

		if ($this->input->post('phone')) {
			$data['phone'] = $this->input->post('phone');
		}

		if ($this->input->post('birth_date')) {
			$data['birth_date'] = $this->input->post('birth_date');
		}
		
		if (!empty($_FILES['profile_image']['name'])) {
			$upload_path = 'uploads/';
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|webp|avif';
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('profile_image')) {
				$error = array('error' => $this->upload->display_errors());

				return $this->output
					->set_content_type('application/json')
					->set_status_header(http_response_code_map('BAD_REQUEST'))
					->set_output(json_encode($error));
			}

			$image_file = $this->upload->data();

			$data['profile_image'] = $upload_path . $image_file["file_name"];
		}

		$edited = $this->StoreModel->edit_store_user($data);

		if (!$edited) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(array('status' => 'error', 'message' => 'Failed to update user data')));
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('OK'))
			->set_output(json_encode(array('status' => 'success', 'message' => 'User updated successfully')));
	}


	public function delete_store_user()
	{
		$this->form_validation->set_rules('userId', 'userId', 'required',);

		if ($this->form_validation->run() === FALSE) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(validation_errors());
		}

		$data = array(
			'id' 	=> $this->input->post('userId'),
			'isActive' => false
		);

		$deleted = $this->StoreModel->set_user_as_inactive($data);

		if (!$deleted) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(http_response_code_map('BAD_REQUEST'))
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Store registration failed'
					)
				));
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(http_response_code_map('OK'));
	}
}
