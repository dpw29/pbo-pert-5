# pbo-pert-5
# Mini Aplikasi OOP – Sistem Reservasi Ruang Perpustakaan

**Nama:** Damar Pasha Wijaya | **NIM:** 20251020007
**Mata Kuliah:** Pemrograman Berbasis Objek | **Bahasa:** PHP 8

## 1. Masalah
Perpustakaan memiliki beberapa jenis ruang (ruang diskusi, ruang multimedia) dengan aturan biaya dan fasilitas berbeda. Pencatatan manual rawan bentrok: ruang yang sedang dipakai bisa dipesan ulang. Aplikasi ini mensimulasikan reservasi ruang dan memastikan ruang yang sudah terpakai tidak bisa dipesan lagi.

## 2. Desain
Kandidat class (5): `Ruang` (abstract), `RuangDiskusi`, `RuangMultimedia`, `Anggota`, `Reservasi`, serta interface `Dapat_Dipesan`.

| Elemen | Implementasi |
|---|---|
| Inheritance | `RuangDiskusi` dan `RuangMultimedia` mewarisi `Ruang` |
| Interface | `Dapat_Dipesan` (`pesan()`, `batalkan()`) diimplementasikan oleh `Ruang` |
| Abstract class | `Ruang` dengan abstract method `hitungBiaya()` |
| Composition/Association | `Reservasi` memiliki objek `Anggota` dan `Ruang` |
| Overriding | `RuangMultimedia::getInfo()` menimpa `Ruang::getInfo()` untuk menambah fasilitas |
| Polymorphism | Array `Ruang[]` di-loop; `hitungBiaya()` dan `getInfo()` menghasilkan perilaku berbeda sesuai tipe objek |

## 3. Alasan Pilihan Relasi
- **Inheritance** dipilih karena `RuangDiskusi` dan `RuangMultimedia` adalah jenis dari `Ruang` (relasi *is-a*) dan berbagi property serta perilaku dasar.
- **Abstract class** dipilih karena `Ruang` tidak pernah dibuat langsung, tetapi perlu memaksa tiap jenis ruang menentukan cara hitung biayanya sendiri.
- **Interface** dipilih untuk mendefinisikan kontrak "dapat dipesan" yang terpisah dari struktur data ruang, sehingga mudah dipakai class lain di masa depan.
- **Composition/Association** dipilih untuk `Reservasi` karena reservasi *memiliki* anggota dan ruang (relasi *has-a*), bukan merupakan jenis dari keduanya.

## 4. Cara Menjalankan
```
php index.php
```
Screenshot output disimpan sebagai `output.png`.
