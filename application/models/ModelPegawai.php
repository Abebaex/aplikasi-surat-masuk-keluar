<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelPegawai extends MY_Model {
  // Nama Tabel
  private $table = "pegawai";      // nama tabelnya
  private $primaryKey = "id"; // primary keynya
  
  
  //  Method untuk menampilkan data
  // kalau idnya tidak diatur alias kosong data() , maka ambil semua data
  // kalau idnya diatur data("P0001") maka data P0001 yang akan diambil
	public function data($id = null)
	{
    if($id != null)
    {
      return $this->db->get($this->table, "*", [$this->primaryKey => $id]);
    }
    else
    {
      return $this->db->select($this->table, "*");
    }
	}
  
  // method untuk menambah data
  public function tambah($data)
  {
    $data_tmp = [
      "nip" => $data["nip"],
      "nama" => $data["nama"],
      "tempatlhr" => $data["tempatlhr"],
      "tgllahir" => $data["tgllahir"],
      "jeniskelamin" => $data["jeniskelamin"],
      "alamat" => $data["alamat"],
      "status" => $data["status"],
      "hp" => $data["hp"],
      "jabatan" => $data["jabatan"],
      "gol" => $data["gol"],
      "level" => $data["level"]
    ];
    if(isset($data['password']) || !empty($data['password']))
    {
      $data_tmp["password"] = $data["password"];
    }
    if(isset($data['foto']) || !empty($data['foto']))
    {
      $data_tmp["foto"] = $data["foto"];
    }
    $this->db->insert($this->table, $data_tmp);
    
    return true;
  }
  
  // method untuk edit data
  public function edit($id, $data)
  {
    $data_tmp = [
      "nip" => $data["nip"],
      "nama" => $data["nama"],
      "tempatlhr" => $data["tempatlhr"],
      "tgllahir" => $data["tgllahir"],
      "jeniskelamin" => $data["jeniskelamin"],
      "alamat" => $data["alamat"],
      "status" => $data["status"],
      "hp" => $data["hp"],
      "jabatan" => $data["jabatan"],
      "gol" => $data["gol"],
      "level" => $data["level"]
    ];
    if(isset($data['password']) || !empty($data['password']))
    {
      $data_tmp["password"] = $data["password"];
    }

    if(isset($data['foto']) || !empty($data['foto']))
    {
      $data_tmp["foto"] = $data["foto"];
    }
    $this->db->update($this->table, $data_tmp,[
      $this->primaryKey => $id
    ]);
    return true;
  }
  
  // method untuk hapus data
  public function hapus($id)
  {
    $this->db->delete($this->table, [ $this->primaryKey => $id]);
    return true;
  }
  
  public function cekLogin($username, $password)
  {
    return $this->db->get($this->table, "*", ["nip" => $username, "password" => $password]);
  }
 
}
