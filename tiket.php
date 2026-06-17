<?php
require_once 'database.php';

abstract class Tiket{
    protected $id_tiket;
    protected $nama_tiket;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $hargaDasarTiket;

    public function __construct($id_tiket,$nama_tiket,$jadwal_tayang,$jumlah_kursi,$hargaDasarTiket ){
        $this->id_tiket = $id_tiket;
        $this->nama_tiket = $nama_tiket;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->hargaDasarTiket = $hargaDasarTiket;
    }

    //method getter
    public function getIdTiket(){return $this->id_tiket;}
    public function getnamaTiket(){return $this->nama_tiket;}
    public function getjadwalTayang(){return $this->jadwal_tayang;}
    public function getjumlahKursi(){return $this->jumlah_kursi;}
    public function gethargaDasarTiket(){return $this->hargaDasarTiket;}

    //method abstrak
    abstract function hitungTotalHarga();
    abstract function tampilkanInfoFasilitas();

}

?>