<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Bank;

class UniversityBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Universities - Expanded list of popular universities in Indonesia
        $universities = [
            // Universitas Negeri Populer
            ['name' => 'Universitas Indonesia', 'acronym' => 'UI', 'type' => 'negeri', 'city' => 'Depok', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.ui.ac.id'],
            ['name' => 'Universitas Gadjah Mada', 'acronym' => 'UGM', 'type' => 'negeri', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.ugm.ac.id'],
            ['name' => 'Institut Teknologi Bandung', 'acronym' => 'ITB', 'type' => 'negeri', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.itb.ac.id'],
            ['name' => 'Institut Pertanian Bogor', 'acronym' => 'IPB', 'type' => 'negeri', 'city' => 'Bogor', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.ipb.ac.id'],
            ['name' => 'Universitas Brawijaya', 'acronym' => 'UB', 'type' => 'negeri', 'city' => 'Malang', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.ub.ac.id'],
            ['name' => 'Universitas Diponegoro', 'acronym' => 'UNDIP', 'type' => 'negeri', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.undip.ac.id'],
            ['name' => 'Universitas Padjadjaran', 'acronym' => 'UNPAD', 'type' => 'negeri', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.unpad.ac.id'],
            ['name' => 'Universitas Airlangga', 'acronym' => 'UNAIR', 'type' => 'negeri', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.unair.ac.id'],
            ['name' => 'Universitas Sebelas Maret', 'acronym' => 'UNS', 'type' => 'negeri', 'city' => 'Surakarta', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.uns.ac.id'],
            ['name' => 'Universitas Sumatera Utara', 'acronym' => 'USU', 'type' => 'negeri', 'city' => 'Medan', 'province' => 'Sumatera Utara', 'logo_url' => null, 'website' => 'https://www.usu.ac.id'],
            ['name' => 'Universitas Hasanuddin', 'acronym' => 'UNHAS', 'type' => 'negeri', 'city' => 'Makassar', 'province' => 'Sulawesi Selatan', 'logo_url' => null, 'website' => 'https://www.unhas.ac.id'],
            ['name' => 'Universitas Andalas', 'acronym' => 'UNAND', 'type' => 'negeri', 'city' => 'Padang', 'province' => 'Sumatera Barat', 'logo_url' => null, 'website' => 'https://www.unand.ac.id'],
            ['name' => 'Universitas Lampung', 'acronym' => 'UNILA', 'type' => 'negeri', 'city' => 'Bandar Lampung', 'province' => 'Lampung', 'logo_url' => null, 'website' => 'https://www.unila.ac.id'],
            ['name' => 'Universitas Jenderal Soedirman', 'acronym' => 'UNSOED', 'type' => 'negeri', 'city' => 'Purwokerto', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.unsoed.ac.id'],
            ['name' => 'Universitas Negeri Yogyakarta', 'acronym' => 'UNY', 'type' => 'negeri', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.uny.ac.id'],
            ['name' => 'Universitas Negeri Jakarta', 'acronym' => 'UNJ', 'type' => 'negeri', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.unj.ac.id'],
            ['name' => 'Universitas Negeri Malang', 'acronym' => 'UM', 'type' => 'negeri', 'city' => 'Malang', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.um.ac.id'],
            ['name' => 'Universitas Negeri Semarang', 'acronym' => 'UNNES', 'type' => 'negeri', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.unnes.ac.id'],
            ['name' => 'Universitas Negeri Surabaya', 'acronym' => 'UNESA', 'type' => 'negeri', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.unesa.ac.id'],
            ['name' => 'Universitas Negeri Padang', 'acronym' => 'UNP', 'type' => 'negeri', 'city' => 'Padang', 'province' => 'Sumatera Barat', 'logo_url' => null, 'website' => 'https://www.unp.ac.id'],
            ['name' => 'Universitas Negeri Medan', 'acronym' => 'UNIMED', 'type' => 'negeri', 'city' => 'Medan', 'province' => 'Sumatera Utara', 'logo_url' => null, 'website' => 'https://www.unimed.ac.id'],
            ['name' => 'Universitas Negeri Makassar', 'acronym' => 'UNM', 'type' => 'negeri', 'city' => 'Makassar', 'province' => 'Sulawesi Selatan', 'logo_url' => null, 'website' => 'https://www.unm.ac.id'],
            ['name' => 'Universitas Riau', 'acronym' => 'UNRI', 'type' => 'negeri', 'city' => 'Pekanbaru', 'province' => 'Riau', 'logo_url' => null, 'website' => 'https://www.unri.ac.id'],
            ['name' => 'Universitas Jambi', 'acronym' => 'UNJA', 'type' => 'negeri', 'city' => 'Jambi', 'province' => 'Jambi', 'logo_url' => null, 'website' => 'https://www.unja.ac.id'],
            ['name' => 'Universitas Sriwijaya', 'acronym' => 'UNSRI', 'type' => 'negeri', 'city' => 'Palembang', 'province' => 'Sumatera Selatan', 'logo_url' => null, 'website' => 'https://www.unsri.ac.id'],
            ['name' => 'Universitas Bengkulu', 'acronym' => 'UNIB', 'type' => 'negeri', 'city' => 'Bengkulu', 'province' => 'Bengkulu', 'logo_url' => null, 'website' => 'https://www.unib.ac.id'],
            ['name' => 'Universitas Tanjungpura', 'acronym' => 'UNTAN', 'type' => 'negeri', 'city' => 'Pontianak', 'province' => 'Kalimantan Barat', 'logo_url' => null, 'website' => 'https://www.untan.ac.id'],
            ['name' => 'Universitas Lambung Mangkurat', 'acronym' => 'ULM', 'type' => 'negeri', 'city' => 'Banjarmasin', 'province' => 'Kalimantan Selatan', 'logo_url' => null, 'website' => 'https://www.ulm.ac.id'],
            ['name' => 'Universitas Mulawarman', 'acronym' => 'UNMUL', 'type' => 'negeri', 'city' => 'Samarinda', 'province' => 'Kalimantan Timur', 'logo_url' => null, 'website' => 'https://www.unmul.ac.id'],
            ['name' => 'Universitas Sam Ratulangi', 'acronym' => 'UNSRAT', 'type' => 'negeri', 'city' => 'Manado', 'province' => 'Sulawesi Utara', 'logo_url' => null, 'website' => 'https://www.unsrat.ac.id'],
            ['name' => 'Universitas Halu Oleo', 'acronym' => 'UHO', 'type' => 'negeri', 'city' => 'Kendari', 'province' => 'Sulawesi Tenggara', 'logo_url' => null, 'website' => 'https://www.uho.ac.id'],
            ['name' => 'Universitas Tadulako', 'acronym' => 'UNTAD', 'type' => 'negeri', 'city' => 'Palu', 'province' => 'Sulawesi Tengah', 'logo_url' => null, 'website' => 'https://www.untad.ac.id'],
            ['name' => 'Universitas Pattimura', 'acronym' => 'UNPATTI', 'type' => 'negeri', 'city' => 'Ambon', 'province' => 'Maluku', 'logo_url' => null, 'website' => 'https://www.unpatti.ac.id'],
            ['name' => 'Universitas Cenderawasih', 'acronym' => 'UNCEN', 'type' => 'negeri', 'city' => 'Jayapura', 'province' => 'Papua', 'logo_url' => null, 'website' => 'https://www.uncen.ac.id'],
            ['name' => 'Universitas Udayana', 'acronym' => 'UNUD', 'type' => 'negeri', 'city' => 'Denpasar', 'province' => 'Bali', 'logo_url' => null, 'website' => 'https://www.unud.ac.id'],
            ['name' => 'Universitas Mataram', 'acronym' => 'UNRAM', 'type' => 'negeri', 'city' => 'Mataram', 'province' => 'Nusa Tenggara Barat', 'logo_url' => null, 'website' => 'https://www.unram.ac.id'],
            ['name' => 'Universitas Nusa Cendana', 'acronym' => 'UNDANA', 'type' => 'negeri', 'city' => 'Kupang', 'province' => 'Nusa Tenggara Timur', 'logo_url' => null, 'website' => 'https://www.undana.ac.id'],
            ['name' => 'Institut Teknologi Sepuluh Nopember', 'acronym' => 'ITS', 'type' => 'negeri', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.its.ac.id'],
            ['name' => 'Universitas Pendidikan Indonesia', 'acronym' => 'UPI', 'type' => 'negeri', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.upi.edu'],
            ['name' => 'Universitas Syiah Kuala', 'acronym' => 'UNSYIAH', 'type' => 'negeri', 'city' => 'Banda Aceh', 'province' => 'Aceh', 'logo_url' => null, 'website' => 'https://www.unsyiah.ac.id'],
            ['name' => 'Universitas Jember', 'acronym' => 'UNEJ', 'type' => 'negeri', 'city' => 'Jember', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.unej.ac.id'],
            ['name' => 'Universitas Trunojoyo Madura', 'acronym' => 'UTM', 'type' => 'negeri', 'city' => 'Bangkalan', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.trunojoyo.ac.id'],
            ['name' => 'Universitas Sultan Ageng Tirtayasa', 'acronym' => 'UNTIRTA', 'type' => 'negeri', 'city' => 'Serang', 'province' => 'Banten', 'logo_url' => null, 'website' => 'https://www.untirta.ac.id'],
            
            // Universitas Swasta Populer
            ['name' => 'Universitas Bina Nusantara', 'acronym' => 'BINUS', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.binus.ac.id'],
            ['name' => 'Universitas Telkom', 'acronym' => 'TEL-U', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.telkomuniversity.ac.id'],
            ['name' => 'Universitas Pelita Harapan', 'acronym' => 'UPH', 'type' => 'swasta', 'city' => 'Tangerang', 'province' => 'Banten', 'logo_url' => null, 'website' => 'https://www.uph.edu'],
            ['name' => 'Universitas Atma Jaya Yogyakarta', 'acronym' => 'UAJY', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.uajy.ac.id'],
            ['name' => 'Universitas Kristen Petra', 'acronym' => 'UK Petra', 'type' => 'swasta', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.petra.ac.id'],
            ['name' => 'Universitas Atma Jaya Jakarta', 'acronym' => 'UAJ', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.atmajaya.ac.id'],
            ['name' => 'Universitas Tarumanagara', 'acronym' => 'UNTAR', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.untar.ac.id'],
            ['name' => 'Universitas Trisakti', 'acronym' => 'USAKTI', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.trisakti.ac.id'],
            ['name' => 'Universitas Mercu Buana', 'acronym' => 'UMB', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.mercubuana.ac.id'],
            ['name' => 'Universitas Gunadarma', 'acronym' => 'UG', 'type' => 'swasta', 'city' => 'Depok', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.gunadarma.ac.id'],
            ['name' => 'Universitas Esa Unggul', 'acronym' => 'UEU', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.esaunggul.ac.id'],
            ['name' => 'Universitas Paramadina', 'acronym' => 'UP', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.paramadina.ac.id'],
            ['name' => 'Universitas Prasetiya Mulya', 'acronym' => 'Prasmul', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.prasetiyamulya.ac.id'],
            ['name' => 'Universitas Islam Indonesia', 'acronym' => 'UII', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.uii.ac.id'],
            ['name' => 'Universitas Muhammadiyah Yogyakarta', 'acronym' => 'UMY', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.umy.ac.id'],
            ['name' => 'Universitas Muhammadiyah Malang', 'acronym' => 'UMM', 'type' => 'swasta', 'city' => 'Malang', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.umm.ac.id'],
            ['name' => 'Universitas Muhammadiyah Surakarta', 'acronym' => 'UMS', 'type' => 'swasta', 'city' => 'Surakarta', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.ums.ac.id'],
            ['name' => 'Universitas Muhammadiyah Jakarta', 'acronym' => 'UMJ', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.umj.ac.id'],
            ['name' => 'Universitas Islam Negeri Syarif Hidayatullah', 'acronym' => 'UIN Jakarta', 'type' => 'negeri', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.uinjkt.ac.id'],
            ['name' => 'Universitas Islam Negeri Sunan Kalijaga', 'acronym' => 'UIN Yogyakarta', 'type' => 'negeri', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.uin-suka.ac.id'],
            ['name' => 'Universitas Islam Negeri Maulana Malik Ibrahim', 'acronym' => 'UIN Malang', 'type' => 'negeri', 'city' => 'Malang', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.uin-malang.ac.id'],
            ['name' => 'Universitas Katolik Indonesia Atma Jaya', 'acronym' => 'Unika Atma Jaya', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.atmajaya.ac.id'],
            ['name' => 'Universitas Katolik Parahyangan', 'acronym' => 'UNPAR', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.unpar.ac.id'],
            ['name' => 'Universitas Katolik Soegijapranata', 'acronym' => 'UNIKA', 'type' => 'swasta', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.unika.ac.id'],
            ['name' => 'Universitas Surabaya', 'acronym' => 'UBAYA', 'type' => 'swasta', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.ubaya.ac.id'],
            ['name' => 'Universitas Ciputra', 'acronym' => 'UC', 'type' => 'swasta', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.ciputra.ac.id'],
            ['name' => 'Universitas Widya Mandala', 'acronym' => 'UWM', 'type' => 'swasta', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.widyamandala.ac.id'],
            ['name' => 'Universitas Dian Nuswantoro', 'acronym' => 'UDINUS', 'type' => 'swasta', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.dinus.ac.id'],
            ['name' => 'Universitas Semarang', 'acronym' => 'USM', 'type' => 'swasta', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.usm.ac.id'],
            ['name' => 'Universitas Stikubank', 'acronym' => 'UNISBANK', 'type' => 'swasta', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.unisbank.ac.id'],
            ['name' => 'Universitas Islam Bandung', 'acronym' => 'UNISBA', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.unisba.ac.id'],
            ['name' => 'Universitas Pasundan', 'acronym' => 'UNPAS', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.unpas.ac.id'],
            ['name' => 'Universitas Widyatama', 'acronym' => 'UW', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.widyatama.ac.id'],
            ['name' => 'Universitas Komputer Indonesia', 'acronym' => 'UNIKOM', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.unikom.ac.id'],
            ['name' => 'Universitas Maranatha', 'acronym' => 'UM', 'type' => 'swasta', 'city' => 'Bandung', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.maranatha.edu'],
            ['name' => 'Universitas Swadaya Gunung Jati', 'acronym' => 'USGJ', 'type' => 'swasta', 'city' => 'Cirebon', 'province' => 'Jawa Barat', 'logo_url' => null, 'website' => 'https://www.usgj.ac.id'],
            ['name' => 'Universitas Pancasila', 'acronym' => 'UP', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.univpancasila.ac.id'],
            ['name' => 'Universitas Pancasakti Tegal', 'acronym' => 'UPST', 'type' => 'swasta', 'city' => 'Tegal', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.upstegal.ac.id'],
            ['name' => 'Universitas Muhammadiyah Prof. Dr. Hamka', 'acronym' => 'UHAMKA', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.uhamka.ac.id'],
            ['name' => 'Universitas Al Azhar Indonesia', 'acronym' => 'UAI', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.alazhar.ac.id'],
            ['name' => 'Universitas Nasional', 'acronym' => 'UNAS', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.unas.ac.id'],
            ['name' => 'Universitas Persada Indonesia YAI', 'acronym' => 'YAI', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.yai.ac.id'],
            ['name' => 'Universitas Borobudur', 'acronym' => 'UB', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.borobudur.ac.id'],
            ['name' => 'Universitas Budi Luhur', 'acronym' => 'UBL', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.budiluhur.ac.id'],
            ['name' => 'Universitas Yarsi', 'acronym' => 'UY', 'type' => 'swasta', 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'logo_url' => null, 'website' => 'https://www.yarsi.ac.id'],
            ['name' => 'Universitas Mercu Buana Yogyakarta', 'acronym' => 'UMBY', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.mercubuana-yogya.ac.id'],
            ['name' => 'Universitas Sanata Dharma', 'acronym' => 'USD', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.usd.ac.id'],
            ['name' => 'Universitas Ahmad Dahlan', 'acronym' => 'UAD', 'type' => 'swasta', 'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta', 'logo_url' => null, 'website' => 'https://www.uad.ac.id'],
            ['name' => 'Universitas Islam Negeri Sunan Ampel', 'acronym' => 'UIN Surabaya', 'type' => 'negeri', 'city' => 'Surabaya', 'province' => 'Jawa Timur', 'logo_url' => null, 'website' => 'https://www.uinsby.ac.id'],
            ['name' => 'Universitas Islam Negeri Raden Intan', 'acronym' => 'UIN Lampung', 'type' => 'negeri', 'city' => 'Bandar Lampung', 'province' => 'Lampung', 'logo_url' => null, 'website' => 'https://www.radenintan.ac.id'],
            ['name' => 'Universitas Islam Negeri Ar-Raniry', 'acronym' => 'UIN Aceh', 'type' => 'negeri', 'city' => 'Banda Aceh', 'province' => 'Aceh', 'logo_url' => null, 'website' => 'https://www.ar-raniry.ac.id'],
            ['name' => 'Universitas Islam Negeri Sumatera Utara', 'acronym' => 'UIN Medan', 'type' => 'negeri', 'city' => 'Medan', 'province' => 'Sumatera Utara', 'logo_url' => null, 'website' => 'https://www.uinsu.ac.id'],
            ['name' => 'Universitas Islam Negeri Sultan Syarif Kasim', 'acronym' => 'UIN Pekanbaru', 'type' => 'negeri', 'city' => 'Pekanbaru', 'province' => 'Riau', 'logo_url' => null, 'website' => 'https://www.uin-suska.ac.id'],
            ['name' => 'Universitas Islam Negeri Antasari', 'acronym' => 'UIN Banjarmasin', 'type' => 'negeri', 'city' => 'Banjarmasin', 'province' => 'Kalimantan Selatan', 'logo_url' => null, 'website' => 'https://www.uin-antasari.ac.id'],
            ['name' => 'Universitas Islam Negeri Alauddin', 'acronym' => 'UIN Makassar', 'type' => 'negeri', 'city' => 'Makassar', 'province' => 'Sulawesi Selatan', 'logo_url' => null, 'website' => 'https://www.uin-alauddin.ac.id'],
            ['name' => 'Universitas Islam Negeri Mataram', 'acronym' => 'UIN Mataram', 'type' => 'negeri', 'city' => 'Mataram', 'province' => 'Nusa Tenggara Barat', 'logo_url' => null, 'website' => 'https://www.uinmataram.ac.id'],
            ['name' => 'Universitas Islam Negeri Walisongo', 'acronym' => 'UIN Semarang', 'type' => 'negeri', 'city' => 'Semarang', 'province' => 'Jawa Tengah', 'logo_url' => null, 'website' => 'https://www.walisongo.ac.id'],
            ['name' => 'Universitas Islam Negeri Raden Fatah', 'acronym' => 'UIN Palembang', 'type' => 'negeri', 'city' => 'Palembang', 'province' => 'Sumatera Selatan', 'logo_url' => null, 'website' => 'https://www.radenfatah.ac.id'],
        ];

        foreach ($universities as $university) {
            University::updateOrCreate(
                ['name' => $university['name']],
                $university
            );
        }

        // Seed Banks
        $banks = [
            ['name' => 'Bank Central Asia', 'code' => '014', 'logo_url' => null, 'swift_code' => 'CENAIDJA', 'is_active' => true],
            ['name' => 'Bank Mandiri', 'code' => '008', 'logo_url' => null, 'swift_code' => 'BMRIIDJA', 'is_active' => true],
            ['name' => 'Bank Negara Indonesia', 'code' => '009', 'logo_url' => null, 'swift_code' => 'BNINIDJA', 'is_active' => true],
            ['name' => 'Bank Rakyat Indonesia', 'code' => '002', 'logo_url' => null, 'swift_code' => 'BRINIDJA', 'is_active' => true],
            ['name' => 'Bank Tabungan Negara', 'code' => '200', 'logo_url' => null, 'swift_code' => 'BTANIDJA', 'is_active' => true],
            ['name' => 'Bank CIMB Niaga', 'code' => '022', 'logo_url' => null, 'swift_code' => 'BNIAIDJA', 'is_active' => true],
            ['name' => 'Bank Danamon', 'code' => '011', 'logo_url' => null, 'swift_code' => 'BDMNIDJA', 'is_active' => true],
            ['name' => 'Bank OCBC NISP', 'code' => '028', 'logo_url' => null, 'swift_code' => 'NISPIDJA', 'is_active' => true],
            ['name' => 'Bank Permata', 'code' => '013', 'logo_url' => null, 'swift_code' => 'BBBAIDJA', 'is_active' => true],
            ['name' => 'Bank Maybank Indonesia', 'code' => '016', 'logo_url' => null, 'swift_code' => 'AYBKIDJA', 'is_active' => true],
            ['name' => 'Bank UOB Indonesia', 'code' => '023', 'logo_url' => null, 'swift_code' => 'UOBBIDJA', 'is_active' => true],
            ['name' => 'Bank HSBC Indonesia', 'code' => '087', 'logo_url' => null, 'swift_code' => 'HSBCIDJA', 'is_active' => true],
            ['name' => 'Bank DBS Indonesia', 'code' => '046', 'logo_url' => null, 'swift_code' => 'DBSSIDJA', 'is_active' => true],
            ['name' => 'Bank BTPN', 'code' => '213', 'logo_url' => null, 'swift_code' => 'BTPNIDJA', 'is_active' => true],
            ['name' => 'Bank Jago', 'code' => '542', 'logo_url' => null, 'swift_code' => null, 'is_active' => true],
            ['name' => 'Bank BCA Syariah', 'code' => '536', 'logo_url' => null, 'swift_code' => null, 'is_active' => true],
            ['name' => 'Bank BRI Syariah', 'code' => '422', 'logo_url' => null, 'swift_code' => null, 'is_active' => true],
            ['name' => 'Bank BNI Syariah', 'code' => '427', 'logo_url' => null, 'swift_code' => null, 'is_active' => true],
            ['name' => 'Bank Muamalat', 'code' => '147', 'logo_url' => null, 'swift_code' => 'MUABIDJA', 'is_active' => true],
            ['name' => 'Bank Mega', 'code' => '426', 'logo_url' => null, 'swift_code' => 'MEGAIDJA', 'is_active' => true],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['name' => $bank['name']],
                $bank
            );
        }
    }
}
