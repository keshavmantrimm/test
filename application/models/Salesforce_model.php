<?php
class Salesforce_model extends CI_Model{
	  
	//private $table = 'users';  
	public function __construct()
	{
		$this->load->database();    
		$this->load->library('salesforce');
    	//$this->load->model('Email_model');
    	//$this->load->helper('url');
    	//$this->load->helper('common');
	}


	/*public function salesforce_auth_key_exits($key, $email) {
		$data = array('salesforce_auth_key' => $key, 'email' => $email);
		$this->db->select('id');
        $this->db->where($data);
        $query = $this->db->get($this->table);
        $row = $query->result();
        
        if (empty($row)) {
		   return true;
        }
        return false;

	}*/

	/**
	 * Cron setup
	 * Check Email and return User all data from email Id .
	 */
	public function salesforce_user_exits() {

		//$query = "SELECT Id, Phone, FirstName, LastName, Email, CreatedDate from Contact";
		//$query = "SELECT ContactId,LastName,State,IsInactive FROM DatacloudContact";

	 	//$contact = $this->salesforce->query($query);

	 	$query = "SELECT Id, ContactId,Name, FirstName, LastName, Email, Username, UserType, Phone, Street, City, State, PostalCode, Country, CompanyName, Alias, TimeZoneSidKey from User";

		$user = $this->salesforce->query($query);


		$user1 = json_encode($user);
		//$user1 = json_decode($user);
		
		echo "<pre>";
		print_r($user);

		echo "</pre>";
		print_r($user1);
		

		echo "<br><br><br><br><br>";
	 	
	 	foreach ($user as $record) {
	 	echo "Id ".$record->Id."<br>";
	 	echo "ContactId ".$record->ContactId."<br>";
	 	echo "Username ".$record->Username."<br>";
	 	echo "UserType ".$record->UserType."<br>";
	 	echo "Phone ".$record->Phone."<br>";
	 	echo "Street ".$record->Street."<br>";
	 	echo "City ".$record->City."<br>";
	 	echo "State ".$record->State."<br>";
	 	echo "Email ".$record->Email."<br>";
	 	echo "Alias ".$record->Alias."<br>";
	 	echo "FirstName ".$record->FirstName."<br>";
	 	echo "LastName ".$record->LastName."<br>";
	 	echo "Name ".$record->Name."<br>";
	 	echo "TimeZoneSidKey ".$record->TimeZoneSidKey."<br>";
	 	//echo "PostalCode ".$record->PostalCode.;
	 	//echo "PostalCode ".$record->PostalCode.;
	 	echo "<br><br><br><br><br>";
	 	}

	 	echo "<pre>";
	 	print_r($user->records);

	 	die();

		$this->db->select_max('id');
		$last_cron_id = $this->db->get('users')->row()->id;  
		
		$this->db->select('created');
		$this->db->where(array('id' => $last_cron_id));
		$result = $this->db->get('users')->row();  
		
		$query = "SELECT Id, Phone, FirstName, LastName, Email, CreatedDate from Contact WHERE Email != '' AND CreatedDate >=".$result->created;
	 	$contact = $this->salesforce->query($query);
	 	
	 	$new_record = array();
		foreach ($contact as $record) {
			if($this->salesforce_auth_key_exits($record->Id, $record->Email) && isset($record->Id)){
				$token = $this->User_model->securityToken($record->Email);
				//if($this->Email_model->sendVerificatinEmail($record->Email , $token)){
					$data = array( 
						'salesforce_auth_key'=>$record->Id,
						'email'				=> $record->Email,
						'f_name'			=> $record->FirstName,
						'l_name'			=> $record->LastName,
						'mobile'			=> $record->Phone,
						'created'			=>  $record->CreatedDate,
						'pwd'				=> $token.$record->Id,
						'email_verification'=> $token,
						'salt'				=> create_salt(),						
						'picture'			=> 'profile-128x128.png',
						'capability'		=> 'consumer',
						'status'			=> '0'
					);
					
					$this->db->set('modified', 'NOW()', FALSE);
					if($this->db->insert($this->table, $data)){
						$new_record_data = array(
							'f_name'			=> $record->FirstName,
							'l_name'			=> $record->LastName,
							'email'				=> $record->Email,
							'mobile'			=> $record->Phone							
						);
						$new_record[] = $new_record_data;
					}
				//}
			}
		}
		if( isset($new_record) && !empty($new_record)){
			$this->Email_model->successCron_Email($new_record);
		}else{
			$msg = "The cron success fully run. Nothing new record founds";
			$sub = 'Cron run successfully';
			$this->Email_model->information_Email($msg, $sub,'','');		
		}
	}

/* end of Salesforce Model */
}

/* End of file Salesforce_model.php */
/* Develop By Ram Kumawat */
/* Location: ./application/model/Salesforce_model.php */

