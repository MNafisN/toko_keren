<template>
    <div class="bg-white fixed z-50 w-full">
        <div
            class="bg-[rgba(0,47,52,0.03)] w-full h-16 pl-8 flex items-center gap-4"
        >
            <div @click="backToProduct" class="i-arrow-left"></div>
            <span class="text-xl lg:hidden">Update produk</span>
        </div>
    </div>
    <div class="h-16"></div>
    <div class="bg-white">
        <div class="p-4 border-b">
            <p class="text-xl font-bold mb-3">UPDATE DETAIL PRODUK</p>
            <Input
                @send-value="(value) => inputValue('produk_judul', value)"
                id="judul"
                type="text"
                label="Judul iklan"
                :init-value="produk.produk_judul"
                foot-note="Sebutkan fitur utama dari barang Anda (misal merek, model, umur, jenis)"
                :max="70"
                required
            />
            <br />
            <Input
                @send-value="(value) => inputValue('produk_deskripsi', value)"
                id="deskripsi"
                type="textarea"
                label="Deskripsi"
                :init-value="produk.produk_deskripsi"
                foot-note="Sertakan kondisi, fitur, dan alasan penjualan"
                :max="4096"
                required
            />
            <br />
            <Input
                @send-value="(value) => inputValue('harga', value)"
                id="harga"
                type="price"
                label="Harga"
                :init-value="produk.harga"
                required
            />
        </div>
        <div class="px-4 py-8 border-b">
            <p class="text-xl font-bold mb-3">UNGGAH HINGGA 20 FOTO</p>
            <div class="w-full flex flex-wrap gap-2">
                <UploadImage
                    v-for="i in 20"
                    :disabled="i > produk.produk_foto.length + 1"
                    :index="i - 1"
                    :file-name="produk.produk_foto[i - 1] ? produk.produk_foto[i - 1].file_name : null"
                    :preview="foto[i-1] ? foto[i-1].preview : null"
                    @send-image="(payload)=> saveImage(payload)"
                    @delete-image="(index)=> deleteImage(index)"
                />
            </div>
        </div>
    </div>
    <div class="px-4 py-8 mt-1 bg-white">
        <button
            @click="submit"
            :disabled="!validation"
            :class="`w-full h-11 rounded-md font-bold ${
                !validation
                    ? 'bg-[#d8dfe0] text-[#7f9799]'
                    : 'bg-buy-button text-white'
            }`"
        >
            Update Iklan
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
import { updateProduct, uploadAllPhoto } from "../services/productServices";

export default {
    name: "update-product",
    data() {
        return {
            produk: {
                produk_judul: "",
                produk_deskripsi: "",
                produk_foto: [],
                harga: 0,
            },
            foto: []
        };
    },
    components: {
        Input,
        UploadImage,
        Footer,
    },
    computed: {
        validation() {
            if (
                this.produk.produk_judul &&
                this.produk.produk_deskripsi &&
                this.produk.produk_foto &&
                this.produk.harga
            )
                return true;
        },
    },
    methods: {
        inputValue(key, value) {
            this.produk[key] = value;
        },
        saveImage(payload) {
            this.foto.push(payload)
            this.produk.produk_foto.push(null)
        },
        deleteImage(index) {
            this.foto.splice(index, 1)
            this.produk.produk_foto.splice(index, 1)
        },
        submit() {
            const ref = this
            uploadAllPhoto(this.foto)
            .then((res)=> {
                for(let i = 0; i < res.length; i++) {
                    if(res[i]) this.produk.produk_foto[i] = res[i]
                }
                updateProduct(this.$route.params.id, this.produk)
                .then(()=>{
                    Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Produk berhasil diupdate",
                    timer: 2000,
                    showConfirmButton: false
                    })
                    .then(()=>this.$router.push("/app/product/"+this.$route.params.id))
                })
                .catch((err)=>{
                    console.log(err);
                    Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Produk gagal diupdate",
                    timer: 2000,
                    showConfirmButton: false
                    })
                })
            })
            .catch((err)=> console.log(err))
        },
        backToProduct() {
            this.$router.push("/app/product/"+ this.$route.params.id)
        }
    },
    mounted() {
        axios
            .get("/api/produk/detail/" + this.$route.params.id)
            .then((res) => {
                this.produk.produk_judul = res.data.data.produk_judul;
                this.produk.produk_deskripsi = res.data.data.produk_deskripsi;
                this.produk.produk_foto = res.data.data.produk_foto.reduce(
                    (arr, obj) => {
                        return [...arr, { file_name: obj.file_name }];
                    },
                    []
                );
                this.produk.harga = res.data.data.harga;
                res.data.data.produk_foto.forEach(()=> {
                    this.foto.push(null)
                })
                console.log(res.data.data);
                console.log(this.foto);
            })
            .catch((err) => {
                console.log(err);
            });
    },
};
</script>
