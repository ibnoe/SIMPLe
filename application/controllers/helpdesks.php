<?php
// $this->session->userdata('id_tiket_helpdesk') ===> ID
// $this->session->userdata('no_tiket_helpdesk') ===> no_tiket_helpdesk

class Helpdesks extends CI_Controller
{
    public $template = 'new-template';

    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_message('required', '%s harus diisi');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
    }

    public function index()
    {
        redirect('helpdesks/dashboard');
    }

    public function dashboard()
    {
        $data['title'] = 'Helpdesk - Dashboard';
        $data['content'] = 'new-helpdesk/dashboard';
        $this->load->view($this->template, $data);
    }

    public function identity()
    {

        $data['kementrian'] = $this->db->get('tb_kementrian');
        $data['title'] = 'Helpdesk - Identitas';
        $data['content'] = 'new-helpdesk/identity';
        $this->load->view($this->template, $data);
    }

    public function pertanyaan()
    {
        // Load data petugas Satker
        $id_petugas_satker = $this->session->userdata('id_petugas_satker');

        $result = $this->db->from('tb_petugas_satker a')
                ->join('tb_satker b', 'a.id_satker = b.id_satker')
                ->where('id_petugas_satker', $id_petugas_satker)
                ->get()->row();

        $data['identitas'] = $result;


        // Load kategori pertanyaan helpdesk
        $data['kategori'] = $this->db->from('tb_kat_knowledge_base')->order_by('kat_knowledge_base')->get();

        // Jika ada pertanyaan sebelumnya, Load it!!
        if ($this->input->get('prev_question')) {
            $prev_question = $this->db->from('tb_tiket_helpdesk')
                    ->where('no_tiket_helpdesk', $this->session->userdata('no_tiket_helpdesk'))
                    ->get();
            $data['prev_question'] = $prev_question;
        }

        $data['title'] = 'Helpdesk - Pertanyaan';
        $data['content'] = 'new-helpdesk/pertanyaan';
        $this->load->view($this->template, $data);
    }

    public function jawaban()
    {
        // Load data petugas Satker
        $id_petugas_satker = $this->session->userdata('id_petugas_satker');

        $result = $this->db->from('tb_petugas_satker a')
                ->join('tb_satker b', 'a.id_satker = b.id_satker')
                ->where('id_petugas_satker', $id_petugas_satker)
                ->get()->row();

        $data['identitas'] = $result;

        // Load Kategori Knowledge Base
        $result = $this->db->from('tb_tiket_helpdesk a')
                ->join('tb_kat_knowledge_base b', 'a.id_kat_knowledge_base = b.id_kat_knowledge_base')
                ->where('no_tiket_helpdesk', $this->session->userdata('no_tiket_helpdesk'))
                ->get();

        $data['pertanyaan'] = $pertanyaan = $result->row();


        $result = $this->db->from('tb_knowledge_base')
                ->where('id_kat_knowledge_base', $pertanyaan->id_kat_knowledge_base)
                ->or_like('judul', $this->input->post('pertanyaan'))
                ->or_like('jawaban', $this->input->post('pertanyaan'))
                ->get();

        $data['jawaban'] = $result;

        $data['title'] = 'Helpdesk - Jawaban';
        $data['content'] = 'new-helpdesk/jawaban';
        $this->load->view($this->template, $data);
    }

    public function eskalasi($id_tiket_frontdesk, $no_tiket_frontdesk)
    {
        $this->db->update('tb_tiket_helpdesk', array(
            'lavel' => 2
        ), array(
            'id' => $this->session->userdata('id_tiket_helpdesk')
        ));

        $this->session->set_flashdata('info', 'Pertanyaan berhasil di-eskalasi ke Penyelia');
        // Kembali ke pertanyaan
        redirect('helpdesks/pertanyaan/?prev_question=true');
    }

    public function save($step)
    {
        // Simpan Identitas Satker
        if ($step == 'step1') {

            $this->form_validation->set_rules('nama_kl', 'K/L', 'required');
            $this->form_validation->set_rules('eselon', 'Eselon I', 'required');
            $this->form_validation->set_rules('kode_satker', 'Satker', 'required');
            $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');
            $this->form_validation->set_rules('jabatan_petugas', 'Jabatan', 'required');
            $this->form_validation->set_rules('no_hp', 'No HP', 'required|numeric');
            $this->form_validation->set_rules('no_kantor', 'Telpon Kantor', 'required|numeric');
            $this->form_validation->set_rules('email', 'Email', 'required|email');

            if ($this->form_validation->run() == TRUE) {


                // Simpan data Satker yang bertanya
                $this->db->insert('tb_petugas_satker', array(
                    'nama_petugas' => $this->input->post('nama_petugas'),
                    'jabatan_petugas' => $this->input->post('jabatan_petugas'),
                    'no_hp' => $this->input->post('no_hp'),
                    'no_kantor' => $this->input->post('no_kantor'),
                    'email' => $this->input->post('email'),
                    'id_satker' => $this->input->post('kode_satker'),
                ));

                // Simpan ID terakhir yang dimasukkan untuk nandain petugas satker
                $id_petugas_satker = $this->db->insert_id();
                $this->session->set_userdata('id_petugas_satker', $id_petugas_satker);

                // Ambil tiket terakhir
                $no_tiket_helpdesk_terakhir = $this->db->select_max('no_tiket_helpdesk')->get('tb_tiket_helpdesk')->row();
                $no_tiket_helpdesk_terakhir = $no_tiket_helpdesk_terakhir->no_tiket_helpdesk + 1;

                // Simpan tiket baru
                $this->db->insert('tb_tiket_helpdesk', array(
                    'no_tiket_helpdesk' => $no_tiket_helpdesk_terakhir,
                    'tanggal' => date('Y-m-d H:i:s')
                ));

                // Simpan ID tiket helpdesk
                $id_tiket_helpdesk = $this->db->insert_id();
                $this->session->set_userdata('id_tiket_helpdesk', $id_tiket_helpdesk);

                //            $no_tiket_helpdesk = $this->db->from('tb_tiket_helpdesk')
                //                    ->where('id', $id_tiket_helpdesk)
                //                    ->get();

                // Simpan NOMOR tiket helpdesk
                $this->session->set_userdata('no_tiket_helpdesk', $no_tiket_helpdesk_terakhir);


                redirect('helpdesks/pertanyaan');
            }

            $this->identity();


        } elseif ($step == 'step2') {

            if ($this->input->get('prev_question')) {
                // Simpan tiket baru
                $this->db->insert('tb_tiket_helpdesk', array(
                    'no_tiket_helpdesk' => $this->session->userdata('no_tiket_helpdesk'),
                    'pertanyaan' => $this->input->post('pertanyaan'),
                    'description' => $this->input->post('description'),
                    'prioritas' => $this->input->post('prioritas'),
                    'id_kat_knowledge_base' => $this->input->post('kategori_knowledge_base'),
                    'id_satker' => $this->input->post('id_satker'),
                    'tanggal' => date('Y-m-d H:i:s')
                ));

                // Simpan ID tiket helpdesk
                $id_tiket_helpdesk = $this->db->insert_id();
                $this->session->set_userdata('id_tiket_helpdesk', $id_tiket_helpdesk);

            } else {

                $this->db->update('tb_tiket_helpdesk', array(
                        'no_tiket_helpdesk' => $this->input->post('no_tiket_helpdesk'),
                        'pertanyaan' => $this->input->post('pertanyaan'),
                        'description' => $this->input->post('description'),
                        'prioritas' => $this->input->post('prioritas'),
                        'id_kat_knowledge_base' => $this->input->post('kategori_knowledge_base'),
                    ), array(
                        'id' => $this->session->userdata('id_tiket_helpdesk')
                    )
                );

                $this->session->set_userdata('no_tiket_helpdesk', $this->input->post('no_tiket_helpdesk'));
            }

            $this->jawaban();
            //            redirect('helpdesks/jawaban');
        }
    }

    function list_pertanyaan($page = '')
    {
        $config['base_url'] = site_url('helpdesks/list_pertanyaan');
        $config['uri_segment'] = 3;
        $config['num_links'] = 10;

        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;


        if ($page == '') {
            $result = $this->db->from('tb_tiket_helpdesk a')
                    ->join('tb_satker b', 'b.id_satker = a.id_satker')
                    ->order_by('prioritas DESC')
                    ->order_by('status')
                    ->limit($config['per_page'])
                    ->get();
        } else {
            $result = $this->db->from('tb_tiket_helpdesk a')
                    ->join('tb_satker b', 'b.id_satker = a.id_satker')
                    ->order_by('prioritas DESC')
                    ->order_by('status')
                    ->limit($config['per_page'], $page * $config['per_page'] - $config['per_page'])
                    ->get();
        }

        $config['total_rows'] = $this->db->from('tb_tiket_helpdesk a')
                ->join('tb_satker b', 'b.id_satker = a.id_satker')
                ->order_by('prioritas DESC')
                ->order_by('status')
                ->get()
                ->num_rows();

        $this->pagination->initialize($config);

        $data['helpdesk'] = $result;

        $data['kementrian'] = $this->db->query('SELECT * FROM tb_kementrian ORDER BY id_kementrian');
        $data['title'] = 'List Pertanayaan';
        $data['content'] = 'new-helpdesk/list_pertanyaan';
        $this->load->view('new-template', $data);
    }


}