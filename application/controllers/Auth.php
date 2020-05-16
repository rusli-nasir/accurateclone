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
    if ($this->session->userdata('masuk') == TRUE) {
      $redirect_to = $this->Auth_model->getWhereToRedirect($this->session->userdata('uname'))['link_menu'];
      redirect("redirect/$redirect_to");
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
          'divisi_id' => $user['divisi_id'],
          'masuk' => TRUE
        ];

        $this->session->set_userdata($data_user);
        $redirect_to = $this->Auth_model->getWhereToRedirect($this->session->userdata('uname'))['link_menu'];
        redirect("redirect/$redirect_to");
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
    $this->session->unset_userdata('nama');
    $this->session->unset_userdata('divisi_id');
    $this->session->unset_userdata('masuk');


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
