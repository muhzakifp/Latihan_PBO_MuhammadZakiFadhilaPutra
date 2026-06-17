<?php

require_once 'tiket.php';

class TiketRegular extends Tiket {
    protected $tipeAudio;
    protected $lokasiBaris;

    #[Override]
    public function __construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket,$tipeAudio,$lokasiBaris){
    parent::__construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
    $this->tipeAudio = $tipeAudio;
    $this->lokasiBaris = $lokasiBaris;
   }

   //method getData untuk query WHERE
    public static function getData(){
        return "WHERE jenis_studio = 'Regular'";
    }

   //method getter
   public function getTipeAudio(){return $this->tipeAudio;}
   public function getlokasiBaris(){return $this->lokasiBaris;}

   //implementasikan polimorfisme method dari kelas Tiket
   #[Override]
   public function hitungTotalHarga(){
    $totalHarga = $this->jumlah_kursi * $this->hargaDasarTiket;
    return $totalHarga;
   }

   #[Override]
   public function tampilkanInfoFasilitas(){
    return "
    ID Tiket : ".$this->id_tiket."<br>
    Nama Tiket : ".$this->nama_tiket."<br>
    Jadwal Tayang : ".$this->jadwal_tayang."<br>
    Jumlah Kursi : ".$this->jumlah_kursi."<br>
    Harga Dasar : Rp ". number_format($this->hargaDasarTiket,0,',','.')."<br>
    Tipe Audio : ".$this->tipeAudio."<br>
    Lokasi Baris : ".$this->lokasiBaris;
   }
}

?>