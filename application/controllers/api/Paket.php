<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class Paket extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per paket/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per paket/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per paket/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per paket/key
		
		#Configure load model api table paket
		$this->load->model('modelpaket');
	}


	function index_get($id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success get paket' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No paket were found' , 'data' => null );
        
		#
		if (!empty($this->get('id_paket')))
			$id=$this->get('id_paket');
            

		if ($id==null) {
			#Call methode get_all from modelpaket model
			$paket=$this->modelpaket->get_all();
		
		}


		if ($id!=null) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from modelpaket model
			$paket=$this->modelpaket->get_by_id($id);
		}


        # Check if the paketdata store contains paket
		if ($paket) {
			if (count($paket)==1)
				if (isset($paket->gambar)) {
					$paket->gambar=explode(',', $paket->gambar);
				}else{
					$paket[0]->gambar=explode(',', $paket[0]->gambar);
				}
			else
				for ($i=0; $i <count($paket) ; $i++)
					$paket[$i]->gambar=explode(',', $paket[$i]->gambar);
			// exit();
			$response['SUCCESS']['data']=$paket;

			#if found paket
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{
 
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){

		#
		$paket_data = array('nama' =>$this->put('nama') , 
							'harga' => $this->put('harga') ,
							'Deksripsi' => $this->put('Deksripsi') , 
						);

		 

		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		$paket_photo=null;

		#Upload avatar
		if ($this->Upload_Images($image_name)){
			$paket_photo['gambar']=$image_name;
			$paket_photo['id_paket']=$image_name;
		}
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $paket_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail insert data' , 'data' => null );
		
		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => null );

		if ($this->modelpaket->get_by_id($this->post('id_paket'))){
		
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		}

		#Check if insert paket_data Success
		$id=$this->modelpaket->insert($paket_data,$paket_photo);
		if ($id) {
			$paket_data["id_paket"]=$id;
			$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success insert data' , 'data' => $paket_data );

			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{
			#Remove image paket
			if ($paket_data['gambar']!=null) {
				$this->remove_image($paket_data['gambar']);
			}
			
			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success delete paket'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail delete paket'  );
		
		#Set response API if paket not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no paketwere found' );


		#Check available paket
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('id_paket')))
			$id=$this->get('id_paket');
		
		if ($this->modelpaket->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('id_paket');

		$paket_data = array('nama' =>$this->put('nama') , 
							'harga' => $this->put('harga') ,
							'Deksripsi' => $this->put('Deksripsi') , 
							
						);


		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		$paket_photo=null;

		#Upload avatar
		if ($this->Upload_Images($image_name)){
			$paket_photo['gambar']=$image_name;
			$paket_photo['id_paket']=$image_name;
		}

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update paket' , 'data' => $paket_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail update paket' , 'data' => $paket_data );
		
		#Set response API if paket not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no paket were found' , 'data' => $paket_data );

		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => $paket_data );

		#Check available paket
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);

		if ($this->modelpaket->get_by_id($this->put('id_paket'))!=null&&$this->modelpaket->get_by_id($this->put('id_paket'))->id_paket!=$id)
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		$update=$this->modelpaket->update($id,$paket_data,$paket_photo);
		if ($update) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$paket=$this->modelpaket->get_by_id($id);
		if ($paket)
			return TRUE;
		else
			return FALSE;
	}

	function Upload_Images($name) 
    {

    		if ($this->post('PHOTO')) {
	    		$strImage = str_replace('data:image/png;base64,', '', $this->post('PHOTO'));
    		}else{
    			$strImage = str_replace('data:image/png;base64,', '', $this->put('PHOTO'));

    		}
    		if (!empty($strImage)) {
    			$img = imagecreatefromstring(base64_decode($strImage));
							
				if($img != false)
				{
				   if (imagejpeg($img, './upload/paket/'.$name)) {
				   	return true;
				   }else{
				   	return false;
				   }
				}
			}
	}

	function remove_image($name){
		$path='./upload/paket/'.$name;
		unlink($path);
	}
}
?>