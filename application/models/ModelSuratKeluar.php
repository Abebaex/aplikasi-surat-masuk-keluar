<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelSuratKeluar extends MY_Model {
  // Nama Tabel
  private $table = "suratkeluar";      // nama tabelnya
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
      return $this->db->query("SELECT a.*, b.bidang FROM suratkeluar a JOIN bidang b ON a.nip = b.nip")->fetchAll(PDO::FETCH_ASSOC);
    }
	}
  public function dataWhere($where)
  {
    return $this->db->select($this->table, ["[><]bidang" => ["id_bidang" => "id"]], "*", $where);
  }
  
  // method untuk menambah data
  public function tambah($data)
  {
    $data_tmp = [
      "nomorsk" => $data["nomorsk"],
      "id_bidang" => $data["id_bidang"],
      "tglsurat" => $data["tglsurat"],
      "judulsurat" => $data["judulsurat"],
      "tujuan" => $data["tujuan"],
      "perihal" => $data["perihal"],
      "alamat" => $data["alamat"],
      "catatan" => $data["catatan"]
    ];
    if(isset($data['filesurat']) || !empty($data['filesurat']))
    {
      $data_tmp["filesurat"] = $data["filesurat"];
    }
    $this->db->insert($this->table, $data_tmp);
    
    return $this->db->id();
  }
  
  // method untuk edit data
  public function edit($id, $data)
  {
    $data_tmp = [
      "nomorsk" => $data["nomorsk"],
      "id_bidang" => $data["id_bidang"],
      "tglsurat" => $data["tglsurat"],
      "judulsurat" => $data["judulsurat"],
      "tujuan" => $data["tujuan"],
      "perihal" => $data["perihal"],
      "alamat" => $data["alamat"],
      "catatan" => $data["catatan"]
    ];
    if(isset($data['filesurat']) || !empty($data['filesurat']))
    {
      $data_tmp["filesurat"] = $data["filesurat"];
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
  
  public function dataStatistikSuratKeluar($id_bidang = null)
  {
    $data = [];
    if($id_bidang == null)
    {
      $data = $this->db->query("
      SELECT 
      (SELECT COUNT(id) FROM suratkeluar) AS keluar;
    ")->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
      $data = $this->db->query("
          SELECT 
          (SELECT IFNULL(COUNT(id), 0) FROM suratkeluar) AS keluar WHERE id_bidang = ".$id_bidang)->fetch(PDO::FETCH_ASSOC);
    }
    if($data == null)
    {
      $data["keluar"] = 0;
    }
    return $data;
  }
 
}
