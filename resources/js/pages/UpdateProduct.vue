<template>
    <div class="bg-white fixed z-50 w-full">
        <div
            class="bg-[rgba(0,47,52,0.03)] w-full h-16 pl-8 flex items-center gap-4"
        >
            <div @click="" class="i-arrow-left"></div>
            <span class="text-xl lg:hidden">Update produk</span>
        </div>
    </div>
    <div class="h-16"></div>
    <div class="bg-white">
        <div class="p-4 border-b">
            <p class="text-xl font-bold mb-3">UPDATE DETAIL PRODUK</p>
            <Input
                @send-value="(value) => inputJudul(value)"
                id="judul"
                type="text"
                label="Judul iklan"
                :init-value="produk_judul"
                foot-note="Sebutkan fitur utama dari barang Anda (misal merek, model, umur, jenis)"
                :max="70"
                required
            />
            <br />
            <Input
                @send-value="(value) => inputDeskripsi(value)"
                id="deskripsi"
                type="textarea"
                label="Deskripsi"
                :init-value="produk_deskripsi"
                foot-note="Sertakan kondisi, fitur, dan alasan penjualan"
                :max="4096"
                required
            />
            <br />
            <Input
                @send-value="(value) => inputHarga(value)"
                id="harga"
                type="price"
                label="Harga"
                :init-value="harga"
                required
            />
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">UNGGAH HINGGA 20 FOTO</p>
            <div class="w-full flex flex-wrap gap-2">
                <UploadImage
                    v-for="i in 20"
                    :disabled="i > produk_foto.length + 1"
                    :index="i - 1"
                    :file-name="produk_foto[i - 1] ? produk_foto[i - 1].file_name : null"
                    @file-uploaded="(value) => UploadImage(value)"
                    @upload-failed="uploadFailed"
                />
            </div>
        </div>
    </div>
    <div class="px-4 py-8 mt-1 bg-white">
        <button
            @click="submit"
            :disabled="!validation"
            :class="`w-full h-11 rounded-md font-bold ${!validation ? 'bg-[#d8dfe0] text-[#7f9799]' : 'bg-buy-button text-white'}`"
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
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "update-product",
    data() {
        return {
            produk_judul: "",
            produk_deskripsi: "",
            produk_foto: [],
            harga: 0,
        };
    },
    components: {
        Input,
        UploadImage,
        Footer,
    },
    computed: {
        validation() {
            if(this.produk_judul && this.produk_deskripsi && this.produk_foto && this.harga) return true
        }
    },
    methods: {
        inputJudul(value) {
            this.produk_judul = value
        },
        inputDeskripsi(value) {
            this.produk_deskripsi = value
        },
        inputHarga(value) {
            this.harga = value
        },
        UploadImage(file, index) {
            if(this.produk_foto.length > index) {
                this.produk_foto[index].file_name = file
            } else {
                this.produk_foto.push({file_name: file})
            }
        },
        uploadFailed() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Gagal mengunggah foto",
                timer: 2000,
                showConfirmButton: false
            })
        },
        submit() {
            // tunggu api buat update
        }
    },
    mounted() {
        axios
            .get("/api/produk/detail/" + this.$route.params.id)
            .then((res) => {
                this.produk_judul = res.data.data.produk_judul;
                this.produk_deskripsi = res.data.data.produk_deskripsi;
                this.produk_foto = res.data.data.produk_foto.reduce((arr, obj)=>{return [...arr, {file_name: obj.file_name}]}, [])
                this.harga = res.data.data.harga;
                console.log(res.data.data);
            })
            .catch((err) => {
                console.log(err);
            });
    },
};
</script>
