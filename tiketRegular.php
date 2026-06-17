<?php

require_once 'tiket.php';

class TiketRegular extends Tiket {
    protected $tipeAudio;
    protected $lokasiBaris;

    #[Override]
    public function __construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket,$tipeAudio,$lokasiBaris){
    return parent::__construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
    $this->tipeAudio = $tipeAudio;
    $this->lokasiBaris = $lokasiBaris;
   }

   //method getter
   public function getTipeAudio(){return $this->tipeAudio;}
   public function getlokasiBaris(){return $this->lokasiBaris;}
}

?>