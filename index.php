<?php
// ==========================================================
// Mini Application OOP - Sistem Reservasi Ruang Perpustakaan
// ==========================================================

// INTERFACE: kontrak untuk semua ruang yang bisa dipesan
interface Dapat_Dipesan
{
    public function pesan(): bool;
    public function batalkan(): void;
}

// ABSTRACT CLASS: kerangka umum semua jenis ruang
abstract class Ruang implements Dapat_Dipesan
{
    protected string $idRuang;
    protected string $namaRuang;
    protected int $kapasitas;
    protected string $statusRuang = "Tersedia";

    public function __construct(string $idRuang, string $namaRuang, int $kapasitas)
    {
        $this->idRuang = $idRuang;
        $this->namaRuang = $namaRuang;
        $this->kapasitas = $kapasitas;
    }

    // Abstract method: wajib di-implementasikan oleh child class
    abstract public function hitungBiaya(int $jam): int;

    public function getNama(): string
    {
        return $this->namaRuang;
    }

    public function getStatus(): string
    {
        return $this->statusRuang;
    }

    public function pesan(): bool
    {
        if ($this->statusRuang === "Terpakai") {
            echo "Gagal: {$this->namaRuang} sedang terpakai.\n";
            return false;
        }
        $this->statusRuang = "Terpakai";
        return true;
    }

    public function batalkan(): void
    {
        $this->statusRuang = "Tersedia";
    }

    public function getInfo(): string
    {
        return "{$this->namaRuang} (Kapasitas: {$this->kapasitas}) - Status: {$this->statusRuang}";
    }
}

// INHERITANCE: RuangDiskusi mewarisi Ruang
class RuangDiskusi extends Ruang
{
    public function hitungBiaya(int $jam): int
    {
        return 0; // gratis untuk mahasiswa
    }
}

// INHERITANCE + OVERRIDING: getInfo() ditimpa agar menampilkan fasilitas
class RuangMultimedia extends Ruang
{
    private string $fasilitas;

    public function __construct(string $idRuang, string $namaRuang, int $kapasitas, string $fasilitas)
    {
        parent::__construct($idRuang, $namaRuang, $kapasitas);
        $this->fasilitas = $fasilitas;
    }

    public function hitungBiaya(int $jam): int
    {
        return 15000 * $jam;
    }

    // OVERRIDING
    public function getInfo(): string
    {
        return parent::getInfo() . " | Fasilitas: {$this->fasilitas}";
    }
}

class Anggota
{
    public function __construct(
        private string $nim,
        private string $nama
    ) {}

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getNim(): string
    {
        return $this->nim;
    }
}

// COMPOSITION/ASSOCIATION: Reservasi memiliki Anggota dan Ruang
class Reservasi
{
    public function __construct(
        private Anggota $anggota,
        private Ruang $ruang,
        private int $durasiJam
    ) {}

    public function proses(): void
    {
        if ($this->ruang->pesan()) {
            $biaya = $this->ruang->hitungBiaya($this->durasiJam);
            echo "{$this->anggota->getNama()} ({$this->anggota->getNim()}) memesan "
               . "{$this->ruang->getNama()} selama {$this->durasiJam} jam. "
               . "Biaya: Rp" . number_format($biaya, 0, ',', '.') . "\n";
        }
    }
}

// ===================== PROGRAM UTAMA =====================
$daftarRuang = [
    new RuangDiskusi("R01", "Ruang Diskusi A", 5),
    new RuangDiskusi("R02", "Ruang Diskusi B", 10),
    new RuangMultimedia("R03", "Ruang Multimedia", 20, "Proyektor, Sound System"),
];

echo "--- Daftar Ruang ---\n";
// POLYMORPHISM: method yang sama (getInfo & hitungBiaya) dipanggil
// pada objek berbeda, hasilnya menyesuaikan tipe objeknya
foreach ($daftarRuang as $ruang) {
    echo $ruang->getInfo() . " | Biaya 2 jam: Rp"
       . number_format($ruang->hitungBiaya(2), 0, ',', '.') . "\n";
}

echo "\n--- Proses Reservasi ---\n";
$damar = new Anggota("20251020007", "Damar Pasha Wijaya");
(new Reservasi($damar, $daftarRuang[0], 2))->proses();
(new Reservasi($damar, $daftarRuang[2], 3))->proses();
(new Reservasi($damar, $daftarRuang[0], 1))->proses(); // gagal: sudah terpakai

echo "\n--- Status Akhir ---\n";
foreach ($daftarRuang as $ruang) {
    echo $ruang->getInfo() . "\n";
}
