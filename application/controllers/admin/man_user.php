<?php
class Man_user extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->model('Muser','muser');
    }

    var $title = 'Manajemen User';

    function index()
    {
		$page		= $this->muser->get_all_user();
		$pageData	= $page['query']->result();
		$pageLink	= $page['pagination1'];
		
		$data		= array('result'=>$pageData,'pageLink'=>$pageLink,);
		
        $data['title'] 		= 'Manajemen User';
        $data['content'] 	= 'admin/man_user/man_user';
		
        $this->load->view('admin/template', $data);
       
    }
	
	function reset_password(){
		$user	= trim($this->uri->segment(4,''));
		if(!empty($user)){
			$info = $this->muser->reset_password($user);
			if($info){
				$this->session->set_flashdata('msg',"<div style='color:blue;'>berhasil mereset password</div>");
				redirect('admin/man_user');
			}else{
				$this->session->set_flashdata('msg',"<div style='color:red;'>gagal mereset password</div>");
				redirect('admin/man_user');
			}
		}
	}
	
	function delete($user){
		$user = trim($this->uri->segment(4,''));
		if(!empty($user)){
			$info = $this->muser->delete_user($user);
			if($info){
				$this->session->set_flashdata('msg',"<div style='color:blue;'>berhasil menghapus user</div>");
				redirect('admin/man_user');
			}else{
				$this->session->set_flashdata('msg',"<div style='color:red;'>gagal menghapus user</div>");
				redirect('admin/man_user');
			}
		}
	}
}

?>