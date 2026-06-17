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


    
}





?>