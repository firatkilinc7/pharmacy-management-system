<?php

class Siparisler_model extends CI_Model
{

    public $tableName = "siparisler";

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

	public function get_month($month, $year)
    {
		
		$query = $this->db->query("SELECT * FROM siparisler WHERE MONTH(siparis_tarihi) = {$month} AND YEAR(siparis_tarihi) = {$year}");
		
		return $query->result();
	}
	
	public function ayin_elemani($month, $year, $eczaci)
    {
		
		$query = $this->db->query("SELECT * FROM siparisler WHERE MONTH(siparis_tarihi) = {$month} AND YEAR(siparis_tarihi) = {$year} AND eczaci = \"{$eczaci}\"");
		
		return $query->result();
	}
	
	public function tarihler_arasi($tarih1, $tarih2)
    {
		
		$query = $this->db->query("SELECT * FROM siparisler WHERE siparis_tarihi BETWEEN \"{$tarih1}\" and \"{$tarih2}\"");
		
		return $query->result();
	}
	
	public function get_first_row()
	{
		$query = $this->db->query("SELECT * FROM siparisler ORDER BY siparis_tarihi ASC LIMIT 1");
		
		return $query->result();
	}
}
