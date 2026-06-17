<?php
require_once 'tiket.php';

class TiketVelvet extends Tiket{
    protected $bantalSelimutPack;
    protected $layananButler;

    #[Override]
    public function __construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket,$bantalSelimutPack,$layananButler){
        parent::__construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->bantalSelimutPack  = $bantalSelimutPack;
        $this->layananButler  = $layananButler;
    }

    //method getData untuk query WHERE
    public static function getData(){
        return "WHERE jenis_studio = 'Velvet'";
    }


    //method getter
    public function getBantalSelimut(){return $this->bantalSelimutPack;}
    public function getLayananButler(){return $this->layananButler;}


    //implementasikan polimorfisme method dari kelas Tiket
    #[Override]
    public function hitungTotalHarga(){
        $totalHarga = ($this->jumlah_kursi * $this->hargaDasarTiket) * 1.50;
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
    Bantal Selimut Pack : ".$this->bantalSelimutPack."<br>
    Layanan Butler : ".$this->layananButler;
   }
}





?>