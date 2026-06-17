<?php
//require_once 'database.php';
require_once 'tiket.php';

class TiketIMAX extends Tiket{
    protected $kacamata3dld;
    protected $efekGerakFitur;

    #[Override]
    public function __construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket,$kacamata3dld,$efekGerakFitur){
        parent::__construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->kacamata3dld = $kacamata3dld;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    //method getData untuk query WHERE
    public static function getData(){
        return "WHERE jenis_studio = 'IMAX'";
    }

    //method getter
    public function getKacamata3dld(){return $this->kacamata3dld;}
    public function getefekGerakFitur(){return $this->efekGerakFitur;}

    //implementasikan polimorfisme method dari kelas Tiket
    #[Override]
    public function hitungTotalHarga(){
        $totalHarga = ($this->jumlah_kursi * $this->hargaDasarTiket) + 35000;
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
    Kacamata 3D ID : ".$this->kacamata3dld."<br>
    Efek Gerak Fitur : ".$this->efekGerakFitur;
   }
}


?>