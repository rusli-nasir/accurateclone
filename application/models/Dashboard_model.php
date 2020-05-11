<?php
class Dashboard_model extends CI_Model
{
  public function getListToko()
  {
    $sql = "SELECT id, nama FROM toko WHERE NOT id = 1";
    return $this->db->query($sql)->result_array();
  }

  public function getNamaToko($id)
  {
    $sql = "SELECT nama FROM toko where id = $id";
    return $this->db->query($sql)->row_array()['nama'];
  }
  // ---------------------------------------------------------------------
  // Card

  public function getReportByDayAll()
  {
    $now = date('Y-m-d');
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$now'
        )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal = '$now'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE tanggal = '$now'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE tanggal = '$now'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];


    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE is_beli = 1 AND tanggal = '$now'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE is_beli = 0 AND tanggal = '$now'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByWeekAll()
  {
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $week_end = date('Y-m-d', strtotime('+' . (7 - $day) . ' days'));
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE is_beli = 1 AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE is_beli = 0 AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByMonthAll()
  {
    $day = date('j');
    $dateNow = date('Y-m-d');
    $m_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $m_end = date('Y-m-t', strtotime($dateNow));
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE is_beli = 1 AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE is_beli = 0 AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByDay($toko_id)
  {
    $now = date('Y-m-d');
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$now' AND toko_id = $toko_id
        )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal = '$now' AND toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE tanggal = '$now' AND toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE tanggal = '$now' AND toko_id = $toko_id
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE is_beli = 1 AND tanggal = '$now' AND toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE is_beli = 0 AND tanggal = '$now' AND toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByWeek($toko_id)
  {
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $week_end = date('Y-m-d', strtotime('+' . (7 - $day) . ' days'));
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 1 AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 0 AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByMonth($toko_id)
  {
    $day = date('j');
    $dateNow = date('Y-m-d');
    $m_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $m_end = date('Y-m-t', strtotime($dateNow));
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 1 AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 0 AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByRange($start, $end, $toko_id)
  {
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 1 AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE toko_id = $toko_id AND is_beli = 0 AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  public function getReportByRangeAll($start, $end)
  {
    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT COUNT(*) as transaksi
      FROM invoice
      WHERE tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $transaksi = $query->result_array();

    $sql = "
      SELECT SUM(jumlah_pembelian) as terjual
      FROM invoice_items
      WHERE invoice_id IN (
        SELECT id
        FROM invoice
        WHERE tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $qtys = $query->result_array();
    $terjual = 0;
    if (!empty($qtys[0]['terjual']))
      $terjual = $qtys[0]['terjual'];

    $sql = "
      SELECT COUNT(*) as beli
      FROM pengunjung
      WHERE is_beli = 1 AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $beli = $query->result_array();
    $disp_beli = 0;

    $sql = "
      SELECT COUNT(*) as tdk_beli
      FROM pengunjung
      WHERE is_beli = 0 AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $tdk_beli = $query->result_array();
    $disp_tdk_beli = 0;


    if (!empty($beli[0]['beli']))
      $disp_beli = number_format(($beli[0]['beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");
    if (!empty($tdk_beli[0]['tdk_beli']))
      $disp_tdk_beli = number_format(($tdk_beli[0]['tdk_beli'] / ($beli[0]['beli'] + $tdk_beli[0]['tdk_beli'])) * 100, 2, ",", ".");

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'transaksi' => $transaksi[0]['transaksi'],
      'terjual' => $terjual,
      'beli' => $beli[0]['beli'] . '&nbsp;&nbsp;&nbsp;( ' .  $disp_beli . '% )',
      'tdk_beli' => $tdk_beli[0]['tdk_beli'] . '&nbsp;&nbsp;&nbsp;( ' . $disp_tdk_beli . '% )'
    );

    return $data;
  }

  // ---------------------------------------------------------------------
  // Chart

  public function getFirstDateOfRecord()
  {
    $sql = "
      SELECT tanggal
      FROM invoice  
      ORDER BY tanggal
      LIMIT 1
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getLastDateOfRecord()
  {
    $sql = "
      SELECT tanggal
      FROM invoice  
      ORDER BY tanggal DESC
      LIMIT 1
    ";
    return $this->db->query($sql)->result_array();
  }

  //------------- By Month ----------------------------------------------

  public function getProfitByMonth($toko_id, $year, $month)
  {
    $profit = 0;
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_profit_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_profit = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE tanggal = '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE toko_id = '$toko_id' AND tanggal = '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_profit = $query->result_array();

      foreach ($data_profit as $x) {
        $profit += ($x['harga'] - $x['modal'] - $x['diskon']) * $x['qty'];
      }
      $insert_profit = array(
        'tick' => $i,
        'profit' => $profit
      );
      array_push($insert_profit_final, $insert_profit);
      $profit = 0;
    }

    return $insert_profit_final;
  }

  public function getOmsetByMonth($toko_id, $year, $month)
  {
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_omset_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_omset = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE tanggal = '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal = '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_omset = $query->result_array();

      $insert_omset = array(
        'tick' => $i,
        'omset' => $data_omset[0]['totalday']
      );
      array_push($insert_omset_final, $insert_omset);
    }

    return $insert_omset_final;
  }

  public function getTransaksiByMonth($toko_id, $year, $month)
  {
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_transaksi_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_transaksi = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE tanggal = '$check_date'
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal = '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_transaksi = $query->result_array();

      $insert_transaksi = array(
        'tick' => $i,
        'transaksi' => $data_transaksi[0]['transaksi']
      );
      array_push($insert_transaksi_final, $insert_transaksi);
    }

    return $insert_transaksi_final;
  }

  public function getTerjualByMonth($toko_id, $year, $month)
  {
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_terjual_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_terjual = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = '$toko_id' AND tanggal = '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_terjual = $query->result_array();

      $insert_terjual = array(
        'tick' => $i,
        'terjual' => $data_terjual[0]['terjual']
      );
      array_push($insert_terjual_final, $insert_terjual);
    }

    return $insert_terjual_final;
  }

  public function getPengunjungByMonth($toko_id, $year, $month)
  {
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_pengunjung_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_pengunjung = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE tanggal = '$check_date' AND is_beli=1
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal = '$check_date' AND is_beli=1
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_beli = $query->result_array();

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE tanggal = '$check_date' AND is_beli=0
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal = '$check_date' AND is_beli=0
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_tdk_beli = $query->result_array();

      $insert_pengunjung = array(
        'tick' => $i,
        'beli' => $data_pengunjung_beli[0]['beli'],
        'tdk_beli' => $data_pengunjung_tdk_beli[0]['tdk_beli']
      );
      array_push($insert_pengunjung_final, $insert_pengunjung);
    }

    return $insert_pengunjung_final;
  }

  public function getOperasionalByMonth($toko_id, $year, $month)
  {
    $ref_date = $year . '-' . sprintf("%02d", $month) . '-01';
    $day_end = (int) date('t', strtotime($ref_date));
    $insert_operasional_final = array();
    $sql = "";
    for ($i = 1; $i <= $day_end; $i++) {
      $insert_operasional = array();
      $check_date = $year . '-' . sprintf("%02d", $month) . '-' . sprintf("%02d", $i);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE created_at = '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE toko_id = '$toko_id' AND created_at = '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_operasional = $query->result_array();

      $insert_operasional = array(
        'tick' => $i,
        'operasional' => $data_operasional[0]['totalday']
      );
      array_push($insert_operasional_final, $insert_operasional);
    }

    return $insert_operasional_final;
  }

  //------------- By Year ----------------------------------------------

  public function getProfitByYear($toko_id, $year)
  {
    $profit = 0;
    $insert_profit_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_profit = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE tanggal LIKE '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_profit = $query->result_array();

      foreach ($data_profit as $x) {
        $profit += ($x['harga'] - $x['modal'] - $x['diskon']) * $x['qty'];
      }
      $insert_profit = array(
        'tick' => $i,
        'profit' => $profit
      );
      array_push($insert_profit_final, $insert_profit);
      $profit = 0;
    }

    return $insert_profit_final;
  }

  public function getOmsetByYear($toko_id, $year)
  {
    $insert_omset_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_omset = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE tanggal LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_omset = $query->result_array();

      $insert_omset = array(
        'tick' => $i,
        'omset' => $data_omset[0]['totalday']
      );
      array_push($insert_omset_final, $insert_omset);
    }

    return $insert_omset_final;
  }

  public function getTransaksiByYear($toko_id, $year)
  {
    $insert_transaksi_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_transaksi = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE tanggal LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_transaksi = $query->result_array();

      $insert_transaksi = array(
        'tick' => $i,
        'transaksi' => $data_transaksi[0]['transaksi']
      );
      array_push($insert_transaksi_final, $insert_transaksi);
    }

    return $insert_transaksi_final;
  }

  public function getTerjualByYear($toko_id, $year)
  {
    $insert_terjual_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_terjual = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal LIKE '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_terjual = $query->result_array();

      $insert_terjual = array(
        'tick' => $i,
        'terjual' => $data_terjual[0]['terjual']
      );
      array_push($insert_terjual_final, $insert_terjual);
    }

    return $insert_terjual_final;
  }

  public function getPengunjungByYear($toko_id, $year)
  {
    $insert_pengunjung_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_pengunjung = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE tanggal LIKE '$check_date' AND is_beli=1
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date' AND is_beli=1
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_beli = $query->result_array();

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE tanggal LIKE '$check_date' AND is_beli=0
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date' AND is_beli=0
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_tdk_beli = $query->result_array();

      $insert_pengunjung = array(
        'tick' => $i,
        'beli' => $data_pengunjung_beli[0]['beli'],
        'tdk_beli' => $data_pengunjung_tdk_beli[0]['tdk_beli']
      );
      array_push($insert_pengunjung_final, $insert_pengunjung);
    }

    return $insert_pengunjung_final;
  }

  public function getOperasionalByYear($toko_id, $year)
  {
    $insert_operasional_final = array();
    $sql = "";
    for ($i = 1; $i <= 12; $i++) {
      $insert_operasional = array();
      $check_date = $year . '-' . sprintf("%02d", $i) . '-%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE created_at LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE toko_id = '$toko_id' AND created_at LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_operasional = $query->result_array();

      $insert_operasional = array(
        'tick' => $i,
        'operasional' => $data_operasional[0]['totalday']
      );
      array_push($insert_operasional_final, $insert_operasional);
    }

    return $insert_operasional_final;
  }

  //--------------- Annually -----------------------------------------

  public function getProfitAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $profit = 0;
    $insert_profit_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_profit = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE tanggal LIKE '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT ii.harga, p.harga_modal as modal, ii.jumlah_diskon as diskon, ii.jumlah_pembelian as qty, i.tanggal
        FROM invoice_items ii
        JOIN produk p
          ON p.SKU = ii.produk_SKU
        JOIN invoice i
          ON i.id = ii.invoice_id
        WHERE invoice_id IN (
            SELECT id
            FROM invoice
            WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_profit = $query->result_array();

      foreach ($data_profit as $x) {
        $profit += ($x['harga'] - $x['modal'] - $x['diskon']) * $x['qty'];
      }
      $insert_profit = array(
        'tick' => $i,
        'profit' => $profit
      );
      array_push($insert_profit_final, $insert_profit);
      $profit = 0;
    }

    return $insert_profit_final;
  }

  public function getOmsetAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $insert_omset_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_omset = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE tanggal LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(total) AS totalday
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_omset = $query->result_array();

      $insert_omset = array(
        'tick' => $i,
        'omset' => $data_omset[0]['totalday']
      );
      array_push($insert_omset_final, $insert_omset);
    }

    return $insert_omset_final;
  }

  public function getTransaksiAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $insert_transaksi_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_transaksi = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE tanggal LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS transaksi
        FROM invoice
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_transaksi = $query->result_array();

      $insert_transaksi = array(
        'tick' => $i,
        'transaksi' => $data_transaksi[0]['transaksi']
      );
      array_push($insert_transaksi_final, $insert_transaksi);
    }

    return $insert_transaksi_final;
  }

  public function getTerjualAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $insert_terjual_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_terjual = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal LIKE '$check_date'
        )
      ";
      } else {
        $sql = "
        SELECT SUM(jumlah_pembelian) as terjual
        FROM invoice_items
        WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date'
        )
      ";
      }
      $query = $this->db->query($sql);
      $data_terjual = $query->result_array();

      $insert_terjual = array(
        'tick' => $i,
        'terjual' => $data_terjual[0]['terjual']
      );
      array_push($insert_terjual_final, $insert_terjual);
    }

    return $insert_terjual_final;
  }

  public function getPengunjungAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $insert_pengunjung_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_pengunjung = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE tanggal LIKE '$check_date' AND is_beli=1
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date' AND is_beli=1
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_beli = $query->result_array();

      if ($toko_id == "all") {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE tanggal LIKE '$check_date' AND is_beli=0
      ";
      } else {
        $sql = "
        SELECT COUNT(id) AS tdk_beli
        FROM `pengunjung`
        WHERE toko_id = '$toko_id' AND tanggal LIKE '$check_date' AND is_beli=0
      ";
      }
      $query = $this->db->query($sql);
      $data_pengunjung_tdk_beli = $query->result_array();

      $insert_pengunjung = array(
        'tick' => $i,
        'beli' => $data_pengunjung_beli[0]['beli'],
        'tdk_beli' => $data_pengunjung_tdk_beli[0]['tdk_beli']
      );
      array_push($insert_pengunjung_final, $insert_pengunjung);
    }

    return $insert_pengunjung_final;
  }

  public function getOperasionalAnnually($toko_id)
  {
    $ref_start = $this->getFirstDateOfRecord()[0]['tanggal'];
    $ref_end = $this->getLastDateOfRecord()[0]['tanggal'];

    $start = (int) date('Y', strtotime($ref_start));
    $end = (int) date('Y', strtotime($ref_end));

    $insert_operasional_final = array();
    $sql = "";
    for ($i = $start; $i <= $end; $i++) {
      $insert_operasional = array();
      $check_date = $i . '%';
      $check_date = strval($check_date);

      if ($toko_id == "all") {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE created_at LIKE '$check_date'
      ";
      } else {
        $sql = "
        SELECT SUM(biaya) AS totalday
        FROM operasional
        WHERE toko_id = '$toko_id' AND created_at LIKE '$check_date'
      ";
      }
      $query = $this->db->query($sql);
      $data_operasional = $query->result_array();

      $insert_operasional = array(
        'tick' => $i,
        'operasional' => $data_operasional[0]['totalday']
      );
      array_push($insert_operasional_final, $insert_operasional);
    }

    return $insert_operasional_final;
  }

  // -------------------------------------------------------------------
  // NET

  public function getNetByDayAll()
  {
    $now = date('Y-m-d');

    $time_start = date('Y-m-d ') . '00:00:00';
    $time_start = strtotime($time_start);
    $time_end = date('Y-m-d ') . '23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$now'
        )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal = '$now'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalday
      FROM operasional
      WHERE created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalday'];
    $net_profit = $profit - $operasional;


    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByWeekAll()
  {
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $week_end = date('Y-m-d', strtotime('+' . (7 - $day) . ' days'));
    $time_start = $week_start . ' 00:00:00';
    $time_start = strtotime($time_start);
    $time_end = $week_end . ' 23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalweek
      FROM operasional
      WHERE created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalweek'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByMonthAll()
  {
    $day = date('j');
    $dateNow = date('Y-m-d');
    $m_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $m_end = date('Y-m-t', strtotime($dateNow));
    $time_start = $m_start . ' 00:00:00';
    $time_start = strtotime($time_start);
    $time_end = $m_end . ' 23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalmonth
      FROM operasional
      WHERE created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalmonth'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByDay($toko_id)
  {
    $now = date('Y-m-d');
    $time_start = date('Y-m-d ') . '00:00:00';
    $time_start = strtotime($time_start);
    $time_end = date('Y-m-d ') . '23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal = '$now' AND toko_id = $toko_id
        )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal = '$now' AND toko_id = $toko_id
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalday
      FROM operasional
      WHERE toko_id = $toko_id AND created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalday'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByWeek($toko_id)
  {
    $day = date('w');
    $week_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $week_end = date('Y-m-d', strtotime('+' . (7 - $day) . ' days'));
    $time_start = $week_start . ' 00:00:00';
    $time_start = strtotime($time_start);
    $time_end = $week_end . ' 23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$week_start' AND '$week_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalweek
      FROM operasional
      WHERE toko_id = $toko_id AND created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalweek'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByMonth($toko_id)
  {
    $day = date('j');
    $dateNow = date('Y-m-d');
    $m_start = date('Y-m-d', strtotime('-' . ($day - 1) . ' days'));
    $m_end = date('Y-m-t', strtotime($dateNow));
    $time_start = $m_start . ' 00:00:00';
    $time_start = strtotime($time_start);
    $time_end = $m_end . ' 23:59:59';
    $time_end = strtotime($time_end);

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$m_start' AND '$m_end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalmonth
      FROM operasional
      WHERE toko_id = $toko_id AND created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalmonth'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByRange($start, $end, $toko_id)
  {
    $time_start = $start . ' 00:00:00';
    $time_end = $end . ' 23:59:59';

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE toko_id = $toko_id AND tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalrange
      FROM operasional
      WHERE toko_id = $toko_id AND created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalrange'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  public function getNetByRangeAll($start, $end)
  {
    $time_start = $start . ' 00:00:00';
    $time_end = $end . ' 23:59:59';

    $sql = "
      SELECT harga as jual, p.harga_modal as modal, ii.jumlah_pembelian as qty
      FROM invoice_items ii
      JOIN produk p
        ON p.SKU = ii.produk_SKU
      WHERE invoice_id IN (
          SELECT id
          FROM invoice
          WHERE tanggal BETWEEN '$start' AND '$end'
      )
    ";
    $query = $this->db->query($sql);
    $data_profit = $query->result_array();
    $profit = 0;
    foreach ($data_profit as $x) {
      $profit += ($x['jual'] - $x['modal']) * $x['qty'];
    }

    $sql = "
      SELECT SUM(total) as omset
      FROM invoice
      WHERE tanggal BETWEEN '$start' AND '$end'
    ";
    $query = $this->db->query($sql);
    $omset = $query->result_array();

    $sql = "
      SELECT SUM(biaya) AS totalrange
      FROM operasional
      WHERE created_at BETWEEN $time_start AND $time_end
    ";
    $query = $this->db->query($sql);
    $operasional = (int) $query->result_array()[0]['totalrange'];
    $net_profit = $profit - $operasional;

    $data = array(
      'profit' => $profit,
      'omset' => $omset[0]['omset'],
      'net' => $net_profit,
      'operasional' => $operasional
    );

    return $data;
  }

  // ---------------------------------------------------------------------------
  // Ranking Produk

  public function getListProdukAll($start, $end)
  {
    $sql = "
      SELECT DISTINCT ii.produk_SKU AS sku
      FROM invoice i
      JOIN invoice_items ii
        ON i.id = ii.invoice_id
      WHERE i.tanggal BETWEEN '$start' AND '$end'
    ";
    $sku = $this->db->query($sql)->result_array();

    return $sku;
  }

  public function getDataRankingProdukAll($start, $end, $sku)
  {
    $sql = "
      SELECT ii.produk_SKU AS sku, p.nama, SUM(ii.jumlah_pembelian) AS qty
      FROM invoice i
      JOIN invoice_items ii
        ON i.id = ii.invoice_id
      JOIN produk p
        ON ii.produk_SKU = p.SKU
      WHERE ii.produk_SKU = $sku AND i.tanggal BETWEEN '$start' AND '$end'
    ";
    $data = $this->db->query($sql)->row_array();

    return $data;
  }

  public function getListProdukByToko($start, $end, $toko_id)
  {
    $sql = "
      SELECT DISTINCT ii.produk_SKU AS sku
      FROM invoice i
      JOIN invoice_items ii
        ON i.id = ii.invoice_id
      WHERE i.toko_id = $toko_id AND i.tanggal BETWEEN '$start' AND '$end'
    ";
    $sku = $this->db->query($sql)->result_array();

    return $sku;
  }

  public function getDataRankingProdukByToko($start, $end, $sku, $toko_id)
  {
    $sql = "
      SELECT ii.produk_SKU AS sku, p.nama, SUM(ii.jumlah_pembelian) AS qty
      FROM invoice i
      JOIN invoice_items ii
        ON i.id = ii.invoice_id
      JOIN produk p
        ON ii.produk_SKU = p.SKU
      WHERE i.toko_id = $toko_id AND ii.produk_SKU = $sku AND i.tanggal BETWEEN '$start' AND '$end'
    ";
    $data = $this->db->query($sql)->row_array();

    return $data;
  }

  // ---------------------------------------------------------------------------
  // Ranking Produk

  public function getListUnameFromPenjualan($start, $end)
  {
    $sql = "
      SELECT DISTINCT karyawan_username AS uname
      FROM invoice
      WHERE tanggal BETWEEN '$start' AND '$end'
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getListUnameFromAbsen($start, $end)
  {
    $sql = "
    SELECT DISTINCT krywn_username AS uname
    FROM absen
    WHERE time_masuk BETWEEN $start AND $end
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getPenjualanByUname($uname, $start, $end)
  {
    $sql = "
      SELECT COUNT(id) AS total
      FROM invoice
      WHERE karyawan_username = '$uname' AND tanggal BETWEEN '$start' AND '$end'
    ";
    return $this->db->query($sql)->row_array()['total'];
  }

  public function getAllAbsenByUname($uname, $start, $end)
  {
    $sql = "
      SELECT time_masuk, time_pulang
      FROM absen
      WHERE krywn_username = '$uname' AND time_masuk BETWEEN $start AND $end
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getAbsensiByUname($uname, $start, $end)
  {
    $sql = "
      SELECT time_masuk, time_pulang
      FROM absen
      WHERE krywn_username = '$uname' AND time_masuk BETWEEN $start AND $end
    ";
    $time = $this->db->query($sql)->result_array();

    $menit = 0;
    foreach ($time as $x) {
      $menit += round(abs($x['time_pulang'] - $x['time_masuk']) / 60, 2);
    }

    return $menit;
  }
}
