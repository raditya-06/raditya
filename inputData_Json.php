<?php
//definisikan nama file JSON
define('FILE_JSON', 'barang.json');

/*prosedur untuk cek apakah file json ada,
jika tidak ada maka buat nama file json dengan data kosong */
function cekFileJson()
{
    //jika file json tidak ada, maka
    if (!file_exists(FILE_JSON)) {
        //BUAT FILE JSON
        file_put_contents(FILE_JSON, json_encode([]));
    }
}

//fungsi untuk membaca data dari file json
function bacaDataJson()
{
    /* PHP tidak mengenal tipe data JSON ke array dengan perintah "json_decode"
    setelah dikonversi ke funsi yang memanggilnya menggunakan perintah "return".*/
    return json_decode(file_get_contents(FILE_JSON), true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //panggil prosedur cekfilejson()
    cekFileJson();

    /*simpan ke variabel Ambil Data dari form (nama input type) */
    $nama         = $_POST['nama'];
    $email         = $_POST['email'];
    $hp         = $_POST['hp'];
    $alamat         = $_POST['alamat'];
    //panggil fungsi bacaDataJson()
    $data_siswa = bacaDataJson();

    //cek apakah kode barang sudah ada
    for ($i = 0; $i < count($data_siswa); $i++) {
        /*perbandingan nilai (=), perbandingan tipe data (==),
     perbaningan nilai dan tipe data (===) */
        if ($data_siswa[$i]['nama'] === $nama) {
            //tampilan pesan barang sudah ada
            echo "<script>alert('Data dengan nama: $nama sudah ada!');</script>";
            //tampilkan pesan barang sudah ada
            echo "<script>window.location.href ='login.html';</script>";
            exit;
        }
    }

    $data_siswa[] = [
        'nama' => $nama,
        'email' => $email,
        'hp' => $hp,
        'alamat' => $alamat
        
        
    ];
    /* konversi data array pada "$data_barang" ke JSON dengan perintah "json_encode"
    format output JSON agar lebih mudah dibaca oleh manusia dengan perintah :JSON_PRETTY_PRINT"*/

    file_put_contents(FILE_JSON, json_encode($data_siswa, JSON_PRETTY_PRINT));
    //tampilkan pesan data berhasil ditambah
    echo "<script>alert('Data Berhasil Ditambahkan!');</script>";
    //setelah tombol OK di klik pada pesan, alihkan halaman ke frimbarang.html
    echo "<script>window.location.href = 'login.html';</script>";
}
