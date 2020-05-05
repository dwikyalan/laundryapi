<?php  


/**
* 
*/
require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		#Configure limit request methods
		$this->methods['index_get']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_post']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_delete']['limit']=10; #10 requests per hour per user/key
		$this->methods['index_put']['limit']=10; #10 requests per hour per user/key
		
		#Configure load model api table users
		$this->load->model('modeluser');
	}


	function index_get($group_user=null,$id=null){	
		
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success get user' , 'data' => null );
		
		#Set response API if Not Found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no users were found' , 'data' => null );
        
		#
		if (!empty($this->get('id_konsumen')))
			$id=$this->get('id_konsumen');


		#
		if (!empty($this->get('group_user')))
			$group_user=$this->get('group_user');
        


		if ($id==null||$id==0) {
			#Call methode get_all from modeluser model
			$users=$this->modeluser->get_all($group_user);
		
		}


		if ($id!=null&&$id!=0) {
			
			#Check if id <= 0
			if ($id<=0) {
				$this->response($response['NOT_FOUND'], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}

			#Call methode get_by_id from modeluser model
			$users=$this->modeluser->get_by_id($id);
		}


        # Check if the users data store contains users
		if ($users) {
			$response['SUCCESS']['data']=$users;

			#if found Users
			$this->response($response['SUCCESS'] , REST_Controller::HTTP_OK);

		}else{

	        #if Not found Users
	        $this->response($response['NOT_FOUND'], REST_Controller::HTTP_NOT_FOUND); # NOT_FOUND (404) being the HTTP response code

		}

	}

	function index_post(){
		
		#
		$user_data = array(	
							// 'id_konsumen' => $this->post('id_konsumen') ,
							'nama' =>$this->post('nama') , 
							'alamat' => $this->post('alamat') ,
							'hp' => $this->post('hp') ,
							'email' => $this->post('email') , 
							'username' => $this->post('username') ,
							'password' => md5($this->post('password')) ,
							'jenis_kelamin' => $this->post('jenis_kelamin') ,
							'activated' => $this->post('activated') ,
							'created' =>date('Y-m-d h:i:s'),
							'group_user'=>$this->post('group_user'),
							'last_update' =>date('Y-m-d h:i:s'),
						);
		

		#Initialize image name
		$image_name=round(microtime(true)).date("Ymd").".jpg";

		#Upload avatar
		if ($this->Upload_Images($image_name))
			$user_data['PHOTO']=$image_name;
	
		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success insert data' , 'data' => $user_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail insert data' , 'data' => null );
		
		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist data' , 'data' => null );

		if ($this->modeluser->get_by_username_email($this->post('username'),$this->post('email'))){
			#Remove image user
			if ($user_data['gambar']!=null) {
				$this->remove_image($user_data['gambar']);
			}

			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);

		}

		#Check if insert user_data Success
		if ($this->modeluser->insert($user_data)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);

		}else{
			#Remove image user
			if ($user_data['gambar']!=null) {
				$this->remove_image($user_data['gambar']);
			}
			
			#If fail
			$this->response($response['FAIL'],REST_Controller::HTTP_FORBIDDEN);

		}

	}

	function index_delete($id=null){

		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'Success delete user'  );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'Fail delete user'  );
		
		#Set response API if user not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'No users were found' );


		#Check available user
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);
		

		if (!empty($this->get('id_konsumen')))
			$id=$this->get('id_konsumen');
		
		if ($this->modeluser->delete($id)) {
			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function index_put(){

		$id=$this->put('id_konsumen');

		$user_data = array(	
			// 'id_konsumen' => $this->post('id_konsumen') ,
							'nama' =>$this->post('nama') , 
							'alamat' => $this->post('alamat') ,
							'hp' => $this->post('hp') ,
							'email' => $this->post('email') , 
							'username' => $this->post('username') ,
							'password' => md5($this->post('password')) ,
							'jenis_kelamin' => $this->post('jenis_kelamin') ,
							'activated' => $this->post('activated') ,
							'created' =>date('Y-m-d h:i:s'),
							'group_user'=>$this->post('group_user'),
							'last_update' =>date('Y-m-d h:i:s'),
						);
		if ($this->put('password')) {
			$user_data['password'] = md5($this->put('password'));
		}

		#Initialize image name
		$image_name=round(microtime(true)).date("Ymdhis").".jpg";

		#Upload avatar
		if ($this->Upload_Images($image_name))
			$user_data['gambar']=$image_name;


		#Set response API if Success
		$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update user' , 'data' => $user_data );

		#Set response API if Fail
		$response['FAIL'] = array('status' => FALSE, 'message' => 'fail update user' , 'data' => $user_data );
		
		#Set response API if user not found
		$response['NOT_FOUND']=array('status' => FALSE, 'message' => 'no users were found' , 'data' => $user_data );

		#Set response API if exist data
		$response['EXIST'] = array('status' => FALSE, 'message' => 'exist insert data' , 'data' => $user_data );

		#Check available user
		if (!$this->validate($id))
			$this->response($response['NOT_FOUND'],REST_Controller::HTTP_NOT_FOUND);

		
		if ($this->modeluser->get_by_username_email($this->put('USERNAME'),$this->put('EMAIL'))->id_konsumen!=null&&$this->modeluser->get_by_username_email($this->put('USERNAME'),$this->put('EMAIL'))->id_konsumen!=$id)
			$this->response($response['EXIST'],REST_Controller::HTTP_FORBIDDEN);
		$up=$this->modeluser->update($id,$user_data);
		if ($up) {
			
			$response['SUCCESS'] = array('status' => TRUE, 'message' => 'success update user' , 'data' => $up );			
			#If success
			$this->response($response['SUCCESS'],REST_Controller::HTTP_CREATED);
		
		}else{

			#If Fail
			$this->response($response['FAIL'],REST_Controller::HTTP_CREATED);
			
		}

	}

	function validate($id){
		$users=$this->modeluser->get_by_id($id);
		if ($users)
			return TRUE;
		else
			return FALSE;
	}

	function Upload_Images($name) 
    {

    		if ($this->post('gambar')) {
	    		$strImage = str_replace('data:image/png;base64,', '', $this->post('gambar'));			
    		}else{
    			$strImage = str_replace('data:image/png;base64,', '', $this->put('gambar'));
    		}
    		if (!empty($strImage)) {
    			$img = imagecreatefromstring(base64_decode($strImage));
							
				if($img != false)
				{
				   if (imagejpeg($img, './upload/avatars/'.$name)) {
				   	return true;
				   }else{
				   	return false;
				   }
				}
			}
	}


	function remove_image($name){
		$path='./upload/avatars/'.$name;
		unlink($path);
	}


}

?>