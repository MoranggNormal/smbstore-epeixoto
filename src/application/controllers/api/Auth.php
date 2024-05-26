<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $user_session;

    /**
     * Constructor for Auth class.
     * Initializes the parent constructor, loads necessary models, helpers, and libraries.
     * Also, retrieves user session data.
     */
    public function __construct()
    {
        /**
         * Calls the parent constructor of CI_Controller.
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
         * Loads the form_validation library.
         */

        $this->load->library('form_validation');

        /**
         * Retrieves user session data.
         *
         * @var mixed $this->user_session User session data.
         */
        $this->user_session = $this->session->userdata($this->user_session_data);
    }

    /**
     * Checks if the user is already logged in.
     *
     * @return void
     */
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

        $this->login($data['email'], $data['password']);
    }

    /**
     *
     * Validates the user's login credentials and logs them in.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * 
     * @return void
     */
    private function login(string $email, string $password)
    {
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email[user_system.email]',
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
            $email,
            $password
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

    /**
     * Logs the user out and removes their session data.
     *
     * @return void
     */
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

    /**
     * Checks if the user is currently logged in and returns their session data.
     *
     * @return void
     */
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
