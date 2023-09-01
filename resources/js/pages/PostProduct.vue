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
                <span
                    @click="goToPostCategory"
                    class="text-sm font-bold underline"
                    >Ubah</span
                >
            </div>
        </div>
        <div class="p-4 border-b">
            <p class="text-xl font-bold mb-3">SERTAKAN BEBERAPA DETAIL</p>
            <form>
                <Input
                    @send-value="(value) => inputValue('merek', value)"
                    id="merk"
                    type="select"
                    :list="merekMobil"
                    label="Merek"
                    required
                />
                <br />
                <Input
                    v-if="produk.merek"
                    @send-value="(value) => inputValue('model', value)"
                    id="model"
                    type="select"
                    :list="model"
                    label="Model"
                    required
                />
                <br v-if="produk.merek" />
                <Input
                    v-if="produk.model"
                    @send-value="(value) => inputValue('tipe_transmisi', value)"
                    id="transmisi"
                    type="select"
                    :list="tipeTransmisi"
                    label="Transmisi"
                    required
                />
                <br v-if="produk.model" />
                <Input
                    @send-value="(value) => inputValue('tahun_keluaran', value)"
                    id="tahun"
                    type="select"
                    :list="tahun"
                    label="Tahun"
                    required
                />
                <br />
                <Input
                    @send-value="(value) => inputValue('jarak_tempuh', value)"
                    id="jarak"
                    type="select"
                    :list="jarakTempuh"
                    label="Jarak Tempuh"
                    required
                />
                <br />
                <Input
                    @send-value="
                        (value) => inputValue('tipe_bahan_bakar', value)
                    "
                    id="bahanBakar"
                    type="radio"
                    :list="bahanBakar"
                    label="Tipe bahan bakar"
                    required
                />
                <br />
                <Input
                    @send-value="(value) => inputValue('warna', value)"
                    id="warna"
                    type="select"
                    :list="warna"
                    label="Warna"
                    required
                />
                <br />
                <Input
                    @send-value="(value) => inputValue('tipe_bodi', value)"
                    id="tipeMobil"
                    type="select"
                    :list="tipeMobil"
                    label="Tipe bodi"
                />
                <br />
                <Input
                    @send-value="
                        (value) => inputValue('kapasitas_mesin', value)
                    "
                    id="ccMobil"
                    type="radio"
                    :list="ccMobil"
                    label="Kapasitas mesin"
                />
                <br />
                <Input
                    @send-value="(value) => inputValue('tipe_penjual', value)"
                    id="penjual"
                    type="radio"
                    :list="tipePenjual"
                    label="Tipe penjual"
                />
                <br />
                <!-- <Input @send-value="value => inputValue('', value)" id="bursaMobil" type="select" :list="bursaMobil" label="Nama Bursa Mobil" /> -->
                <!-- <br> -->
                <Input
                    @send-value="(value) => inputValue('produk_judul', value)"
                    id="judul"
                    type="text"
                    label="Judul iklan"
                    foot-note="Sebutkan fitur utama dari barang Anda (misal merek, model, umur, jenis)"
                    :max="70"
                    required
                />
                <br />
                <Input
                    @send-value="
                        (value) => inputValue('produk_deskripsi', value)
                    "
                    id="deskripsi"
                    type="textarea"
                    label="Deskripsi"
                    foot-note="Sertakan kondisi, fitur, dan alasan penjualan"
                    :max="4096"
                    required
                />
                <br />
            </form>
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">TENTUKAN HARGA</p>
            <Input
                @send-value="(value) => inputValue('harga', value)"
                id="harga"
                type="price"
                label="Harga"
                required
            />
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">UNGGAH HINGGA 20 FOTO</p>
            <div class="w-full flex flex-wrap gap-2">
                <UploadImage
                    v-for="i in 20"
                    :disabled="i > previewImage.length + 1"
                    :index="i"
                    :preview="previewImage[i - 1]"
                    @send-value="(file) => inputFile(file, i-1)"
                />
            </div>
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">
                KONFIRMASIKAN LOKASI IKLAN ANDA
            </p>
            <div class="w-full">
                <Input
                    @send-value="
                        (value) => {inputValue('lokasi_provinsi', value); selectProvinsi(value)}
                    "
                    id="provinsi"
                    type="select"
                    label="Wilayah"
                    :list="wilayah.provinsi"
                    required
                />
                <br />
                <Input
                    v-if="produk.lokasi_provinsi"
                    @send-value="
                        (value) => {inputValue('lokasi_kabupaten_kota', value); selectKota(value)}
                    "
                    id="kota"
                    type="select"
                    label="Kota"
                    :list="wilayah.kabupatenKota"
                    required
                />
                <br v-if="produk.lokasi_provinsi" />
                <Input
                    v-if="produk.lokasi_kabupaten_kota"
                    @send-value="
                        (value) => inputValue('lokasi_kecamatan', value)
                    "
                    id="kecamatan"
                    type="select"
                    label="Kecamatan"
                    :list="wilayah.kecamatan"
                    required
                />
            </div>
        </div>
        <div class="px-4 py-8">
            <p class="text-xl font-bold mb-3">CEK KEMBALI DETAIL INFORMASI</p>
            <div class="w-full">
                <div class="w-full mb-4 flex gap-4">
                    <div
                        class="min-w-[96px] h-[96px] rounded-full overflow-hidden relative"
                    >
                        <img
                            class="w-full h-full object-fill"
                            src="/assets/avatar.png"
                            alt=""
                        />
                        <div
                            class="w-full h-1/3 bg-[rgba(0,0,0,0.5)] absolute bottom-0 flex justify-center p-1"
                        >
                            <div class="i-camera"></div>
                        </div>
                    </div>
                    <div class="w-full">
                        <Input
                            id="username"
                            type="text"
                            label="Nama"
                            max="30"
                            required
                        />
                    </div>
                </div>
                <br />
                <Input
                    id="telephone"
                    type="phone"
                    label="Nomor Handphone"
                    required
                />
            </div>
        </div>
    </div>
    <div class="px-4 py-8 mt-1 bg-white">
        <button
            @click="test"
            class="w-full h-11 rounded-md bg-buy-button text-white font-bold"
        >
            Pasang iklan sekarang
        </button>
    </div>
    <Footer />
</template>

<script>
import Input from "../components/Input.vue";
import UploadImage from "../components/UploadImage.vue";
import Footer from "../components/Footer.vue";
import InputPrice from "../components/InputPrice.vue";
import axios from "axios";

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
                "Lain-lain",
            ],
            model: [
                "model 1",
                "model 2",
                "model 3",
                "model 4",
                "model 5",
                "model 6",
            ],
            tipeTransmisi: ["manual", "automatic"],
            tahun: [
                2023, 2022, 2021, 2020, 2019, 2018, 2017, 2016, 2015, 2014,
                2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006, 2005, 2004,
                2003, 2002, 2001, 2000, 1999, 1998, 1997, 1996, 1995, 1994,
                1993, 1992, 1991, 1990, 1989, 1988, 1987,
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
            bahanBakar: ["diesel", "bensin", "hybrid", "listrik"],
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
                "Lainnya",
            ],
            tipeMobil: [
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
                "Bus",
            ],
            ccMobil: [
                "<1.000 cc",
                ">1.000 - 1.500 cc",
                ">1.500 - 2.000 cc",
                ">2.000 - 3.000 cc",
                ">3.000 cc",
            ],
            tipePenjual: ["individu", "dealer"],
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
                "Pasar Mobil Kemayoran",
            ],
            wilayah: {
                provinsi: [],
                kabupatenKota: [],
                kecamatan: [],
            },
            produk: {
                produk_judul: "",
                produk_deskripsi: "",
                produk_foto: [
                    {
                        file_name: "foto_produk.jpg"
                    }
                ],
                produk_kategori: "",
                merek: "",
                model: "",
                tahun_keluaran: "",
                jarak_tempuh: "",
                warna: "",
                kapasitas_mesin: "",
                kapasitas_penumpang: "2",
                tipe_transmisi: "",
                tipe_bodi: "",
                tipe_bahan_bakar: "",
                tipe_penjual: "",
                harga: 0,
                lokasi_provinsi: "",
                lokasi_kabupaten_kota: "",
                lokasi_kecamatan: "",
                produk_pemasang: "irfan",
                no_telepon: "+6288232516796",
                tampilkan_telepon: false,
            },
            previewImage: [],
        };
    },
    components: {
        Input,
        UploadImage,
        Footer,
        InputPrice,
    },
    computed: {
        postCategory() {
            return this.$route.params.category;
        },
    },
    methods: {
        goToPostCategory() {
            this.$router.push("/app/post");
        },
        inputValue(key, value) {
            this.produk[key] = value;
        },
        inputFile(file, index) {
            if (this.previewImage.length > index) {
                this.produk.produk_foto[index] = {
                    file_name: file.name
                }
                this.previewImage[index] = file.preview
            } else {
                this.produk.produk_foto.push({
                    file_name: file.name,
                });
                this.previewImage.push(file.preview);
            }
        },
        selectProvinsi(value) {
            axios
                .get('/api/indonesia/kab_kota/'+value)
                .then((res)=>{
                    const arr = []
                    res.data.data.forEach((obj)=> {
                        arr.push(obj.name)
                    })
                    this.wilayah.kabupatenKota = arr
                })
        },
        selectKota(value) {
            axios
                .get('/api/indonesia/kecamatan/'+value)
                .then((res)=>{
                    const arr = []
                    res.data.data.forEach((obj)=> {
                        arr.push(obj.name)
                    })
                    this.wilayah.kecamatan = arr
                })
        },
        test() {
            console.log(this.produk)
            axios
                .post('/api/produk', this.produk)
                .then((res)=> console.log(res))
                .catch((err)=>console.log(err))
        }
    },
    mounted() {
        this.produk.produk_kategori = this.postCategory

        axios
            .get('/api/indonesia/provinsi')
            .then((res)=> {
                console.log(res.data.data)
                const data = res.data.data
                const arr = []
                data.forEach((obj)=>{
                    arr.push(obj.name)
                })
                this.wilayah.provinsi = arr
            })
    }
};
</script>
