<?php  

/**
* 
*/
class modelpaket extends CI_Model
{
	private $table_name="tb_paket";
	private $primary="id_paket";

	function get_all(){
		// $this->db->select($this->table_name.'.*,GROUP_CONCAT(gambar) AS gambar');
		return $this->db->get($this->table_name)->result();
	}

	function get_by_id($id){
		$this->db->select($this->table_name.'.*,GROUP_CONCAT(gambar) AS gambar');
		$this->db->where($this->table_name.'.'.$this->primary,$id);
		return $this->db->get($this->table_name)->row();
	}

	function insert($data,$paket_photo=null){
		$insert=$this->db->insert($this->table_name,$data);
		$id=$this->db->insert_id();

		if ($paket_photo!=null&&$id) {
			$paket_photo["id_paket"]=$id;
			$insert=$this->db->insert($this->table_gallery,$paket_photo);
		}
	
		return $id;
	}

	function update($id,$data,$paket_photo=null){
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);

		if ($paket_photo!=null&&$update) {
			$paket_photo["id_paket"]=$id;
			$this->db->where($this->primary,$id);
			$update=$this->db->update($this->table_gallery,$paket_photo);
		}
	
		return $update;
	}

	function delete($id){
		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_name);
		return $delete;
	}

}

?>