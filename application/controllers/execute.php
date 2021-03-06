<?php

defined('BASEPATH') or exit ('No direct script allowed.');
date_default_timezone_set('Asia/Manila');

class execute extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

	}

	// public function generate_username()
	// {

	//     return sprintf( 'OES-%04x'.rand(111,999),
	//         mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	//         mt_rand( 0, 0xffff ),
	//         mt_rand( 0, 0x0C2f ) | 0x4000,
	//         mt_rand( 0, 0x3fff ) | 0x8000,
	//         mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
	//     );

	// }


	public function validate($a,$b,$c)
	{

		return $this->form_validation->set_rules($a,$b,$c);

	}


	public function post($a)
	{

		return $this->input->post($a);

	}

	public function GetCategory()
	{

		$result = array('data'=>array());
		$data 	= $this->model->GetAllCategory();
		$i = 1;
		foreach ($data as $key => $value)
		{
			$id = $value['id'];
			$button = "<a class='btn btn-dark flat' href='http://localhost/examination_system/category/modify/$id'><i class='fa fa-pencil'></i> Modify</a>";
			$result['data'][$key] = array($i++,$value['category'],$button);
		}
		echo json_encode($result);
	}

	public function GetInstructions()
	{

		$result = array('data'=>array());
		$data 	= $this->model->GetAllInstructions();
		$i = 1;
		foreach ($data as $key => $value)
		{
			$id = $value['id'];
			$button = "<a class='btn btn-dark flat' href='http://localhost/examination_system/instructions/modify/$id'><i class='fa fa-pencil'></i> Modify</a>";
			$result['data'][$key] = array($i++,$value['instructions'],$button);
		}
		echo json_encode($result);
	}

	public function GetQuestions()
	{

		$result = array('data'=>array());
		$data 	= $this->model->GetAllQuestions();
		$i = 1;
		foreach ($data as $key => $value)
		{
			$id = $value['id'];
			$button = "<a class='btn btn-dark flat' href='http://localhost/examination_system/question/modify/$id'><i class='fa fa-pencil'></i> Modify</a>";
			$result['data'][$key] = array(
				$i++,
				$value['question'],
				$value['category'],
				$value['answer'],
				$button);
		}
		echo json_encode($result);
	}


	public function InsertUpdate()
	{
		$data = array(
			'normal' => 'trim|required|xss_clean',
			'email' => 'trim|required|valid_email|xss_clean',
			'number' => 'trim|required|max_length[11]|min_length[11]|xss_clean',
			'name' => 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]|xss_clean'
			);

		$this->validate('name','School Name',$data['normal']);
		$this->validate('email','School Email',$data['email']);
		$this->validate('address','School Address',$data['normal']);
		$this->validate('contact','School Contact Number',$data['number']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('dashboard');

		}

		$data = array(
			'id' 		=> $this->post('id'),
			'name' 		=> $this->post('name'),
			'email' 	=> $this->post('email'),
			'address' 	=> $this->post('address'),
			'contact' 	=> $this->post('contact')
			);

		$result = $this->model->InsertOrUpdate($data);


	}

	public function delete_all()
	{

		$result = $this->model->delete_all();
		if($result)
		{

			redirect('viewstudents');

		}

	}

	public function cat_delete($id)
	{

		$result = $this->model->CategoryDelete($id);
		if($result)
		{

			redirect('view_category');

		}

	}

	public function que_delete($id)
	{

		$result = $this->model->QuestionsDelete($id);
		if($result)
		{

			redirect('view_questions');

		}

	}

	public function ins_delete($id)
	{

		$result = $this->model->InstructionsDelete($id);
		if($result)
		{

			redirect('view_instructions');

		}

	}


	public function updateinfo($id)
	{

		$data = array(
			'normal' => 'trim|required|xss_clean',
			'email' => 'trim|required|valid_email|xss_clean',
			'name' => 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]|xss_clean',

			);

		$this->validate('name','Full Name',$data['normal']);
		$this->validate('address','Address',$data['normal']);
		$this->validate('gender','Gender',$data['normal']);
		$this->validate('email','Email',$data['email']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors(' <i class="fa fa-remove"></i> '));
			$this->session->set_flashdata($data);
			redirect('myaccount');

		}


		$data = array(
			'name' 		=> $this->post('name'),
			'address' 	=> $this->post('address'),
			'gender' 	=> $this->post('gender'),
			'email' 	=> $this->post('email')
			);

		$result = $this->model->UpdateAccount($data,$id);


	}

	public function studentupdateinfo($id)
	{

		$data = array(
			'normal' => 'trim|required|xss_clean',
			'email' => 'trim|required|valid_email|xss_clean',
			'name' => 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]|xss_clean',

			);

		$this->validate('name','Full Name',$data['normal']);
		$this->validate('address','Address',$data['normal']);
		$this->validate('gender','Gender',$data['normal']);
		$this->validate('email','Email',$data['email']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors(' <i class="fa fa-remove"></i> '));
			$this->session->set_flashdata($data);
			redirect('view_student/profile/'.$id);

		}


		$data = array(
			'name' 		=> $this->post('name'),
			'address' 	=> $this->post('address'),
			'gender' 	=> $this->post('gender'),
			'email' 	=> $this->post('email')
			);

		$result = $this->model->UpdateAccount($data,$id);
		if($result)
		{


		}

	}

	public function DeleteStudent($id)
	{

		$result = $this->model->DeleteAccount($id);
		if($result)
		{

			redirect('viewstudents');

		}

	}

	public function updateinfopassword($id)
	{

		$data = array(
			'normal' => 'trim|required|xss_clean',
			'password' => 'trim|required|xss_clean|matches[password]'
			);

		$this->validate('password','Password',$data['normal'].'|min_length[6]');
		$this->validate('cpassword','Confirm Password',$data['password']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors(' <i class="fa fa-remove"></i> '));
			$this->session->set_flashdata($data);
			redirect('myaccount');

		}


		$data = array(
			'password' 	=> $this->encrypt($this->post('password'))
			);

		$result = $this->model->MyAccountUpdatePassword($data,$id);


	}

	public function updatestudentpassword($id)
	{


		$data = array('password' => $this->encrypt($this->post('password')));
		$result = $this->model->MyAccountUpdatePassword($data,$id);


	}

	public function adminprofileupload($id)
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['allowed_types'] = '*';
		// $config['encrypt_name']  = false;
		$config['remove_spaces']  = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config); //Make this line must be here.
		if ( ! $this->upload->do_upload('adminphoto'))
		{


			$errors = array('errors' => $this->upload->display_errors());
			$this->session->set_flashdata($errors);
			redirect('myaccount');

		} else {

			$upload_data = $this->upload->data();
			$image = base_url().'assets/uploads/'.$upload_data['file_name'];
			$result = $this->model->UploadProfile($image,$id);

		}
	}

	public function studentprofileupload($id)
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{


			$errors = array('errors' => $this->upload->display_errors());
			$this->session->set_flashdata($errors);
			redirect('profile');

		} else {

			$upload_data = $this->upload->data();
			$image = base_url().'assets/uploads/'.$upload_data['file_name'];
			$result = $this->model->UploadProfile($image,$id);

			if($result)
			{

				redirect('profile');

			}
		}
	}


	public function SchoolLogoUpdate($id)
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{


			$errors = array('errors' => $this->upload->display_errors());
			$this->session->set_flashdata($errors);
			echo 'error';

		} else {

			$upload_data = $this->upload->data();
			$image = base_url().'assets/uploads/'.$upload_data['file_name'];
			echo 'success';
			$result = $this->model->SchoolLogo($image,$id);

		}
	}

	public function login()
	{

		$username = $this->post('username');
		$password = $this->post('password');

		$result = $this->model->UserLogin($username, $password);

		if ($result) {

			$id 	= $this->model->GetId($username);
			$user 	= $this->model->GetUserInformation($id);
			$role 	= $user->role;
			$email 	= $user->email;
			$newdata = array('session_id' => $id,'role' => $role,'logged_in' => TRUE,'email'=>$email);
			switch ($role)
			{
				case 0:
				$this->session->set_userdata($newdata);
				echo 'admin';
				break;

				case 1:
				$this->session->set_userdata($newdata);
				echo 'student';
				break;
			}

		} else {

		echo 'error';

		}

	}

	public function finish()
	{
		$code = rand(111111,999999);
		$_SESSION['code'] = $code;
		$result = $this->model->GetQuestionByAnswer();
		foreach ($result as $key => $value) {
			$data['correct'] = $value['answer'];
			$data['answer'] = $this->post('answer')[$key];
			$data['answer'] != $data['correct'] ? $status = 'wrong' : $status = 'correct';
			$data = array('status' => $status,'code'=> $_SESSION['code']);
			$result = $this->model->CalculateResult($data);
		} if($result) {
			$squery = $this->model->CountScore($_SESSION['code']);
			$score 	= $_SESSION['score'];
			$percentage = $score / 20 * 50 + 50;
			$percentage < 75 ? $stats = 'Failed' : $stats = 'Passed';
			$date = date('F j, \ Y h:i A');
			$user 	= $this->model->GetUserInformation($_SESSION['session_id']);
			$name 	= $user->name;
			$email 	= $user->email;
			$result_data = array(
				'name'=>$name, 'email'=>$email, 'score'=>$score,
				'percentage'=>$percentage, 'status' => $stats,'date'=>$date);
			$query = $this->model->ExaminationResult($result_data);
			if($query) {
				$this->model->DeleteTempTable($_SESSION['code']);
				unset($_SESSION['active'],$_SESSION['score'],$_SESSION['code']);
				$_SESSION['done'] = 'Active';
				redirect('done');
			}
		}
	}


	public function add_question()
	{

		$data = array('normal' => 'trim|required|xss_clean');
		$this->validate('question','Question',$data['normal']);
		$this->validate('category','category',$data['normal']);
		$this->validate('answer','Answer',$data['normal']);
		$this->validate('option_a','Choices A',$data['normal']);
		$this->validate('option_b','Choices B',$data['normal']);
		$this->validate('option_c','Choices C',$data['normal']);
		$this->validate('option_d','Choices D',$data['normal']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('view_questions');

		}

		$data = array(
			'question' 	=> $this->post('question'),
			'category' 	=> $this->post('category'),
			'answer' 	=> $this->post('answer'),
			'option_a' 	=> $this->post('option_a'),
			'option_b' 	=> $this->post('option_b'),
			'option_c' 	=> $this->post('option_c'),
			'option_d' 	=> $this->post('option_d')
			);

		$result = $this->model->AddNewQuestions($data);

	}

	public function add_category()
	{

		$this->validate('category','Category','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('view_category');

		}

		$data = array('category' => $this->post('category'));
		$result = $this->model->AddNewCategory($data);


	}

	public function add_instructions()
	{

		$this->validate('instructions','Instructions','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('view_instructions');

		}

		$data = array('instructions' => $this->post('instructions'));
		$result = $this->model->AddNewInstructions($data);

	}



	public function add_student()
	{

		$data = array(
			'normal' => 'trim|required|xss_clean',
			'email' => 'trim|required|valid_email|xss_clean',
			'number' => 'trim|required|max_length[11]|min_length[11]|xss_clean',
			'name' => 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]|xss_clean'
			);

		$this->validate('name','Student Name',$data['name']);
		$this->validate('email','Student Email',$data['email']);
		$this->validate('address','Student Address',$data['normal']);
		$this->validate('gender','Student Gender',$data['normal']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors(' <i class="fa fa-remove"></i> '));
			$this->session->set_flashdata($data);
			redirect('addstudents');

		}

		$gender = $this->post('gender');

		switch ($gender)
		{

			case 'Male':
			$image = base_url().'assets/images/male.jpg';
			break;

			case 'Female':
			$image = base_url().'assets/images/female.jpg';
			break;

		}

		$regdate = date('F j, \ Y h:i A');
		$username = 'ES-'.rand(1111111,9999999);
		$name = $this->post('name');
		$email = $this->post('email');
		$data = array(
			'image' 	=> $image,
			'name' 		=> $name,
			'email' 	=> $email,
			'address' 	=> $this->post('address'),
			'gender' 	=> $gender,
			'role' 		=> 1,
			'username' 	=> $username,
			'password'	=> $this->encrypt(12345),
			'date' 		=> $regdate
			);

        $subject = 'Online Examination';
        $message = '

        	<div style="max-width:92%;border-left:solid 1px #313d49;border-right:solid 1px #313d49;border-top:solid 1px #313d49;border-bottom:solid 1px #313d49;background-color:#f5f5f5;padding:10px;text-align:center">

        		<h3 style="color:#000">ONLINE EXAMINATION SYSTEM</h3>

        	</div>

        	<div style="max-width:92%;background-color:#ffffff;border-left:1px solid #313d49;border-right:solid 1px #313d49;padding:10px;">

        		<h4>Hello '.$name.',</h4>

        		<h4>Please be active on this email to be updated to your upcoming online examination.</h4>
        		<h4>Please login with this credentials</h4>
        		<a href="http://localhost/examination_system/login"
        		style="float:right;background:#313d49;text-decoration:none;padding:10px;color:#fff;
        		font-weight:bolder">
        		CLICK ME TO LOGIN</a>
        		<h4>Username: <i>'.$username.'</i></h4>
        		<h4>Password: <i>12345</i></h4>

        		<h5 style="color:#ff0000;font-weight:bolder">Note: <i>If you have any questions or issues, you may email us @(email ng websitemo).</i></h5>
        	</div>

        	<div style="width:92%;background-color:#313d49;border-left:1px solid #313d49;border-right:solid 1px #313d49;padding:10px;text-align:center">

        		<h4 style="color:#fff">All Rights Reserved @ '.date('Y').'</h4>

        	</div>


        ';




			$this->email->to($email)->from('a@yahoo.com')->subject($subject)->message($message);

			if(!$this->email->send()) {
				echo 'connection error';

			} else {

			$result = $this->model->AddNewStudents($data);
			$response = $this->session->userdata('notif');
			switch ($response) {

			case 'duplicated':
				echo 'duplicated';
			break;

			case 'success':
				echo 'success';
			break;

			}
		}
	}

	public function modify_question()
	{


		$data = array('normal' => 'trim|required|xss_clean');
		$this->validate('question','Question',$data['normal']);
		$this->validate('category','category',$data['normal']);
		$this->validate('answer','Answer',$data['normal']);
		$this->validate('option_a','Choices A',$data['normal']);
		$this->validate('option_b','Choices B',$data['normal']);
		$this->validate('option_c','Choices C',$data['normal']);
		$this->validate('option_d','Choices D',$data['normal']);

		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('question/modify/'.$id);

		}

		$data = array(
			'id' 		=> $this->post('id'),
			'category' 	=> $this->post('category'),
			'question' 	=> $this->post('question'),
			'answer' 	=> $this->post('answer'),
			'option_a' 	=> $this->post('option_a'),
			'option_b' 	=> $this->post('option_b'),
			'option_c' 	=> $this->post('option_c'),
			'option_d' 	=> $this->post('option_d')
			);

		$result = $this->model->UpdateQuestions($data);

	}


	public function modify_category()
	{

		$this->validate('category','category','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('category/modify/'.$id);

		}

		$data = array('id' 	=> $this->post('id'),'category' => $this->post('category'));

		$result = $this->model->UpdateCategory($data);


	}

	public function modify_instructions()
	{

		$this->validate('instructions','instructions','trim|required|xss_clean');
		if($this->form_validation->run() == FALSE)
		{

			$data = array('errors'=>validation_errors());
			$this->session->set_flashdata($data);
			redirect('instructions/modify/'.$id);

		}

		$data = array('id' 	=> $this->post('id'),'instructions' => $this->post('instructions'));

		$result = $this->model->UpdateInstructions($data);


	}

	public function logout()
	{

		if(isset($_SESSION['role']) == 1 && isset($_SESSION['active'])) {
			$user 	= $this->model->GetUserInformation($_SESSION['session_id']);
			$name 	= $user->name;
			$email 	= $user->email;
			$result_data = array('name'=>$name, 'email'=>$email,'score'=>0,'percentage'=>0,'status' => 'Failed');
			$query = $this->model->ExaminationResult($result_data);
			unset($_SESSION['name'],$_SESSION['session_id'],$_SESSION['logged_in'],$_SESSION['role'],$_SESSION['done'],$_SESSION['active']);
			redirect('login');
		} else {
			unset($_SESSION['name'],$_SESSION['session_id'],$_SESSION['logged_in'],$_SESSION['role'],$_SESSION['done']);
			redirect('login');
		}


	}


	private function encrypt($password)
	{

		return password_hash($password, PASSWORD_DEFAULT);

	}

	public function checkresult($email)
	{

		$encoded = urldecode($email);
		$result = $this->model->CheckResultByEmail($encoded);
		return $result;
	}



	public function dbexport()
	{

		$this->load->dbutil();
		$prefs = array(
		'format' => 'zip',
		'filename' => 'examination_system.sql'
		);
		$backup = $this->dbutil->backup($prefs);
		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'assets/backup/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup);
		echo'success';
	}

}
