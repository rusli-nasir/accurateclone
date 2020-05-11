<?php
class Produk_model extends CI_Model
{
  protected $table = 'produk';

  public function viewTable()
  {
    $sql = "SELECT p.SKU, p.nama, p.harga_modal, p.harga_jual, p.diskon, p.profit, k.nama as k_nama, p.foto
      FROM produk p
      JOIN kategori_produk k
        ON k.id = p.kategori_produk_id
    ";
    $query = $this->db->query($sql);
    return $query->result();
    // return $this->db->get($this->table)->result();
  }

  public function getData($sku)
  {
    return $this->db->get_Where($this->table, array('SKU' => $sku))->row_array();
  }

  public function validation($cekunique)
  {
    if ($cekunique == "1")
      $this->form_validation->set_rules('input_sku', 'SKU', "trim|required|is_unique[produk.SKU]");
    else
      $this->form_validation->set_rules('input_sku', 'SKU', "trim|required");
    $this->form_validation->set_rules('input_nama', 'Nama Produk', 'trim|required');
    $this->form_validation->set_rules('input_harga_modal', 'Harga Modal', 'required');
    $this->form_validation->set_rules('input_harga_jual', 'Harga Jual', 'required');
    $this->form_validation->set_rules('input_profit', 'Profit', 'required');
    $this->form_validation->set_rules('input_kategori', 'Kategori Produk', 'required');

    if ($this->form_validation->run()) // Jika validasi benar
      return true; // Maka kembalikan hasilnya dengan TRUE
    else // Jika ada data yang tidak sesuai validasi
      return false; // Maka kembalikan hasilnya dengan FALSE
  }

  public function save()
  {
    $gambar = "";
    $config['upload_path'] = './upload/produk/'; //path folder
    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
    $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

    $this->load->library('upload', $config);
    if (!empty($_FILES['filefoto']['name'])) {

      if ($this->upload->do_upload('filefoto')) {
        $gbr = $this->upload->data();
        //Compress Image
        $config['image_library'] = 'gd2';
        $config['source_image'] = './upload/produk/' . $gbr['file_name'];
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '50%';
        $config['width'] = 200;
        $config['height'] = 200;
        $config['new_image'] = './upload/produk/' . $gbr['file_name'];
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $gambar = $gbr['file_name'];
      }
    }
    $data = array(
      "SKU" => $this->input->post('input_sku'),
      "kategori_produk_id" => $this->input->post('input_kategori'),
      "nama" => $this->input->post('input_nama'),
      "merk" => $this->input->post('input_merk'),
      "deskripsi" => $this->input->post('input_deskripsi'),
      "foto" => $gambar,
      "harga_modal" => $this->input->post('input_harga_modal'),
      "harga_jual" => $this->input->post('input_harga_jual'),
      "diskon" => $this->input->post('input_diskon'),
      "profit" => $this->input->post('input_profit')
    );

    $this->db->insert($this->table, $data); // Untuk mengeksekusi perintah insert data
    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function update($skuLama)
  {
    $dataLama = $this->getData($skuLama);
    $gambar = $dataLama['foto'];
    $config['upload_path'] = './upload/produk/'; //path folder
    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
    $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

    $this->load->library('upload', $config);
    if (!empty($_FILES['filefoto']['name'])) {

      if ($this->upload->do_upload('filefoto')) {
        $gbr = $this->upload->data();
        //Compress Image
        $config['image_library'] = 'gd2';
        $config['source_image'] = './upload/produk/' . $gbr['file_name'];
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '50%';
        $config['width'] = 200;
        $config['height'] = 200;
        $config['new_image'] = './upload/produk/' . $gbr['file_name'];
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $gambar = $gbr['file_name'];
      }
    }
    $data = array(
      "SKU" => $this->input->post('input_sku'),
      "kategori_produk_id" => $this->input->post('input_kategori'),
      "nama" => $this->input->post('input_nama'),
      "merk" => $this->input->post('input_merk'),
      "deskripsi" => $this->input->post('input_deskripsi'),
      "foto" => $gambar,
      "harga_modal" => $this->input->post('input_harga_modal'),
      "harga_jual" => $this->input->post('input_harga_jual'),
      "diskon" => $this->input->post('input_diskon'),
      "profit" => $this->input->post('input_profit')
    );

    $this->db->where('SKU', $skuLama);
    $this->db->update($this->table, $data); // Untuk mengeksekusi perintah update data
    return ($this->db->affected_rows() != 1) ? false : true;
  }

  public function delete($SKU)
  {
    $this->db->where('SKU', $SKU);
    $this->db->delete($this->table); // Untuk mengeksekusi perintah delete data
    return ($this->db->affected_rows() != 1) ? false : true;
  }
}
