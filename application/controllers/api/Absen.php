<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Api_absen_model');
  }

  private function getPredikat($start, $mid, $end, $now_mnt, $mode)
  {
    if ($mode == 'txt') {
      if ($now_mnt < $start) {
        return '-';
      } else if ($now_mnt >= $start && $now_mnt < $mid) {
        return 'Dini';
      } else if ($now_mnt >= $mid && $now_mnt < $end) {
        return 'Normal';
      } else if ($now_mnt >= $end) {
        return 'Telat';
      }
    } else if ($mode == 'num') {
      if ($now_mnt >= $start && $now_mnt < $mid) {
        return 1;
      } else if ($now_mnt >= $mid && $now_mnt < $end) {
        return 2;
      } else if ($now_mnt < $start || $now_mnt >= $end) {
        return 3;
      }
    } else {
      if ($now_mnt >= $start && $now_mnt < $mid) {
        return 1;
      } else if ($now_mnt >= $mid && $now_mnt < $end) {
        return 0;
      } else if ($now_mnt >= $end) {
        return -1;
      }
    }
  }

  public function cekAbsenMasuk()
  {
    $username = $this->input->post('username');
    $user_lat = $this->input->post('user_lat');
    $user_lon = $this->input->post('user_lon');

    if ($username == "KOSONG") {
      $callback = array(
        'status' => '5',
        'message' => ' '
      );
      echo json_encode($callback);
      return false;
    }

    $user_toko_id = $this->Api_absen_model->getTokoIdByUser($username);
    $toko_coord = $this->Api_absen_model->getTokoCoordinate($user_toko_id);
    $user_shift = $this->Api_absen_model->getUserShift($username);

    $distance = $this->calculateDistanceMeter($user_lat, $user_lon, $toko_coord['latitude'], $toko_coord['longitude']);
    $distance = round($distance) . ' Meter Dari Toko';

    $isHasAbsen = $this->Api_absen_model->isHasAbsenMasuk($username);
    $isHasAbsen = (int) count($isHasAbsen);

    $jam = (int) date('G');
    $jam = $jam *  60;
    $menit = (int) date('i');
    $now_minute = $jam + $menit;

    if ($user_shift['shift'] == 'error') {
      $callback = array(
        'status' => 3,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'sudah_absen' => 'Shift Belum Ditentukan',
        'message' => 'Shift karyawan ini belum ditentukan melalui web rocketjaket!',
        'shift' => $user_shift['shift'],
        'absen_masuk_buka' => '-',
        'absen_masuk_kerja' => '-',
        'absen_masuk_telat' => '-',
        'absen_pulang_kerja' => '-',
        'num_predikat_absen' => 3,
        'predikat_absen' => '-'
      );
      echo json_encode($callback);
    } else if ($now_minute < $user_shift['range_start']) {
      $callback = array(
        'status' => 3,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'sudah_absen' => 'Absen Belum Dibuka',
        'message' => 'Absen belum dibuka!',
        'shift' => $user_shift['shift'],
        'absen_masuk_buka' => $user_shift['absen_masuk_buka'],
        'absen_masuk_kerja' => $user_shift['absen_masuk_kerja'],
        'absen_masuk_telat' => $user_shift['absen_masuk_telat'],
        'absen_pulang_kerja' => $user_shift['absen_pulang_kerja'],
        'num_predikat_absen' => 3,
        'predikat_absen' => '-'
      );
      echo json_encode($callback);
    } else {
      if ($distance <= 100 && $isHasAbsen == 0) {
        $callback = array(
          'status' => 0,
          'jarak' => $distance,
          'toko_lat' => $toko_coord['latitude'],
          'toko_lon' => $toko_coord['longitude'],
          'sudah_absen' => 'Belum Absen Masuk Kerja',
          'message' => 'Silahkan absen',
          'shift' => $user_shift['shift'],
          'absen_masuk_buka' => $user_shift['absen_masuk_buka'],
          'absen_masuk_kerja' => $user_shift['absen_masuk_kerja'],
          'absen_masuk_telat' => $user_shift['absen_masuk_telat'],
          'absen_pulang_kerja' => $user_shift['absen_pulang_kerja'],
          'num_predikat_absen' => $this->getPredikat($user_shift['range_start'], $user_shift['range_mid'], $user_shift['range_end'], $now_minute, 'num'),
          'predikat_absen' => $this->getPredikat($user_shift['range_start'], $user_shift['range_mid'], $user_shift['range_end'], $now_minute, 'txt')
        );
        echo json_encode($callback);
      } else if ($distance <= 100 && $isHasAbsen > 0) {
        $callback = array(
          'status' => 1,
          'jarak' => $distance,
          'toko_lat' => $toko_coord['latitude'],
          'toko_lon' => $toko_coord['longitude'],
          'sudah_absen' => 'Sudah Absen Masuk Kerja',
          'message' => 'Anda sudah absen',
          'shift' => $user_shift['shift'],
          'absen_masuk_buka' => $user_shift['absen_masuk_buka'],
          'absen_masuk_kerja' => $user_shift['absen_masuk_kerja'],
          'absen_masuk_telat' => $user_shift['absen_masuk_telat'],
          'absen_pulang_kerja' => $user_shift['absen_pulang_kerja'],
          'num_predikat_absen' => 3,
          'predikat_absen' => '-'
        );
        echo json_encode($callback);
      } else if ($distance > 100 && $isHasAbsen == 0) {
        $callback = array(
          'status' => 2,
          'jarak' => $distance,
          'toko_lat' => $toko_coord['latitude'],
          'toko_lon' => $toko_coord['longitude'],
          'sudah_absen' => 'Belum Absen Masuk Kerja',
          'message' => 'Tidak bisa absen karena jarak lokasi anda dengan toko lebih dari 100 meter!',
          'shift' => $user_shift['shift'],
          'absen_masuk_buka' => $user_shift['absen_masuk_buka'],
          'absen_masuk_kerja' => $user_shift['absen_masuk_kerja'],
          'absen_masuk_telat' => $user_shift['absen_masuk_telat'],
          'absen_pulang_kerja' => $user_shift['absen_pulang_kerja'],
          'num_predikat_absen' => 3,
          'predikat_absen' => 'Tidak Dalam Area Toko'
        );
        echo json_encode($callback);
      } else if ($distance > 100 && $isHasAbsen > 0) {
        $callback = array(
          'status' => 3,
          'jarak' => $distance,
          'toko_lat' => $toko_coord['latitude'],
          'toko_lon' => $toko_coord['longitude'],
          'sudah_absen' => 'Sudah Absen Masuk Kerja',
          'message' => 'Anda sudah absen',
          'shift' => $user_shift['shift'],
          'absen_masuk_buka' => $user_shift['absen_masuk_buka'],
          'absen_masuk_kerja' => $user_shift['absen_masuk_kerja'],
          'absen_masuk_telat' => $user_shift['absen_masuk_telat'],
          'absen_pulang_kerja' => $user_shift['absen_pulang_kerja'],
          'num_predikat_absen' => 3,
          'predikat_absen' => '-'
        );
        echo json_encode($callback);
      }
    }
  }

  public function cekAbsenPulang()
  {
    $username = $this->input->post('username');
    $user_lat = $this->input->post('user_lat');
    $user_lon = $this->input->post('user_lon');

    $isHasAbsenMasuk = $this->Api_absen_model->isHasAbsenMasuk($username);
    $isHasAbsenMasuk = (int) count($isHasAbsenMasuk);
    $isHasAbsenPulang = $this->Api_absen_model->isHasAbsenPulang($username);
    if ($isHasAbsenMasuk == 0) {
      $callback = array(
        'status' => '5',
        'message' => 'Anda belum melakukan absen masuk!',
        'status_txt' => 'Belum Absen Masuk'
      );
      echo json_encode($callback);
      return false;
    }

    if ($isHasAbsenPulang) {
      $callback = array(
        'status' => '5',
        'message' => 'Anda sudah absen pulang!',
        'status_txt' => 'Sudah Absen Pulang'
      );
      echo json_encode($callback);
      return false;
    }

    $user_toko_id = $this->Api_absen_model->getTokoIdByUser($username);
    $toko_coord = $this->Api_absen_model->getTokoCoordinate($user_toko_id);
    $user_shift = $this->Api_absen_model->getUserShift($username);

    $distance = $this->calculateDistanceMeter($user_lat, $user_lon, $toko_coord['latitude'], $toko_coord['longitude']);
    $distance = round($distance) . ' Meter Dari Toko';

    $jam = (int) date('G');
    $jam = $jam *  60;
    $menit = (int) date('i');
    $now_minute = $jam + $menit;

    // echo json_encode($toko_coord);
    if ($distance <= 100 && $now_minute >= $user_shift['mnt_pulang']) {
      $callback = array(
        'status' => 0,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'status_txt' => 'Silahkan Absen Pulang',
        'message' => 'Silahkan absen pulang',
        'shift' => $user_shift['shift'],
        'absen_pulang_kerja' => $user_shift['absen_pulang_kerja']
      );
      echo json_encode($callback);
    } else if ($distance > 100 && $now_minute >= $user_shift['mnt_pulang']) {
      $callback = array(
        'status' => 1,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'status_txt' => 'Tidak Berada di Area Toko',
        'message' => 'Tidak Berada di Area Toko',
        'shift' => $user_shift['shift'],
        'absen_pulang_kerja' => $user_shift['absen_pulang_kerja']
      );
      echo json_encode($callback);
    } else if ($distance < 100 && $now_minute < $user_shift['mnt_pulang']) {
      $callback = array(
        'status' => 2,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'status_txt' => 'Jam Kerja Belum Selesai',
        'message' => 'Jam Kerja Belum Selesai',
        'shift' => $user_shift['shift'],
        'absen_pulang_kerja' => $user_shift['absen_pulang_kerja']
      );
      echo json_encode($callback);
    } else if ($distance > 100 && $now_minute < $user_shift['mnt_pulang']) {
      $callback = array(
        'status' => 3,
        'jarak' => $distance,
        'toko_lat' => $toko_coord['latitude'],
        'toko_lon' => $toko_coord['longitude'],
        'status_txt' => 'Tidak di Area Toko dan Jam Kerja Belum Selesai',
        'message' => 'Tidak di Area Toko dan Jam Kerja Belum Selesai',
        'shift' => $user_shift['shift'],
        'absen_pulang_kerja' => $user_shift['absen_pulang_kerja']
      );
      echo json_encode($callback);
    }
  }

  private function calculateDistanceMeter($lat_user, $lon_user, $lat_toko, $lon_toko)
  {
    if (($lat_user == $lat_toko) && ($lon_user == $lon_toko)) {
      return 0;
    } else {
      $theta = $lon_user - $lon_toko;
      $dist = sin(deg2rad($lat_user)) * sin(deg2rad($lat_toko)) +  cos(deg2rad($lat_user)) * cos(deg2rad($lat_toko)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;

      return ($miles * 1.609344 * 1000);
    }
  }

  public function prosesAbsenMasuk()
  {
    $foto = $this->input->post('image');
    $username = $this->input->post('username');
    $time = time();
    $user_toko_id = $this->Api_absen_model->getTokoIdByUser($username);
    $user_shift = $this->Api_absen_model->getUserShift($username);
    $jam = (int) date('G');
    $jam = $jam *  60;
    $menit = (int) date('i');
    $now_minute = $jam + $menit;
    $predikat = $this->getPredikat($user_shift['range_start'], $user_shift['range_mid'], $user_shift['range_end'], $now_minute, 'txt');
    $score = $this->getPredikat($user_shift['range_start'], $user_shift['range_mid'], $user_shift['range_end'], $now_minute, 'score');
    $status_foto = $this->uploadFoto($username, $foto, "absen_masuk");

    if ($status_foto['status'] && $user_toko_id != '') {
      $status_insert =  $this->Api_absen_model->prosesAbsenMasuk($time, $username, $user_toko_id, $predikat, $status_foto['nama_foto'], $score);

      if ($status_insert) {
        $callback = array(
          'status' => true,
          'message' => 'Absen masuk berhasil!'
        );
        echo json_encode($callback);
      } else {
        $callback = array(
          'status' => false,
          'message' => 'Gagal menyimpan ke database!'
        );
        echo json_encode($callback);
      }
    } else {
      $callback = array(
        'status' => false,
        'message' => 'Gagal upload foto!'
      );
      echo json_encode($callback);
    }
  }

  public function prosesAbsenPulang()
  {
    $foto = $this->input->post('image');
    $username = $this->input->post('username');
    $time = time();
    $user_toko_id = $this->Api_absen_model->getTokoIdByUser($username);
    $status_foto = $this->uploadFoto($username, $foto, "absen_pulang");

    if ($status_foto['status'] && $user_toko_id != '') {
      $status_insert =  $this->Api_absen_model->prosesAbsenPulang($time, $username, $status_foto['nama_foto']);

      if ($status_insert) {
        $callback = array(
          'status' => true,
          'message' => 'Absen pulang berhasil!'
        );
        echo json_encode($callback);
      } else {
        $callback = array(
          'status' => false,
          'message' => 'Gagal menyimpan ke database!'
        );
        echo json_encode($callback);
      }
    } else {
      $callback = array(
        'status' => false,
        'message' => 'Gagal upload foto!'
      );
      echo json_encode($callback);
    }
  }

  private function uploadFoto($username, $image, $prefix)
  {
    $dir = './upload/absen';

    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }

    $image_name = $username . '_' . $prefix . '_' . date('d-m-Y', time()) . '.jpg';
    $image_path =  $dir . '/' . $image_name;

    if (file_put_contents($image_path, base64_decode($image))) {
      $callback = array(
        'status' => true,
        'nama_foto' => $image_name
      );

      return $callback;
    } else {
      $callback = array(
        'status' => false
      );

      return $callback;
    }
  }

  public function tes()
  {
    $username = $this->input->post('username');

    $id = $this->Api_absen_model->getIdAbsenByAbsenMasuk($username);
    $data = array(
      'id' => $id,
      'time_start' => date('d-m-Y ') . '00:00:00',
      'time_end' => date('d-m-Y ') . '23:59:59',
      'now' => date('d-m-Y H:i:s')
    );
    echo json_encode($data);
  }
}
