<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SiswaModel extends CI_Model {
	// Fungsi untuk menampilkan semua data siswa
	public function view(){
		return $this->db->get('siswa')->result();
	}

	// Fungsi untuk validasi form tambah dan ubah
	public function validation($mode){
		$this->load->library('form_validation'); // Load library form_validation untuk proses validasinya

		// Tambahkan if apakah $mode save atau update
		// Karena ketika update, NIS tidak harus divalidasi
		// Jadi NIS di validasi hanya ketika menambah data siswa saja
		if($mode == "save")
			$this->form_validation->set_rules('input_nis', 'NIS', 'required|numeric|max_length[11]');

		$this->form_validation->set_rules('input_nama', 'Nama', 'required|max_length[50]');
		$this->form_validation->set_rules('input_jeniskelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('input_telp', 'telp', 'required|numeric|max_length[15]');
		$this->form_validation->set_rules('input_alamat', 'Alamat', 'required');

		if($this->form_validation->run()) // Jika validasi benar
			return true; // Maka kembalikan hasilnya dengan TRUE
		else // Jika ada data yang tidak sesuai validasi
			return false; // Maka kembalikan hasilnya dengan FALSE
	}

	// Fungsi untuk melakukan simpan data ke tabel siswa
	public function save(){
		$data = array(
			"nis" => $this->input->post('input_nis'),
			"nama" => $this->input->post('input_nama'),
			"jenis_kelamin" => $this->input->post('input_jeniskelamin'),
			"telp" => $this->input->post('input_telp'),
			"alamat" => $this->input->post('input_alamat')
		);

		$this->db->insert('siswa', $data); // Untuk mengeksekusi perintah insert data
	}

	// Fungsi untuk melakukan ubah data siswa berdasarkan ID siswa
	public function edit($id){
		$data = array(
			"nis" => $this->input->post('input_nis'),
			"nama" => $this->input->post('input_nama'),
			"jenis_kelamin" => $this->input->post('input_jeniskelamin'),
			"telp" => $this->input->post('input_telp'),
			"alamat" => $this->input->post('input_alamat')
		);

		$this->db->where('id', $id);
		$this->db->update('siswa', $data); // Untuk mengeksekusi perintah update data
	}

	// Fungsi untuk melakukan menghapus data siswa berdasarkan ID siswa
	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('siswa'); // Untuk mengeksekusi perintah delete data
	}
}
