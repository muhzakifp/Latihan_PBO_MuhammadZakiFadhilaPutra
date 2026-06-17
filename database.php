<?php

class Database{
    public $hostname = 'localhost';
    protected $username = 'root';
    protected $pw = '';
    protected $database = 'db_latihan_pbo_trpl1b_muhammadzakifadhilaputra';
    protected $koneksi;

    public function __construct()
    {
       $this->koneksi = mysqli_connect($this->localhost,$this->username,$this->pw,$this->database);

       if(!$this->koneksi){
        echo "ERROR -Koneksi terputus";
       }
       echo "Koneksi tersambung !";
    }
}

$db = new Koneksi();

?>