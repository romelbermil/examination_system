<?php 
defined('BASEPATH') or exit ('No direct access script allowed.');

class dashboard extends CI_Controller 
{

	public function __construct()
	{
	
		parent::__construct();
		
	}

	public function index()
	{	
		$data['res'] = array(
			'page_title' 	=> 'Online Examination System',
			'title'			=>'Examination System',
			'greetings'		=>'Howdy,'
			);
		$data['count'] 		= $this->model->CountRegisteredUsers();
		$data['attended'] 	= $this->model->CountStudentAttended();
		$data['passed'] 	= $this->model->CountPassingStudents();
		$data['failed'] 	= $this->model->CountFailedStudents();
		$data['data'] 		= $this->session->userdata();
		$data['result'] 	= $this->model->GetSchoolinformation();
		$data['url'] 		= base_url();
		$data['admin_data'] = $this->model->GetInformation($_SESSION['session_id']);
		$this->load->view('template/components/header',$data);
		$this->load->view('template/pages/admin/navs/navs');
		$this->load->view('template/pages/admin/dashboard',$data);

	}

}