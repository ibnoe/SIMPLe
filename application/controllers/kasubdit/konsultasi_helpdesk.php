<?php
class Konsultasi_helpDesk extends CI_Controller
{

    function Konsultasi_helpDesk()
    {
        parent::__construct();
    }

    var $title = 'Konsultasi Help Desk';

    function index()
    {
        /*if ($this->session->userdata('login') == TRUE)
          {*/
        $data['title'] = 'Konsultasi Help Desk';
        $data['content'] = 'kasubdit/konsultasi_helpDesk';
        $this->load->view('master-template', $data);
        /*}
          else
          {
              $this->load->view('login/login_view');
          }*/
    }
}

?>