<?php
class Satker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->form_validation->set_message('required', '<strong>%s</strong> harus diisi.');
        $this->form_validation->set_message('numeric', '<strong>%s</strong> harus angka.');
        $this->form_validation->set_message('min_length', '<strong>%s</strong> harus %s angka.');
        $this->form_validation->set_message('max_length', '<strong>%s</strong> harus %s angka.');
    }

    public function index($id = 0)
    {
        if ($this->input->get('submit')) {
            $result = $this->db->from('tb_satker a')
                    ->join('tb_kementrian b', 'b.id_kementrian = a.id_kementrian')
                    ->join('tb_petugas_satker c', 'c.id_satker = a.id_satker')
                    ->like('nama_kementrian', $this->input->get('cari'))
                    ->or_like('nama_satker', $this->input->get('cari'))
                    ->or_like('id_satker', $this->input->get('cari'))
                    ->get();

        } else {
            $config['per_page'] = 25;
            $config['total_rows'] = $this->db->count_all('tb_satker');
            $config['base_url'] = site_url('/admin/satker/index/');
            $config['uri_segment'] = 4;
            $config['use_page_numbers'] = false;
            $config['num_links'] = 10;

            $this->pagination->initialize($config);

            $result = $this->db->from('tb_satker a')
                    ->join('tb_kementrian b', 'b.id_kementrian = a.id_kementrian')
            //->join('tb_petugas_satker c', 'c.id_satker = a.id_satker')
                    ->limit($config['per_page'], $id)
                    ->get();
        }

        $data['bla'] = $result;
        $data['title'] = 'Daftar Satker';
        $data['content'] = 'admin/satker';

        $this->load->view('admin/template', $data);
    }

    public function view_satker($id_satker)
    {
        $result = $this->db->from('tb_petugas_satker a')
                ->join('tb_satker b', 'b.id_satker = a.id_satker')
                ->join('tb_kementrian c', 'b.id_kementrian = c.id_kementrian')
                ->where('a.id_satker', $id_satker)
                ->get();

        $data['satker'] = $result;

        $data['title'] = 'Lihat Satker';
        $data['content'] = 'admin/view_satker';

        $this->load->view('admin/template', $data);
    }

    public function edit($id_satker)
    {
        if (isset($_POST)) {

            $this->form_validation->set_rules('nama_satker', 'Nama Satker', 'required');

            if ($this->form_validation->run()) {
                //SEKRETARIAT JENDERAL
                $this->db->update('tb_satker', array(
                    'nama_satker' => $this->input->post('nama_satker')
                ), array(
                    'id_satker' => $id_satker
                ));
                $this->session->set_flashdata('success', 'Data berhasil diubah');
                $this->log->create("Mengubah data satker (id_satker => {$id_satker})");
            }
        }
        $result = $this->db->from('tb_petugas_satker a')
                ->join('tb_satker b', 'b.id_satker = a.id_satker')
                ->join('tb_kementrian c', 'b.id_kementrian = c.id_kementrian')
                ->where('a.id_satker', $id_satker)
                ->get()->row();

        $data['satker'] = $result;

        $data['title'] = 'Ubah Satker';
        $data['content'] = 'admin/edit_satker';

        $this->load->view('admin/template', $data);
    }

    public function add()
    {
        if (isset($_POST)) {

            $this->form_validation->set_rules('id_satker', 'Kode Satker', 'required|numeric|min_length[6]|max_length[6]');
            $this->form_validation->set_rules('nama_satker', 'Nama Satker', 'required');
            $this->form_validation->set_rules('id_kementrian', 'Nama Kementrian', 'required');

            if ($this->form_validation->run()) {

                $result = $this->db->insert('tb_satker', array(
                    'id_satker' => $this->input->post('id_satker'),
                    'nama_satker' => $this->input->post('nama_satker'),
                    'id_kementrian' => $this->input->post('id_kementrian'),
                ));

                if (!$result) {
                    $this->session->set_flashdata('error', 'Data gagal ditambahkan. ERROR: ' . $this->db->_error_message());
                    $this->log->create("Gagal menambahkan data satker. ERROR: " . $this->db->_error_message());
                } else {
                    $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
                    $this->log->create("Menambah data satker (id_satker => {$this->db->insert_id()})");
                }

            }
        }
        $result = $this->db->from('tb_kementrian')->get();

        $data['kementrian'] = $result;

        $data['title'] = 'Tambah Satker';
        $data['content'] = 'admin/add_satker';

        $this->load->view('admin/template', $data);
    }
}