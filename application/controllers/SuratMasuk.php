<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class SuratMasuk extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model("ModelSuratMasuk", "suratmasuk");
    $this->load->model("ModelBidang", "bidang");
  }
  //  Method untuk menampilkan data
	public function daftar()
	{
    
    $this->_dts['bidang'] = $this->bidang->data();  // Proses pengambilan data dari database
    $this->_dts['data_list'] = $this->suratmasuk->data();  // Proses pengambilan data dari database
		$this->view('admin.suratmasuk.daftar', $this->_dts); // Oper data dari database ke view
	}
  
	public function daftarDisposisi()
	{
    $this->_dts['data_list'] = $this->suratmasuk->dataDisposisi();  // Proses pengambilan data dari database
		$this->view('kepaladinas.disposisi.daftar', $this->_dts); // Oper data dari database ke view
	}
  
  // Method untuk menampilkan form tambah data
  public function tambah()
  {
    $this->view('admin.suratmasuk.tambah'); // Langsung tampilkan view tambah data
  }
  
  // Method untuk memproses penambahan data
  // Method diakses dalam metode POST
  public function prosesTambah()
  {
    $data = $this->input->post(NULL, TRUE);
    if(file_exists($_FILES['filesurat']['tmp_name']) || is_uploaded_file($_FILES['filesurat']['tmp_name']))
    {
      $data['filesurat'] = fileUpload($_FILES["filesurat"], "./assets/images/");
    }
    else
    {
      $data['filesurat'] = null;
    }
    $this->suratmasuk->tambah($data);
    header("Location: ".site_url("admin/suratmasuk")); // Arahkan kembali user ke halaman daftar
  }
  
  // Method untuk menampilkan form edit
  public function edit()
  {
    $this->_dts['detail'] = $this->suratmasuk->data($this->input->get('id')); // Ambil data yang akan diedit berdasarkan ID
    $this->view('admin.suratmasuk.edit', $this->_dts); // Oper data ke view
  }
  
  // Method untuk memproses data yang akan diedit
  public function prosesEdit()
  {
    $data = $this->input->post(NULL, TRUE);
    if(file_exists($_FILES['filesurat']['tmp_name']) || is_uploaded_file($_FILES['filesurat']['tmp_name']))
    {
      $data['filesurat'] = fileUpload($_FILES["filesurat"], "./assets/images/");
    }
    else
    {
      $data['filesurat'] = null;
    }
    $this->suratmasuk->edit($this->input->post("id"), $data);
    header("Location: ".site_url("admin/suratmasuk")); // Arahkan user kembali ke halaman daftar
  }
  
  // Method untuk menghapus data
  public function prosesHapus()
  {
    $this->suratmasuk->hapus($this->input->get('id')); // Proses hapus data
    header("Location: ".site_url("admin/suratmasuk")); // // Arahkan user kembali ke halaman daftar
  }
  
  public function prosesDisposisi()
  {
    $this->suratmasuk->prosesDisposisi($this->input->post("id"), $this->input->post(NULL, true));
    header("Location: ".site_url("kepaladinas/disposisi")); // // Arahkan user kembali ke halaman daftar
  }
  
}
