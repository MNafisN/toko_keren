<template>
    <div class="bg-white fixed z-50 w-full">
        <div
            class="bg-[rgba(0,47,52,0.03)] w-full h-16 pl-8 flex items-center gap-4"
        >
            <div class="i-arrow-left"></div>
            <span class="text-xl lg:hidden">Pasang iklan anda</span>
        </div>
    </div>
    <div class="h-16"></div>
    <div class="bg-white">
        <div class="p-4 border-b">
            <p class="text-xl font-bold">KATEGORI TERPILIH</p>
            <br />
            <div class="flex justify-between items-center">
                <span class="text-xs text-subTitle">{{ postCategory }}</span>
                <span @click="goToPostCategory" class="text-sm font-bold underline">Ubah</span>
            </div>
        </div>
        <div class="p-4 border-b">
            <p class="text-xl font-bold mb-3">SERTAKAN BEBERAPA DETAIL</p>
            <form>
                <Input id="merk" type="select" :list="merekMobil" label="Merek" required />
                <br>
                <Input id="tahun" type="select" :list="tahun" label="Tahun" required />
                <br>
                <Input id="jarak" type="select" :list="jarakTempuh" label="Jarak Tempuh" required />
                <br>
                <Input id="bahanBakar" type="radio" :list="bahanBakar" label="Tipe bahan bakar" required />
                <br>
                <Input id="warna" type="select" :list="warna" label="Warna" required />
                <br>
                <Input id="typeMobil" type="select" :list="typeMobil" label="Tipe bodi" />
                <br>
                <Input id="ccMobil" type="radio" :list="ccMobil" label="Kapasitas mesin" />
                <br>
                <Input id="penjual" type="radio" :list="typePenjual" label="Tipe penjual" /> 
                <br>
                <Input id="bursaMobil" type="select" :list="bursaMobil" label="Nama Bursa Mobil" />
                <br>
                <Input id="judul" type="text" label="Judul iklan" foot-note="Sebutkan fitur utama dari barang Anda (misal merek, model, umur, jenis)" :max="70" required />
                <br>
                <Input id="deskripsi" type="textarea" label="Deskripsi" foot-note="Sertakan kondisi, fitur, dan alasan penjualan" :max="4096" required />  
                <br>
            </form>
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">TENTUKAN HARGA</p>
            <Input id="harga" type="price" label="Harga" required />
        </div>
        <div class="px-4 py-8">
            <p class="text-xl font-bold mb-3">UNGGAH HINGGA 20 FOTO</p>
            <div class="w-full flex flex-wrap gap-2">
                <UploadImage v-for="i in 20" :disabled="i !== 1" />
            </div>
        </div>
    </div>
    <div class="px-4 py-8 mt-1 bg-white">
        <button class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Pasang iklan sekarang</button>
    </div>
    <Footer />
</template>

<script>
import Input from "../components/Input.vue";
import UploadImage from "../components/UploadImage.vue";
import Footer from "../components/Footer.vue";

export default {
    name: "post-product",
    data() {
        return {
            merekMobil: [
                "MG",
                "Kancil",
                "Alfa Romeo",
                "Aston Martin",
                "Audi",
                "Bentley",
                "Bimantara",
                "BMW",
                "Cadillac",
                "Chery",
                "Chevrolet",
                "Chrysler",
                "Citroen",
                "Daewoo",
                "Daihatsu",
                "Datsun",
                "DFSK",
                "DFSK (Dongfeng Sokon)",
                "Dodge",
                "Ferrari",
                "Fiat",
                "Ford",
                "Foton",
                "Geely",
                "Hino",
                "Holden",
                "Honda",
                "Hummer",
                "hyundai",
                "Infiniti",
                "Isuzu",
                "Jaguar",
                "Jeep",
                "Kia",
                "Klasik dan Antik",
                "Lamborghini",
                "Land Rover",
                "Lexus",
                "Marvia",
                "Maserati",
                "Maxus",
                "Mazda",
                "Mercedes-Benz",
                "Mini",
                "Mini Cooper",
                "Mitsubishi",
                "Mobil CBU",
                "Nissan",
                "Oldsmobile",
                "Opel",
                "Peugeot",
                "Porsche",
                "Proton",
                "Renault",
                "Roll-Royce",
                "Rolls Royce",
                "Smart",
                "Ssang Yong",
                "SsangYong",
                "Subaru",
                "Suzuki",
                "Tata",
                "Tesla",
                "Timor",
                "Toyota",
                "UD TRUCKS",
                "Volkswagen",
                "Volvo",
                "Wuling",
                "Lain-lain"
            ],
            tahun: [
                2023,
                2022,
                2021,
                2020,
                2019,
                2018,
                2017,
                2016,
                2015,
                2014,
                2013,
                2012,
                2011,
                2010,
                2009,
                2008,
                2007,
                2006,
                2005,
                2004,
                2003,
                2002,
                2001,
                2000,
                1999,
                1998,
                1997,
                1996,
                1995,
                1994,
                1993,
                1992,
                1991,
                1990,
                1989,
                1988,
                1987
            ],
            jarakTempuh: [
                "0-5.000",
                "5.000-10.000",
                "10.000-15.000",
                "15.000-20.000",
                "20.000-25.000",
                "25.000-30.000",
                "30.000-35.000",
                "35.000-40.000",
                "40.000-45.000",
                "45.000-50.000",
                "50.000-55.000",
                "55.000-60.000",
                "60.000-65.000",
                "65.000-70.000",
                "70.000-75.000",
                "75.000-80.000",
                "80.000-85.000",
                "85.000-90.000",
                "90.000-95.000",
                "95.000-100.000",
                "100.000-105.000",
                "105.000-110.000",
                "110.000-115.000",
                "115.000-120.000",
                "120.000-125.000",
                "125.000-130.000",
                "130.000-135.000",
                "135.000-140.000",
                "140.000-145.000",
                "145.000-150.000",
                "150.000-155.000",
                "155.000-160.000",
                "160.000-165.000",
                "165.000-170.000",
                "170.000-175.000",
                "175.000-180.000",
                "180.000-185.000",
                "185.000-190.000",
                "190.000-195.000",
                "195.000-200.000",
                "200.000-205.000",
                "205.000-210.000",
                "210.000-215.000",
                "215.000-220.000",
                "220.000-225.000",
                "225.000-230.000",
                "230.000-235.000",
                "235.000-240.000",
                "240.000-245.000",
                "245.000-250.000",
                "250.000-255.000",
                "255.000-260.000",
                "260.000-265.000",
                "265.000-270.000",
                "270.000-275.000",
                "275.000-280.000",
                "280.000-285.000",
                "285.000-290.000",
                "290.000-295.000",
                "295.000-300.000",
            ],
            bahanBakar: [
                "Diesel",
                "Bensin",
                "Hybrid",
                "Listrik"
            ],
            warna: [
                "Hitam",
                "Biru",
                "Coklat",
                "Emas",
                "Abu-abu",
                "Silver",
                "Hijau",
                "Oranye",
                "Ungu",
                "Merah",
                "Putih",
                "Kuning",
                "Marun",
                "Lainnya"
            ],
            typeMobil: [
                "MPV",
                "SUV",
                "Hatchback",
                "Sedan",
                "Compact & City Car",
                "Van",
                "Minibus",
                "Pick-up",
                "Truk",
                "Double Cabin",
                "Wagon",
                "Coupe",
                "Jeep",
                "Convertible",
                "Offroad",
                "Sports & Super Car",
                "Classic Car",
                "Bus"
            ],
            ccMobil: [
                "<1.000 cc",
                ">1.000 - 1.500 cc",
                ">1.500 - 2.000 cc",
                ">2.000 - 3.000 cc",
                ">3.000 cc"
            ],
            typePenjual: [ "Individu", "Dealer" ],
            bursaMobil: [
                "Bursa AXC summarecon bekasi",
                "Bursa blok M Mall",
                "Bursa Citra Cikupa",
                "Bursa Gading Auto Center",
                "Bursa mobil Bella Tera",
                "Bursa Mobil BG Junction Surabaya",
                "Bursa Mobil Bintaro",
                "Bursa Mobil Blok M Plaza",
                "Bursa Mobil Blok M Square",
                "Bursa Mobil BSD",
                "Bursa Mobil DTC",
                "Bursa Mobil Karawaci",
                "Bursa Mobil Kelapa Gading",
                "Bursa Mobil Lenmarc Surabaya",
                "Bursa Mobil Mangga Dua Square",
                "Bursa Mobil MGK Kemayoran",
                "Bursa Mobil Permata Hijau",
                "Bursa Mobil POSH Bekasi",
                "Bursa Mobil Summarecon Serpong",
                "Bursa Mobil WTC Mangga Dua",
                "Bursa Otomotif Sunter",
                "Bursa Taman palem Cengkareng",
                "Carsentro Makassar",
                "Carsentro Semarang",
                "Carsentro Solo",
                "Carsentro Yogyakarta",
                "Pasar Mobil Kemayoran"
            ]
        };
    },
    components: {
        Input,
        UploadImage,
        Footer
    },
    computed: {
        postCategory() {
            this.$route.params.category
        }
    },
    methods: {
        goToPostCategory() {
            this.$router.push('/app/post')
        }
    }
};
</script>
