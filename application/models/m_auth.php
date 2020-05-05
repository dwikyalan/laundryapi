<?php  

/**
* 
*/
class m_auth extends CI_Model
{
	
	private $table_name = "tb_konsumen";

	function get_user_by_emai($username,$password){
		$this->db->where('username',$username);
		$this->db->where('password',$password);

		return $this->db->get($this->table_name)->row();
	}
}

?>