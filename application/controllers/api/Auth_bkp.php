<?php
// import library dari REST_Controller
require APPPATH . 'libraries/REST_Controller.php';

// extends class dari REST_Controller
class Auth extends REST_Controller
{
  // constructor
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Api_auth_model');
  }
  public function index_post()
  {
    $uname = $this->post('email');
    $pass = $this->post('password');

    $cek = $this->Api_auth_model->cekUser($uname);

    $resp = array('success' => 1, 'message' => 'success', 'username' => $uname);
    echo json_encode($resp);

    // $this->response(array('success' => 1, 'message' => 'success', 'username' => $uname), REST_Controller::HTTP_OK);
    // if (!$cek) {
    //   $this->response(array('status' => false, 'message' => 'User Tidak Terdaftar'), REST_Controller::HTTP_OK);
    // } else {
    //   $login = $this->Api_auth_model->login($uname, $pass);

    //   if ($login) {
    //     $this->response(array('success' => 1, 'message' => 'success', 'username' => $uname), REST_Controller::HTTP_OK);
    //   } else {
    //     $this->response(array('status' => false, 'message' => 'Password Salah'), REST_Controller::HTTP_OK);
    //   }
    // }
  }

  public function user_get()
  {
    // testing response
    $response['status'] = 200;
    $response['error'] = false;
    $response['user']['username'] = 'erthru';
    $response['user']['email'] = 'ersaka96@gmail.com';
    $response['user']['detail']['full_name'] = 'Suprianto D';
    $response['user']['detail']['position'] = 'Developer';
    $response['user']['detail']['specialize'] = 'Android,IOS,WEB,Desktop';
    //tampilkan response
    $this->response($response);
  }
}
