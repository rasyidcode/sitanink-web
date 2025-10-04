# Sitanink Web

Sistem keanggotaan petani di Nusakambangan berbasis web.

## Notification Plan

- create table named activities, which has stable structure:
  - id
  - type [info, reminder]
  - message
  - is_read
  - created_at
- Any database operation will be captured on this table
- Sample data for "User ID Card"
  - 1
  - reminder
  - Masa berlaku kartu dari "Nama Pekerja" akan berakhir 3 hari lagi
  - false
  - 5 minutes ago
- Sampe data for "Any DB operation"
  - 2
  - info
  - User "username" menambahkan lokasi pekerja
  - true,
  - 10 minutes ago

## Usefull Resources

- [https://usefulangle.com/post/352/javascript-capture-image-from-camera](js-capture-image-from-camera)
- [https://image.intervention.io/v2/api/resize](image-reizerer)
- [https://www.sourcecodester.com/download-code?nid=12040&title=ID+Generator+in+PHP+with+Source+Code](id-card-generator-example)

## To Do [2022-06-03]

- [x] Update Data Pekerja CRUD
- [x] Data Per Wilayah
- [x] Data QRCode
- [x] Data Kartu
- [x] Data SK
- [x] Pusat Berkas

## To Do [2022-06-02]

### Section 1

- [x] Master Data Domisili CRUD
- [x] Master Data Lokasi Kerja CRUD
- [x] Master Data Jenis Pekerja CRUD
- [x] Master Data Pekerjaan CRUD

### Section 2

- [x] Seeder Master Data Domisili
- [x] Seeder Master Data Lokasi Kerja
- [x] Seeder Master Data Jenis Pekerja
- [x] Seeder Master Data Pekerjaan
- [x] Deploy to Hosting

## To Do [2022-05-29]

- [x] Edit Data Pekerja
- [x] Review Data Simple Pagination
- [x] List Data Wilayah
- [x] Map Data Wilayah
- [x] Filter Data Wilayah
- [x] Halaman Kartu
- [x] Halaman SK
- [x] Halaman Hasil Generate Dari QR Code HP
- [x] Halaman Berkas
- [x] Halaman Notifikasi
- [x] Halaman Pengaturan
- [x] Ganti Icon Data Per Wilayah jadi ION
- [x] Master Data Domisili
- [x] Master Data Lokasi Kerja
- [x] Master Data Jenis Pekerja
- [x] Master Data Pekerjaan

## To Do [2022-05-28]

## To Do [2022-05-27]

- [x] Review page status
  - pending -> already inserted but not yet confirmed
  - canceled -> the data is canceled
- [x] Confirm Review
- [x] Cancel Review
- [x] Test input data pekerja from inputdata
- [x] Hapus Data Pekerja
- [x] Detail Data Pekerja
