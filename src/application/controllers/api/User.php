<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		$data = array(
			'status' => 'success',
		);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}
