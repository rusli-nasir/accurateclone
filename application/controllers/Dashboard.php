<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    //validasi jika user belum login

    // if ($this->session->userdata('role') > 3) {
    //   $url_kasir = base_url('Kasir');
    //   redirect($url_kasir);
    // }

    // if ($this->session->userdata('masuk') != TRUE) {
    //   $url = base_url('Auth');
    //   redirect($url);
    // } else {
    //   $this->load->model('Notifikasi_model');
    //   $this->load->model('Dashboard_model');
    // }
    $this->load->model('Notifikasi_model');
    $this->load->model('Dashboard_model');
  }

  public function getFirstAndLastRecordDate()
  {
    $start = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
    $end = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
    $time_start = strtotime($start);
    $time_end = strtotime($end);
    $start = date('Y/m/d', $time_start);
    $end = date('Y/m/d', $time_end);

    $data = array(
      'start' => $start,
      'end' => $end
    );
    echo json_encode($data);
  }

  public function getFirstAndLastRecordDateAbsensi()
  {
    $this->load->model('Absen_model');
    $start = $this->Absen_model->getFirstDateOfRecord();
    $end = $this->Absen_model->getLastDateOfRecord();
    $start = date('Y/m/d', $start);
    $end = date('Y/m/d', $end);

    $data = array(
      'start' => $start,
      'end' => $end
    );
    echo json_encode($data);
  }

  public function getDisplayJudul()
  {
    $id = $this->input->post('id');
    $start = $this->input->post('start');
    $end = $this->input->post('end');

    if ($id != "all") {

      if ($start != "0" && $end != "0") {
        $nama = $this->Dashboard_model->getNamaToko($id);
        $nama = 'Toko ' . $nama;
        $range = date('j F Y', strtotime($start)) . ' s/d ' . date('j F Y', strtotime($end));
        $data = array(
          'nama' => $nama,
          'range' => $range
        );
        echo json_encode($data);
      } else {
        $nama = $this->Dashboard_model->getNamaToko($id);
        $nama = 'Toko ' . $nama;
        $range = '0';
        $data = array(
          'nama' => $nama,
          'range' => $range
        );
        echo json_encode($data);
      }
    } else {
      $nama = 'Semua Toko';
      if ($start != "0" && $end != "0") {
        $nama = 'Semua Toko';
        $range = date('j F Y', strtotime($start)) . ' s/d ' . date('j F Y', strtotime($end));
        $data = array(
          'nama' => $nama,
          'range' => $range
        );
        echo json_encode($data);
      } else {
        $nama = 'Semua Toko';
        $range = '0';
        $data = array(
          'nama' => $nama,
          'range' => $range
        );
        echo json_encode($data);
      }
    }
  }

  //---------------------------------------------------------------
  // Card

  public function index()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Dashboard : Cards View";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Dashboard_model->getListToko();
    $data['first_date_of_record'] = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
    $data['last_date_of_record'] = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('dashboard/index');
    $this->load->view('templates/footer');
  }

  public function getDashboardContent($toko_id)
  {
    if ($toko_id == 'all') {
      $day = $this->Dashboard_model->getReportByDayAll();
      $week = $this->Dashboard_model->getReportByWeekAll();
      $month = $this->Dashboard_model->getReportByMonthAll();
      $html = $this->load->view('dashboard/content', array('day' => $day, 'week' => $week, 'month' => $month), true);
      echo json_encode($html);
    } else {
      $day = $this->Dashboard_model->getReportByDay($toko_id);
      $week = $this->Dashboard_model->getReportByWeek($toko_id);
      $month = $this->Dashboard_model->getReportByMonth($toko_id);
      $html = $this->load->view('dashboard/content', array('day' => $day, 'week' => $week, 'month' => $month), true);
      echo json_encode($html);
    }
  }

  public function getCustomContent()
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $toko_id = $this->input->post('tk_id');
    $range = array(
      'start' => $start,
      'end' => $end
    );

    if ($toko_id == 'all') {
      $custom = $this->Dashboard_model->getReportByRangeAll($start, $end);
      $html = $this->load->view('dashboard/contentCustom', array('custom' => $custom, 'range' => $range), true);
      echo json_encode($html);
    } else {
      $custom = $this->Dashboard_model->getReportByRange($start, $end, $toko_id);
      $html = $this->load->view('dashboard/contentCustom', array('custom' => $custom, 'range' => $range), true);
      echo json_encode($html);
    }
  }

  //---------------------------------------------------------------
  // Chart

  public function chart()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Dashboard : Charts View";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Dashboard_model->getListToko();
    $data['first_date_of_record'] = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
    $data['last_date_of_record'] = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('dashboard/chart');
    $this->load->view('templates/footer');
  }

  public function getChartData()
  {
    $toko = $this->input->post('toko');
    $mode = $this->input->post('mode');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');

    $c1;
    $c2;
    $c3;
    $c4;
    $c5;
    $c6;

    if ($mode == "hari") {
      $c1 = $this->Dashboard_model->getProfitByMonth($toko, $tahun, $bulan);
      $c2 = $this->Dashboard_model->getOmsetByMonth($toko, $tahun, $bulan);
      $c3 = $this->Dashboard_model->getTransaksiByMonth($toko, $tahun, $bulan);
      $c4 = $this->Dashboard_model->getTerjualByMonth($toko, $tahun, $bulan);
      $c5 = $this->Dashboard_model->getPengunjungByMonth($toko, $tahun, $bulan);
      $c6 = $this->Dashboard_model->getOperasionalByMonth($toko, $tahun, $bulan);
    } else if ($mode == "bulan") {
      $c1 = $this->Dashboard_model->getProfitByYear($toko, $tahun);
      $c2 = $this->Dashboard_model->getOmsetByYear($toko, $tahun);
      $c3 = $this->Dashboard_model->getTransaksiByYear($toko, $tahun);
      $c4 = $this->Dashboard_model->getTerjualByYear($toko, $tahun);
      $c5 = $this->Dashboard_model->getPengunjungByYear($toko, $tahun);
      $c6 = $this->Dashboard_model->getOperasionalByYear($toko, $tahun);
    } else if ($mode == "tahun") {
      $c1 = $this->Dashboard_model->getProfitAnnually($toko);
      $c2 = $this->Dashboard_model->getOmsetAnnually($toko);
      $c3 = $this->Dashboard_model->getTransaksiAnnually($toko);
      $c4 = $this->Dashboard_model->getTerjualAnnually($toko);
      $c5 = $this->Dashboard_model->getPengunjungAnnually($toko);
      $c6 = $this->Dashboard_model->getOperasionalAnnually($toko);
    }

    $chartData = array(
      'c1' => $c1,
      'c2' => $c2,
      'c3' => $c3,
      'c4' => $c4,
      'c5' => $c5,
      'c6' => $c6
    );

    echo json_encode($chartData);
  }

  //---------------------------------------------------------------
  // Net Profit

  public function net()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Dashboard : Net Profit";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Dashboard_model->getListToko();
    $data['first_date_of_record'] = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
    $data['last_date_of_record'] = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('dashboard/index');
    $this->load->view('templates/footer');
  }

  public function getDashboardContentNet($toko_id)
  {
    if ($toko_id == 'all') {
      $day = $this->Dashboard_model->getNetByDayAll();
      $week = $this->Dashboard_model->getNetByWeekAll();
      $month = $this->Dashboard_model->getNetByMonthAll();
      $html = $this->load->view('dashboard/contentNet', array('day' => $day, 'week' => $week, 'month' => $month), true);
      echo json_encode($html);
    } else {
      $day = $this->Dashboard_model->getNetByDay($toko_id);
      $week = $this->Dashboard_model->getNetByWeek($toko_id);
      $month = $this->Dashboard_model->getNetByMonth($toko_id);
      $html = $this->load->view('dashboard/contentNet', array('day' => $day, 'week' => $week, 'month' => $month), true);
      echo json_encode($html);
    }
  }

  public function getCustomContentNet()
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $toko_id = $this->input->post('tk_id');
    $range = array(
      'start' => $start,
      'end' => $end
    );

    if ($toko_id == 'all') {
      $custom = $this->Dashboard_model->getNetByRangeAll($start, $end);
      $html = $this->load->view('dashboard/contentCustom', array('custom' => $custom, 'range' => $range), true);
      echo json_encode($html);
    } else {
      $custom = $this->Dashboard_model->getNetByRange($start, $end, $toko_id);
      $html = $this->load->view('dashboard/contentCustom', array('custom' => $custom, 'range' => $range), true);
      echo json_encode($html);
    }
  }

  //---------------------------------------------------------------
  // Ranking Produk

  public function rankingProduk()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $data['title'] = "Dashboard : Ranking Produk";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Dashboard_model->getListToko();
    $data['first_date_of_record'] = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
    $data['last_date_of_record'] = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('dashboard/ranking');
    $this->load->view('templates/footer');
  }

  public function getViewRankingAll()
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');

    $list_ranking_final = array();
    $list_produk = $this->Dashboard_model->getListProdukAll($start, $end);
    foreach ($list_produk as $x) {
      $search_sku = $x['sku'];
      $data_ranking_produk = $this->Dashboard_model->getDataRankingProdukAll($start, $end, $search_sku);
      array_push($list_ranking_final, $data_ranking_produk);
    }

    usort($list_ranking_final, function ($a, $b) {
      return - ($a['qty'] <=> $b['qty']);
    });
    $html = $this->load->view('dashboard/rankingTable', array('data' => $list_ranking_final), true);

    $callback = array(
      'nama_toko' => 'Semua Toko',
      'range' => date('j F Y', strtotime($start)) . ' s/d ' . date('j F Y', strtotime($end)),
      'html' => $html
    );
    echo json_encode($callback);
  }

  public function getViewRankingByToko($toko_id)
  {
    $start = $this->input->post('start');
    $end = $this->input->post('end');

    $list_ranking_final = array();
    $list_produk = $this->Dashboard_model->getListProdukByToko($start, $end, $toko_id);
    foreach ($list_produk as $x) {
      $search_sku = $x['sku'];
      $data_ranking_produk = $this->Dashboard_model->getDataRankingProdukByToko($start, $end, $search_sku, $toko_id);
      array_push($list_ranking_final, $data_ranking_produk);
    }

    usort($list_ranking_final, function ($a, $b) {
      return - ($a['qty'] <=> $b['qty']);
    });
    $html = $this->load->view('dashboard/rankingTable', array('data' => $list_ranking_final), true);

    $callback = array(
      'nama_toko' => $this->Dashboard_model->getNamaToko($toko_id),
      'range' => date('j F Y', strtotime($start)) . ' s/d ' . date('j F Y', strtotime($end)),
      'html' => $html
    );

    echo json_encode($callback);
  }

  //---------------------------------------------------------------
  // Ranking Karyawan
  public function rankingKaryawan()
  {
    $this->load->library('cart');
    $this->cart->destroy();
    $this->load->model('Absen_model');
    $data['title'] = "Dashboard : Ranking Karyawan";
    $data['not_read'] = $this->Notifikasi_model->getNotRead();
    $data['toko'] = $this->Dashboard_model->getListToko();
    $data['first_date_of_record'] = $this->Absen_model->getFirstDateOfRecord();
    $data['last_date_of_record'] = $this->Absen_model->getLastDateOfRecord();
    $data['first_year_of_record'] = (int) date('Y', $data['first_date_of_record']);
    $data['last_year_of_record'] = (int) date('Y', $data['last_date_of_record']);
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar', $data);
    $this->load->view('dashboard/rankingKaryawan', $data);
    $this->load->view('templates/footer');
  }

  public function getViewRankingKaryawan()
  {
    $mode = $this->input->post('mode');
    $bulan = $this->input->post('bulan');
    $tahun = $this->input->post('tahun');

    $start = sprintf("%04d-%02d-%02d", $tahun, $bulan, 1);
    $end_day = (int) date('t', strtotime($start));
    $end = sprintf("%04d-%02d-%02d", $tahun, $bulan, $end_day);


    $rank_penjualan = array();

    if ($mode == 'jual') {
      $uname = $this->Dashboard_model->getListUnameFromPenjualan($start, $end);
      foreach ($uname as $x) {
        $data = array(
          'uname' => $x['uname'],
          'total' => $this->Dashboard_model->getPenjualanByUname($x['uname'], $start, $end)
        );
        array_push($rank_penjualan, $data);
      }

      usort($rank_penjualan, function ($b, $a) {
        return $a['total'] <=> $b['total'];
      });
      $html = $this->load->view('dashboard/rankingKaryawanPenjualanTable', array('data' => $rank_penjualan), true);
      $callback = array(
        'html' => $html,
        'range' => '<strong>Range</strong><br>' . date('1 F Y', strtotime($start)) . ' s/d ' . date('t F Y', strtotime($end)),
      );
      echo json_encode($callback);
    } else if ($mode == 'absen') {
      $start = strtotime($start . ' 00:00:00');
      $end = strtotime($end . ' 23:59:59');
      $uname = $this->Dashboard_model->getListUnameFromAbsen($start, $end);
      foreach ($uname as $x) {
        $data = array(
          'uname' => $x['uname'],
          'total' => $this->Dashboard_model->getAbsensiByUname($x['uname'], $start, $end)
        );
        array_push($rank_penjualan, $data);
      }

      usort($rank_penjualan, function ($b, $a) {
        return $a['total'] <=> $b['total'];
      });
      $html = $this->load->view('dashboard/rankingKaryawanAbsensiTable', array('data' => $rank_penjualan), true);
      $callback = array(
        'html' => $html,
        'range' => '<strong>Range</strong><br>' . date('1 F Y', strtotime($start)) . ' s/d ' . date('t F Y', strtotime($end)),
      );

      echo json_encode($callback);
    }
  }

  public function getFirstAndLastRecordKaryawan()
  {
    $mode = $this->input->post('mode');

    if ($mode == 'jual') {
      $start = $this->Dashboard_model->getFirstDateOfRecord()[0]['tanggal'];
      $end = $this->Dashboard_model->getLastDateOfRecord()[0]['tanggal'];
      $start = date('j F Y', strtotime($start));
      $end = date('j F Y', strtotime($end));
      $data = array(
        'range' => 'Data absensi yang ter-rekam berada pada rentang waktu <br><strong>' . $start . ' s/d ' . $end . '</strong>'
      );
      echo json_encode($data);
    } else if ($mode == 'absen') {
      $this->load->model('Absen_model');
      $start = $this->Absen_model->getFirstDateOfRecord();
      $end = $this->Absen_model->getLastDateOfRecord();
      $start = date('j F Y', $start);
      $end = date('j F Y', $end);

      $data = array(
        'range' => 'Data absensi yang ter-rekam berada pada rentang waktu <br><strong>' . $start . ' s/d ' . $end . '</strong>'
      );
      echo json_encode($data);
    }
  }
}
