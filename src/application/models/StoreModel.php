<?php
class StoreModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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
}
