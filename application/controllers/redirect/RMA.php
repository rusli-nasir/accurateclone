<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RMA extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data['title'] = "RMA";
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('redirect/rma');
    $this->load->view('templates/footer');
  }
}
