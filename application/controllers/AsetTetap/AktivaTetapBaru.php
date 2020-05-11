<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AktivaTetapBaru extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data['title'] = "Aset Tetap | Aktiva Tetap Baru";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('errors/html/under_construction');
    $this->load->view('templates/footer');
  }
}
