<?php  


/**
* 
*/
class m_transaksi extends CI_Model
{

	private $table_name 	= "tb_transaksi";
	private $table_user		= "tb_konsumen";
	private $table_mobil	= "tb_paket";
	private $primary 		= "id_transaksi";
	private $kode 			= "id_transaksi";

	function cancel($id){
		//get detail transkasi by ID_DETAIL_TRANSAKSI
		$data=$this->get_transaksi_by_id($id);

		//get detail transkasi by id_transaksi
		$data_transaksi=$this->get_transaksi_by_kode($data->id_transaksi);

		$this->db->where($this->primary,$id);
		$delete=$this->db->delete($this->table_detail);

		if ($delete) {
			$this->db->where($this->kode,$data->id_transaksi);
			$data_transaksi->total=$data_transaksi->total - $data->TOTAL;
			$update=$this->db->update($this->table_name,(array)$data_transaksi);

			if($data_transaksi->total==0){
				$this->db->where($this->kode,$data->id_transaksi);
				$this->db->delete($this->table_name);
			}
		}

		return $delete;
	}

	function get_transaksi_by_id($id){
		$this->db->where($this->primary,$id);
		$data=$this->db->get("tb_transaksi")->row();
		return $data;
	}

	function get_transaksi_by_kode($id){
		$this->db->where($this->kode,$id);
		$data=$this->db->get("tb_transaksi")->row();
		return $data;
	}
}

?>