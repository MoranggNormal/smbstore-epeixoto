<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $user_session;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserModel');
        $this->load->helper('validation');
        $this->load->library('form_validation');

        $this->user_session = $this->session->userdata($this->user_session_data);
    }

    public function index()
    {
        if ($this->user_session) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('BAD_REQUEST'))
                ->set_output(json_encode(
                    array(
                        'message' => "User already logged in"
                    )
                ));
        }

        $data = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password')
        );

        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email[users.email]',
            array(
                'required' => 'You have not provided %s.',
            )
        );

        if ($this->form_validation->run() === FALSE) {

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('BAD_REQUEST'))
                ->set_output(validation_errors());
        }

        $logged_user = $this->UserModel->login(
            $data['email'],
            $data['password']
        );

        if ($logged_user) {

            $this->session->set_userdata($this->user_session_data, $logged_user);

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('OK'))
                ->set_output(json_encode($logged_user));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('BAD_REQUEST'))
                ->set_output(json_encode(
                    array(
                        'status' => 'error',
                        'message' => 'User could not be logged in. \\nPlease try again.'
                    )
                ));
        }
    }

    public function logout()
    {
        if ($this->user_session) {

            $this->session->unset_userdata($this->user_session_data);

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('OK'));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('BAD_REQUEST'))
                ->set_output(json_encode(
                    array(
                        'status' => 'error',
                        'message' => 'No active session'
                    )
                ));
        }
    }

    public function checkSession()
    {
        if ($this->user_session) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('OK'))
                ->set_output(json_encode(
                    array(
                        'status' => 'success',
                        'userData' =>  $this->UserModel->getData()
                    )
                ));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(http_response_code_map('BAD_REQUEST'))
                ->set_output(json_encode(
                    array(
                        'status' => 'error',
                        'message' => 'No active session'
                    )
                ));
        }
    }
}
