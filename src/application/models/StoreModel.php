<?php
class StoreModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_store_and_active_users()
    {
        $this->db->select(
            'store.id as store_id, 
            store.name as store_name, 
            store_users.id as user_id, 
            store_users.username as user_username,
            store_users.first_name as user_first_name, 
            store_users.last_name as user_last_name, 
            store_users.email as user_email, 
            store_users.phone as user_phone, 
            store_users.birth_date as user_birth_date,
            store_users.profile_image as user_profile_image,
            store_users.isActive as user_isActive'
        );
        $this->db->from('store');
        $this->db->where('store_users.isActive', true);
        $this->db->join('store_users', 'store.id = store_users.store_id');

        $query = $this->db->get();

        $stores = array();

        foreach ($query->result() as $row) {
            $store_id = $row->store_id;
            if (!isset($stores[$store_id])) {
                $stores[$store_id] = array(
                    'id' => $store_id,
                    'name' => $row->store_name,
                    'users' => array()
                );
            }
            $stores[$store_id]['users'][] = array(
                'id' => $row->user_id,
                'username' => $row->user_username,
                'first_name' => $row->user_first_name,
                'last_name' => $row->user_last_name,
                'email' => $row->user_email,
                'phone' => $row->user_phone,
                'birth_date' => $row->user_birth_date,
                'profile_image' => $row->user_profile_image,
                'isActive' => $row->user_isActive,
            );
        }

        return array_values($stores);
    }

    public function get_stores()
    {
        $query = $this->db->get('store');
        return $query->result_array();
    }

    /**
     * Registers a new store in the database.
     *
     * @param array $data An associative array containing the store data.
     * @return bool|array Returns false if the store was not created, otherwise returns an associative array containing the store's ID, name, and creation timestamp.
     */
    public function register_store($data)
    {
        $this->db->insert('store', $data);

        $store_id = $this->db->insert_id();

        $this->db->select('id, name, created_at');
        $this->db->where('id', $store_id);

        $query = $this->db->get('store');
        $was_created = $query->num_rows() > 0;

        if (!$was_created) {
            return false;
        }

        return $query->row_array();
    }

    /**
     * Registers a new user on a store in the database.
     *
     * @param array $data An associative array containing the user data.
     * @return bool Returns true if the user was successfully registered, otherwise returns false.
     */
    public function register_user_on_store($data)
    {
        return $this->db->insert('store_users', $data);
    }

    public function set_user_as_inactive($data)
    {
        $this->db->where('id', $data["id"]);

        return $this->db->update('store_users', array('isActive' => 0));
    }
}
