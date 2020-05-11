<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->load->model('Auth_model');
    $this->load->library('cart');
    $this->cart->destroy();
    if ($this->session->userdata('masuk') == TRUE) {
      $role = $this->session->userdata('role');
      if ($role == 1 || $role == 2)
        redirect("Dashboard");
      else
        redirect("Kasir");
    } else {
      if (!$this->Auth_model->validation()) {
        $this->load->view('auth/login');
      } else {
        //validasi login sukses
        $this->_login();
      }
    }
  }

  private function _login()
  {
    $uname = htmlspecialchars($this->input->post('username', TRUE), ENT_QUOTES);
    $pwd = $this->input->post('password');

    $user = $this->Auth_model->getUserData($uname);

    if ($user) {
      //jika ada user
      if (password_verify($pwd, $user['password'])) {
        //jika password benar
        $data_user = [
          'uname' => $user['username'],
          'nama' => $user['nama'],
          'role' => $user['kode_peran'],
          'toko' => $user['toko_id'],
          'masuk' => TRUE
        ];

        $this->session->set_userdata($data_user);

        if ($data_user['role'] == 1 || $data_user['role'] == 2)
          redirect('Dashboard');
        else
          redirect('Kasir');
      } else {
        //jika password salah
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Password salah!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>');
        redirect('Auth');
      }
    } else {
      //jika tidak ada user
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Username tidak terdaftar!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
      redirect('Auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('uname');
    $this->session->unset_userdata('role');

    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			Anda telah logout.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
    </div>');
    $this->session->sess_destroy();
    redirect('Auth');
  }
}
