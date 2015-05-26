<?php
class Auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model(array('m_petugas'));
	}
	
	function index() {
		$this->load->view('auth/login');
	}

	function login(){
		$this->load->view('auth/login');
	}
	
	function proses() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('message', 'Username dan password harus diisi');
			redirect('auth');
		} 
		else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$cek = $this->m_petugas->cek($username, md5($password));
			if ($cek->num_rows() > 0) {
				$res = $cek->row();
				//login berhasil, buat session
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('id', $res->id_petugas);
				redirect('dashboard');
			} 
			else {
				
				//login gagal
				$this->session->set_flashdata('message', 'Username atau password salah');
				redirect('auth');
			}
		}
	}
	
	function logout() {
		$this->session->unset_userdata('username');
		redirect('/');
	}
}
