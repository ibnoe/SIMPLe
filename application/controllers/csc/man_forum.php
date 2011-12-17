<?php
class Man_forum extends CI_Controller
{

    function Man_forum()
    {
        parent::__construct();
        $this->load->model('mforum');
        $this->load->helper('text');
    }

    function index()
    {
        $result = $this->mforum->get();

        $data['title'] = 'Manajemen Forum';
        $data['content'] = 'csc/man_forum/man_forum';
        $data['forums'] = $result;
        $this->load->view('csc/template', $data);
    }

    function view($id)
    {
        $result = $this->mforum->get_one($id);

        $data['title'] = 'Manajemen Forum';
        $data['content'] = 'csc/man_forum/man_forum_view';
        $data['forums'] = $result;
        $this->load->view('csc/template', $data);
    }
}