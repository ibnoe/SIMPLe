<?php
class Muser extends CI_Model
{
    function get_all_user(){
		$this->load->library('pagination');		
		$sql = "SELECT id_user, username, nama, email, no_tlp, kode_unit, id_lavel
				FROM tb_user 
				ORDER BY nama ASC";
		$query = $this->db->query($sql);

		$config['base_url'] = site_url('admin/man_user/index');
		$config['total_rows'] = $query->num_rows();
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);

		$offset = (int) $this->uri->segment(4, 0);
		
		$sqlb = "SELECT id_user, username, nama, email, no_tlp, kode_unit, id_lavel
				FROM tb_user 
				ORDER BY nama ASC
				LIMIT ?,?";
		$data["query"] = $this->db->query($sqlb, array($offset ,$config['per_page']));

		$data['pagination1'] = $this->pagination->create_links();

		return $data;
	}
	
	function get_all_user_by_id($keyword){
		$this->load->library('pagination');
		$uri_segment = 6;
		$offset = (int) $this->uri->segment($uri_segment,0);	
		
		
		$total_seg = $this->uri->total_segments(); //print_r($total_seg);exit();
		$default = array("keyword");
		
		if($total_seg > 4){
			$this->terms = $this->uri->uri_to_assoc(4,$default);
			
			if($this->terms['keyword'] != ''){
				$keyword = $this->terms['keyword'];
			}else{
				$this->terms['keyword'] = $keyword;
			}
			
			$uriparams['keyword'] = $this->terms['keyword'];
			
			if(($total_seg % 2) > 0){
				$offset = (int) $this->uri->segment(6, 0);
			}
			
			$url_add = $this->uri->assoc_to_uri($uriparams);
		}else{
			$searchparams = array();
			$searchparams['keyword'] 	= $keyword; 
			$url_add = $this->uri->assoc_to_uri($searchparams);
		
		}
		
		$where = " WHERE username LIKE '%".$keyword."%' OR nama LIKE '%".$keyword."%'";
		
		$sql = "SELECT id_user, username, nama, email, no_tlp, kode_unit, id_lavel
				FROM tb_user $where
				ORDER BY nama ASC";
		$query = $this->db->query($sql);

		$config['base_url'] = site_url('admin/man_user_cari/index').'/'.$url_add.'/';
		$config['total_rows'] = $query->num_rows();
		$config['per_page'] = 50;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		
		
		
		$sqlb = "SELECT id_user, username, nama, email, no_tlp, kode_unit, id_lavel
				FROM tb_user $where
				ORDER BY nama ASC
				LIMIT ?,?";
		$data["query"] = $this->db->query($sqlb, array($offset ,$config['per_page']));

		$data['pagination1'] = $this->pagination->create_links();

		return $data;
	}
	
	function get_list_level(){
		return $this->db->query('SELECT id_lavel, nama_lavel FROM tb_lavel')->result();
	}
	
	function get_list_unit(){
		return $this->db->query("SELECT kode_unit, nama_unit FROM tb_unit_saker")->result();
	}
	
	function reset_password($user){
		$cek = $this->db->query("select id_user from tb_user where id_user = ?", array($user))->num_rows();
		$info = false;

		if($cek > 0){
			if($this->db->query("UPDATE tb_user SET password = md5('12345') WHERE id_user = ?", array($user))){
				$info = true;
			}else{
				$info = false;
			}
		}
		
		return $info;
	}
	
	function delete_user($user){
		$cek = $this->db->query("select id_user from tb_user where id_user = ?", array($user))->num_rows();
		$info = false;

		if($cek > 0){
			if($this->db->query("DELETE FROM tb_user WHERE id_user = ?", array($user))){
				$info = true;
			}else{
				$info = false;
			}
		}
		
		return $info;
	}
	
	function add_user($d){
		$sql = "INSERT INTO tb_user(username,password,nama,email,no_tlp,kode_unit,id_lavel) values(?,?,?,?,?,?,?)";
		$this->db->query($sql,array($d['usr'],md5($d['pwd']),$d['nm'],$d['em'],$d['telp'],$d['dep'],$d['lev']));
		
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function get_edited_by_id($u){
		$sql = "SELECT id_user,username,nama,email,no_tlp,kode_unit,id_lavel FROM tb_user WHERE id_user = ? LIMIT 0,1";
		return $this->db->query($sql,array($u))->row();
	}
	
	function get_masa_kerja($u){
		$sql = "SELECT id_user,username,nama,email,no_tlp,kode_unit,id_lavel FROM tb_user WHERE id_user = ? LIMIT 0,1";
		return $this->db->query($sql,array($u))->row();
	}
	
	function edit_user($d){
		$sql = "UPDATE tb_user SET username = ?, nama = ?,email = ?, no_tlp = ?,kode_unit = ?,id_lavel = ? WHERE id_user = ?";
		$this->db->query($sql,array($d['usr'],$d['nm'],$d['em'],$d['telp'],$d['dep'],$d['lev'],$d['id']));
		
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function get_user_by_id($user){
		$sql = "SELECT a.id_user,a.username,a.nama,a.email,a.no_tlp, nama_unit,nama_lavel 
				FROM tb_user a, tb_unit_saker b, tb_lavel c 
				WHERE a.kode_unit = b.kode_unit AND a.id_lavel = c.id_lavel AND a.id_user = ? LIMIT 0,1";
		return $this->db->query($sql,array($user))->row();
	}
	
	function set_surat_kerja($d){
		$notvalid = array();
		
		if(!(checkdate($d['bln1'],$d['tgl1'],$d['thn1']))){
			$notvalid[] = "tanggal awal tidak valid"; 
		}
		
		if(!(checkdate($d['bln2'],$d['tgl2'],$d['thn2']))){
			$notvalid[] = "tanggal akhir tidak valid"; 
		}
		
		if(count($notvalid) < 1){
			$tgl_mulai		= $d['thn1'].'-'.$d['bln1'].'-'.$d['tgl1'];
			$tgl_selesai	= $d['thn2'].'-'.$d['bln2'].'-'.$d['tgl2'];
			
			if(strtotime($tgl_mulai) > strtotime($tgl_selesai)){
				$this->session->set_flashdata('msg',"<div style='color:red;'>tanggal awal lebih besar dari tanggal akhir</div>");
			}else{
				$sql = "INSERT INTO tb_masa_kerja(id_user,tanggal_mulai,tanggal_selesai) VALUES(?,?,?)";
				$this->db->query($sql,array($d['id'],$tgl_mulai,$tgl_selesai));
				
				if($this->db->affected_rows() > 0){
					$this->session->set_flashdata('msg',"<div style='color:blue;'>sukses</div>");
				}else{
					$this->session->set_flashdata('msg',"<div style='color:red;'>gagal</div>");
				}
			}	
		}else{
			$this->session->set_flashdata('msg',"<div style='color:red;'>".implode(', ',$notvalid)."</div>");
		}
		
		
	}
}