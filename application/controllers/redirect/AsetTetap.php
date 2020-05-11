<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AsetTetap extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data['title'] = "Aset Tetap";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('redirect/aset_tetap');
    $this->load->view('templates/footer');
  }
}
