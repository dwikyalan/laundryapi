<?php  

/**
* 
*/
class modelkomplain extends CI_Model
{
	private $table_name="tb_komplain";
	private $primary="id_komplain";

	function get_all(){
		$this->db->select($this->table_name.'.*,GROUP_CONCAT(gambar) AS gambar');
		return $this->db->get($this->table_name)->result();
	}

	function get_by_id($id){
		$this->db->select($this->table_name.'.*,GROUP_CONCAT(gambar) AS gambar');
		$this->db->where($this->table_name.'.'.$this->primary,$id);
		return $this->db->get($this->table_name)->row();
	}

	function insert($data,$komplain_photo=null){
		$insert=$this->db->insert($this->table_name,$data);
		$id=$this->db->insert_id();

		if ($komplain_photo!=null&&$id) {
			$komplain_photo["id_komplain"]=$id;
			$insert=$this->db->insert($this->table_gallery,$komplain_photo);
		}
	
		return $id;
	}

	function update($id,$data,$komplain_photo=null){
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);

		if ($komplain_photo!=null&&$update) {
			$komplain_photo["id_komplain"]=$id;
			$this->db->where($this->primary,$id);
			$update=$this->db->update($this->table_gallery,$komplain_photo);
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