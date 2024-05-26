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
		$this->load->view('welcome_message');
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
}
