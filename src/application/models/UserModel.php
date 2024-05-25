<?php
class UserModel extends CI_Model
{

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * UserModel constructor.
     *
     * @param array $data Optional data to initialize the model.
     */
    public function __construct(array $data = null)
    {
        $session = $this->session->userdata(config_item('auth')['LOGGED_USER']);

        $this->container['id'] = isset($session['id']) ? $session['id'] : null;
        $this->container['username'] = isset($session['username']) ? $session['username'] : null;
        $this->container['first_name'] = isset($session['first_name']) ? $session['first_name'] : null;
        $this->container['last_name'] = isset($session['last_name']) ? $session['last_name'] : null;
        $this->container['email'] = isset($session['email']) ? $session['email'] : null;
        $this->container['password'] = isset($session['password']) ? $session['password'] : null;
        $this->container['phone'] = isset($session['phone']) ? $session['phone'] : null;
        $this->container['birth_date'] = isset($session['birth_date']) ? $session['birth_date'] : null;
        $this->container['profile_image'] = isset($session['profile_image']) ? $session['profile_image'] : null;
        $this->container['roles'] = isset($session['roles']) ? $session['roles'] : null;

        parent::__construct();
    }

    /**
     * Registers a new user in the database.
     *
     * @param array $data An associative array containing the user's data.
     *                      The array should include the following keys:
     *                          - 'username' (string) - The user's concatenated first name and last name.
     *                          - 'email' (string) - The user's email address.
     *                          - 'password' (string) - The user's password, hashed before insertion.
     *                          - 'first_name' (string) - The user's first name.
     *                          - 'last_name' (string) - The user's last name.
     *                          - 'phone' (string) - The user's phone number.
     *                          - 'birth_date' (string) - The user's birth date in Y-m-d format.
     *                          - 'profile_image' (string) - The user's profile image URL.
     *
     * @return bool|int True on success, false on failure, or the ID of the inserted user if using auto-increment IDs.
     */
    public function register_user($data)
    {
        return $this->db->insert('users', $data);
    }

    /**
     * Logs the user into the system.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     *
     * @return array|bool The user's data if the login is successful, false otherwise.
     */
    public function login(string $email, string $password): array|bool
    {
        $this->db->select(
            'id, 
            username,
            first_name,
            last_name,
            email,
            phone, 
            birth_date, 
            profile_image, 
            roles'
        );

        $this->db->where('email', $email);
        $this->db->where('password', md5($password));

        $user = $this->db->get('users')->row_array();

        return $user;
    }

    /**
     * Gets the user's data.
     *
     * @return array The user's data.
     */
    public function getData()
    {

        $user_data = array(
            'id' => $this->container['id'],
            'username' => $this->container['username'],
            'first_name' => $this->container['first_name'],
            'last_name' => $this->container['last_name'],
            'email' => $this->container['email'],
            'phone' => $this->container['phone'],
            'birth_date' => $this->container['birth_date'],
            'profile_image' => $this->container['profile_image'],
            'roles' => $this->container['roles'],
        );

        return $user_data;
    }

    /**
     * Gets the user's ID.
     *
     * @return int The user's ID.
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->container['username'];
    }

    /**
     * Sets username
     *
     * @param string $username username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->container['username'] = $username;

        return $this;
    }

    /**
     * Gets first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->container['first_name'];
    }

    /**
     * Sets first_name
     *
     * @param string $first_name first_name
     *
     * @return $this
     */
    public function setFirstName($first_name)
    {
        $this->container['first_name'] = $first_name;

        return $this;
    }

    /**
     * Gets last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->container['last_name'];
    }

    /**
     * Sets last_name
     *
     * @param string $last_name last_name
     *
     * @return $this
     */
    public function setLastName($last_name)
    {
        $this->container['last_name'] = $last_name;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string $email email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->container['password'];
    }

    /**
     * Sets password
     *
     * @param string $password password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->container['password'] = $password;

        return $this;
    }

    /**
     * Gets phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->container['phone'];
    }

    /**
     * Sets phone
     *
     * @param string $phone phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->container['phone'] = $phone;

        return $this;
    }

    /**
     * Gets birth_date
     *
     * @return string
     */
    public function getBirthDate()
    {
        return $this->container['birth_date'];
    }

    /**
     * Sets birth_date
     *
     * @param string $birth_date birth_date
     *
     * @return $this
     */
    public function setBirthDate($birth_date)
    {
        $this->container['birth_date'] = $birth_date;

        return $this;
    }

    /**
     * Gets profile_image
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->container['profile_image'];
    }

    /**
     * Sets profile_image
     *
     * @param string $profile_image profile_image
     *
     * @return $this
     */
    public function setProfileImage($profile_image)
    {
        $this->container['profile_image'] = $profile_image;

        return $this;
    }

    /**
     * Gets roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->container['roles'];
    }

    /**
     * Sets roles
     *
     * @param array $roles roles
     *
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->container['roles'] = $roles;

        return $this;
    }
}
