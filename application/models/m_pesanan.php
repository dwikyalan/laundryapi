<?php  


/**
* 
*/
class m_pesanan extends CI_Model
{
	
	private $table_name 	= "tb_transaksi";
	private $table_detail 	= "tb_detail_transaksi";
	private $table_user		= "tb_konsumen";
	private $table_paket	= "tb_paket";
	private $primary 		= "id_transaksi";

	function get_all(){

		#Get all data users
		$this->db->select("t_tran.*,t_user.nama,t_paket.nama");
		$data=$this->db->join($this->table_user." t_user","t_user.id_konsumen=t_tran.id_konsumen");
		$data=$this->db->join($this->table_paket." t_paket","t_paket.id_paket=t_tran.id_paket");
		$data=$this->db->get($this->table_name." t_tran");
		return $data->result();


	}

	function get_pesanan_by_userid($id){

		#Get all data pesanan by userid
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where($this->table_name.".id_konsumen",$id);
		// $data=$this->db->join($this->table_detail,$this->table_detail.".KODE_TRANSAKSI=".$this->table_name.".KODE_TRANSAKSI");
		$data=$this->db->get();
		return $data->result();


	}

	function get_by_id($id){

		#Get data user by id
		$this->db->where($this->primary,$id);
		$data=$this->db->get($this->table_name);

		return $data->row();
	}

	function get_detail_by_id($id){

		#Get data user by id
		$this->db->where($this->primary,$id);
		$this->db->join($this->table_paket." t_paket","t_paket.id_paket=".$this->table_detail.".id_paket");
		$data=$this->db->get($this->table_detail);

		return $data->result();
	}

	// function get_history_user($id){

	// 	#Get history by id user
	// 	$this->db->where("ID_USER",$id);
	// 	$this->db->join($this->table_mobil." t_mobil","t_mobil.ID_MOBIL=".$this->table_detail.".ID_MOBIL");
	// 	$data=$this->db->get($this->table_detail);

	// 	return $data->result();
	// }


	function get_by_username_email($username,$email){		
		#Get data by username or email
		$this->db->where('username',$username);
		$this->db->or_where('email',$email);
		$data=$this->db->get($this->table_name)->row();

		return $data;
	}


	function insert($data,$detail_pesanan){

		#Insert data to table tb_users
		$insert=$this->db->insert($this->table_name,$data);
		$this->db->insert_batch($this->table_detail,$detail_pesanan);
		return $insert;
	}

	function delete($id){
		#Delete data user by id
		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_name);

		return $delete;
	}

	function update($id,$data){
		#Update data user by id
		$this->db->where($this->primary,$id);
		$update=$this->db->update($this->table_name,$data);

		return $update;
	}

	function get_kode_transaksi(){
		$this->db->select("count('id_transaksi') AS id_transaksi");
		return $this->db->get($this->table_name)->row();
	}

}

?>