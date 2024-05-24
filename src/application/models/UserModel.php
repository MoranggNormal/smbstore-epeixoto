<?php
class UserModel extends CI_Model
{

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */

    protected $container = [];
    public function __construct(array $data = null)
    {
        $session = $this->session->userdata('logged_user');

        $this->container['id'] = isset($session['id']) ? $session['id'] : null;
        $this->container['username'] = isset($session['username']) ? $session['username'] : null;
        $this->container['first_name'] = isset($session['first_name']) ? $session['first_name'] : null;
        $this->container['last_name'] = isset($session['last_name']) ? $session['last_name'] : null;
        $this->container['email'] = isset($session['email']) ? $session['email'] : null;
        $this->container['password'] = isset($session['password']) ? $session['password'] : null;
        $this->container['phone'] = isset($session['phone']) ? $session['phone'] : null;
        $this->container['birth_date'] = isset($session['birth_date']) ? $session['birth_date'] : null;
        $this->container['profile_pic'] = isset($session['profile_pic']) ? $session['profile_pic'] : null;
        $this->container['roles'] = isset($session['roles']) ? $session['roles'] : null;

        parent::__construct();
    }

    /**
     * Gets id
     *
     * @return int
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
     * Gets profile_pic
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->container['profile_pic'];
    }

    /**
     * Sets profile_pic
     *
     * @param string $profile_pic profile_pic
     *
     * @return $this
     */
    public function setProfilePic($profile_pic)
    {
        $this->container['profile_pic'] = $profile_pic;

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