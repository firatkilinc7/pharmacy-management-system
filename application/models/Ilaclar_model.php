<?php

class Ilaclar_model extends CI_Model
{

    public $tableName = "ilaclar";

    public function __construct()
    {
        parent::__construct();

    }

    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function get_all($where = array(), $order = "id ASC")
    {
        return $this->db->where($where)->order_by($order)->get($this->tableName)->result();
    }

    public function add($data = array())
    {
        return $this->db->insert($this->tableName, $data);
    }

    public function update($where = array(), $data = array())
    {
        return $this->db->where($where)->update($this->tableName, $data);
    }

    public function delete($where = array())
    {
        return $this->db->where($where)->delete($this->tableName);
    }
	
	public function get_count($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->num_rows();
    }

	public function get_expired()
    {
        $today = date('Y-m-d');

		$query = $this->db->query("SELECT * FROM ilaclar WHERE expired_date < '{$today}' AND stok > 0");
		
		return $query->result();
	}
	
	public function get_stockout()
    {
		$query = $this->db->query("SELECT * FROM ilaclar WHERE stok = 0");
		
		return $query->result();
	}
	
	public function order_by_expired()
    {
		$query = $this->db->query("SELECT * FROM ilaclar ORDER BY expired_date ASC");
		
		return $query->result();
	}

	public function string_search($string, $column)
    {
		$query = $this->db->query("SELECT * FROM ilaclar WHERE {$column} LIKE \"%{$string}%\"");
		
		return $query->result();
	}
	public function multi_string_search($string1,$column1,$string2, $column2)
    {
		$query = $this->db->query("SELECT * FROM ilaclar WHERE {$column1} LIKE \"%{$string1}%\" AND {$column2} LIKE \"%{$string2}%\"");
		
		return $query->result();
	}
	
	public function get_expired_and_stockout($istendi)
    {
        $today = date('Y-m-d');

		$query = $this->db->query("SELECT * FROM ilaclar WHERE expired_date < '{$today}' AND istendi = {$istendi} OR stok = 0 AND istendi = {$istendi}");
		
		return $query->result();
	}
	
}
