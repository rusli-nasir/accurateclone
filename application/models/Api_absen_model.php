<?php
class Api_absen_model extends CI_Model
{
  public function getUserShift($username)
  {
    $sql = "
      SELECT shift
      FROM karyawan
      WHERE username = '$username'
      LIMIT 1
    ";
    $shift = $this->db->query($sql)->row_array()['shift'];
    if ($shift == 'pagi') {
      $data = array(
        'shift' => ucfirst($shift),
        'absen_masuk_buka' => '08:15',
        'absen_masuk_kerja' => '08:45',
        'absen_masuk_telat' => '09:00',
        'absen_pulang_kerja' => '16:45',
        'range_start' => 495,
        'range_mid' => 525,
        'range_end' => 540,
        'mnt_pulang' => 1005
      );
      return $data;
    } else if ($shift == 'sore') {
      $data = array(
        'shift' => ucfirst($shift),
        'absen_masuk_buka' => '13:30',
        'absen_masuk_kerja' => '14:00',
        'absen_masuk_telat' => '14:15',
        'absen_pulang_kerja' => '22:00',
        'range_start' => 810,
        'range_mid' => 840,
        'range_end' => 855,
        'mnt_pulang' => 1320
      );
      return $data;
    } else {
      $data = array(
        'shift' => 'error'
      );
      return $data;
    }
  }

  public function getTokoIdByUser($username)
  {
    $sql = "
      SELECT toko_id AS id
      FROM karyawan
      WHERE username = '$username'
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array()['id'];
  }

  public function getTokoCoordinate($toko_id)
  {
    $sql = "
      SELECT latitude, longitude
      FROM toko
      WHERE id = $toko_id
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function prosesAbsenMasuk($time, $krywn_username, $toko_id, $predikat, $foto, $score)
  {
    //insert data
    $data = array(
      'time_masuk' => $time,
      'time_pulang' => 0,
      'krywn_username' => $krywn_username,
      'toko_id' => $toko_id,
      'predikat' => $predikat,
      'foto_masuk' => $foto,
      'foto_pulang' => "",
      'score' => $score
    );

    $this->db->insert('absen', $data);

    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function getIdAbsenByAbsenMasuk($krywn_username)
  {
    $time_start = date('d-m-Y ') . '00:00:00';
    $time_start = (int) strtotime($time_start);
    $time_end = date('d-m-Y ') . '23:59:59';
    $time_end = (int) strtotime($time_end);

    $sql = "
      SELECT id
      FROM absen
      WHERE krywn_username = '$krywn_username' AND time_masuk BETWEEN $time_start AND $time_end
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array()['id'];
  }

  public function prosesAbsenPulang($time, $krywn_username, $foto)
  {
    $id = $this->getIdAbsenByAbsenMasuk($krywn_username);
    //insert data
    $data = array(
      'time_pulang' => $time,
      'foto_pulang' => $foto,
    );
    $this->db->where('id', $id);
    $this->db->update('absen', $data);

    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function isHasAbsenMasuk($username)
  {
    $time_start = date('Y-m-d') . ' 00:00:00';
    $time_start = (int) strtotime($time_start);
    $time_end = date('Y-m-d') . ' 23:59:59';
    $time_end = (int) strtotime($time_end);

    $sql = "
      SELECT *
      FROM absen
      WHERE krywn_username = '$username' AND time_masuk BETWEEN $time_start AND $time_end
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array();
  }

  public function isHasAbsenPulang($username)
  {
    $time_start = date('Y-m-d') . ' 00:00:00';
    $time_start = (int) strtotime($time_start);
    $time_end = date('Y-m-d') . ' 23:59:59';
    $time_end = (int) strtotime($time_end);

    $sql = "
      SELECT time_pulang
      FROM absen
      WHERE krywn_username = '$username' AND time_masuk BETWEEN $time_start AND $time_end
      LIMIT 1
    ";
    $time_pulang = $this->db->query($sql)->row_array()['time_pulang'];
    if ($time_pulang == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function getTimeMasuk($krywn_username)
  {
    $time_start = date('d-m-Y ') . '00:00:00';
    $time_start = (int) strtotime($time_start);
    $time_end = date('d-m-Y ') . '23:59:59';
    $time_end = (int) strtotime($time_end);

    $sql = "
      SELECT time_masuk
      FROM absen
      WHERE krywn_username = '$krywn_username' AND time_masuk BETWEEN $time_start AND $time_end
      LIMIT 1
    ";

    return $this->db->query($sql)->row_array()['time_masuk'];
  }
}
