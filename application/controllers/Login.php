<?php
/*	Controller for login page 
Name : Login
Function : Takes arguments from "loginpage" validates and send to model "md_login".
*/

class Login extends CI_Controller{
	public function __construct()
		{
			parent::__construct();
		}
		
		
	function index()
	{	
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');		//importing validation library
		
		$parameter = array(
		'user_name' => $this->input->post('user_name'),
		'password'=> $this->input->post('password')
		);
		
		if (!is_numeric($parameter['user_name']))
		$this->form_validation->set_rules('user_name', 'E-mail', 'required|min_length[5]|max_length[50]|valid_email');	//validation rule for login with email
		
		else
		$this->form_validation->set_rules('user_name', 'Phone No.', 'required|min_length[10]|max_length[100]|callback_check_digit');		//validation rule for login with phone no.
		
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[50]');			//validation rule for password
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['uname_error']="Incorrect Username Type";
			$this->load->view('login',$data);
			
		}
		else
		{
			$this->load->model('md_login');
			$data['user_id']=$this->md_login->login($parameter['user_name'],$parameter['password']);
			if($data['user_id']==0)
			{
				$data['uname_error']="Incorrect Username & Password Combination";
				$this->load->view('login',$data);
			}
			else
			{
				$this->load->library('session');
				$array = array('user_name' => $parameter['user_name'], 'user_id' => $data['user_id']);
				$this->session->set_userdata($array);
				$this->load->view('done',$data);
			}
		}
	}

/*	Function name : check_digit
Function : ensures the presence of only digits in user entered phone no.*/
	
function check_digit($str)
	{	
		if (ctype_digit($str))
		return TRUE;
		else
		{
			$this->form_validation->set_message('check_digit','The %s field must contain only decimal digits');
			return false;
		}
	}
}
?>