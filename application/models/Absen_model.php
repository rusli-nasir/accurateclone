<?php
class Absen_model extends CI_Model
{
  public function getFirstDateOfRecord()
  {
    $sql = "
      SELECT time_masuk
      FROM absen  
      ORDER BY time_masuk
      LIMIT 1
    ";
    return $this->db->query($sql)->row_array()['time_masuk'];
  }

  public function getLastDateOfRecord()
  {
    $sql = "
      SELECT time_masuk
      FROM absen  
      ORDER BY time_masuk DESC
      LIMIT 1
    ";
    $time_masuk = $this->db->query($sql)->row_array()['time_masuk'];

    $sql = "
      SELECT time_pulang
      FROM absen  
      ORDER BY time_pulang DESC
      LIMIT 1
    ";
    $time_pulang = $this->db->query($sql)->row_array()['time_pulang'];

    return max($time_masuk, $time_pulang);
  }

  public function getDataAbsensi($start, $end)
  {
    $sql = "
      SELECT a.time_masuk, a.time_pulang, a.krywn_username, t.nama AS t_nama, a.predikat, a.foto_masuk, a.foto_pulang, a.score
      FROM absen a
      JOIN toko t
        ON t.id = a.toko_id
      WHERE time_masuk BETWEEN $start AND $end OR time_pulang BETWEEN $start AND $end
    ";
    return $this->db->query($sql)->result_array();
  }

  public function getIdAbsenNotClosed()
  {
    $sql = "
      SELECT id
      FROM absen
      WHERE time_pulang = 0
    ";
    return $this->db->query($sql)->result_array();
  }

  public function processClosingAbsensi($id)
  {
    $sql = "
      SELECT time_masuk
      FROM absen
      WHERE id = $id
      LIMIT 1
    ";

    $time_masuk = (int) $this->db->query($sql)->row_array()['time_masuk'];

    $time_end = (int) strtotime(date('Y-m-d', $time_masuk) . ' 23:59:59');
    $time_diff_w_now = time() - $time_end;

    if ($time_diff_w_now >= 0) {
      $data = array(
        'time_pulang' => $time_masuk + 28800
      );

      $this->db->where('id', $id);
      $this->db->update('absen', $data);
    }
  }
}
