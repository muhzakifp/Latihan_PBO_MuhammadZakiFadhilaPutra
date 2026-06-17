<?php
require_once 'tiket.php';

class TiketIMAX extends Tiket{
    protected $kacamata3dld;
    protected $efekGerakFitur;

    #[Override]
    public function __construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket,$kacamata3dld,$efekGerakFitur){
        return parent::__construct($id_tiket, $nama_tiket, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        $this->kacamata3dld = $kacamata3dld;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    //method getter
    public function getKacamata3dld(){return $this->kacamata3dld;}
    public function getefekGerakFitur(){return $this->efekGerakFitur;}
}


?>