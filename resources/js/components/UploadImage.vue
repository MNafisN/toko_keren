<template>
    <div class="w-[100px] h-[100px] relative cursor-pointer">
        <!-- tombol hapus foto -->
        <div v-if="fileName" @click="deletePhoto" class="absolute top-1 right-1 w-7 h-7 rounded-full bg-buy-button flex justify-center items-center">
            <div class="i-hapus"></div>
        </div>

        <label :for="'foto' + index">
            <div :class="`w-full h-full border-2 ${disabled ? 'border-[#9dadb6]' : 'border-black'}`">
                <!-- jika ada fotonya -->
                <img v-if="preview || fileName"  :src="linkImg" alt="preview" class="w-full h-full object-contain" />

                <!-- jika tidak ada foto -->
                <div v-else class="h-full flex justify-center items-center flex-col gap-1">
                    <div :class="`${disabled ? 'i-camera-plus-disabled' : 'i-camera-plus'}`"></div>
                    <p v-if="!disabled" class="text-center text-sm leading-4">
                        Tambahkan Foto
                    </p>
                </div>

                <!-- loader -->
                <div v-if="isLoading" class="absolute top-0 w-full h-full flex justify-center items-center">
                    <div class="loader"></div>
                </div>
            </div>
        </label>
        <input
            type="file"
            accept="image/*"
            :id="'foto' + index"
            :disabled="disabled"
            @input="(e) => selectImage(e.target.files[0])"
            class="hidden"
        />
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: "upload-image",
    data() {
        return {
            isLoading: false,
            preview: ""
        }
    },
    props: {
        index: Number,
        disabled: Boolean,
        fileName: String
    },
    emits: ["fileUploaded", "uploadFailed", "fileDeleted"],
    methods: {
        selectImage (file) {
            // membuat preview image
            this.preview = URL.createObjectURL(file);

            // isLoading
            this.isLoading = true

            // upload image
            const formData = new FormData()
            formData.append("photo", file)
            axios
                .post('/api/produk/upload_photo', formData)
                .then((res)=>{
                    console.log(res.data.data)
                    this.$emit("fileUploaded", res.data.data.file_name)
                })
                .catch((err)=>{
                    console.log(err);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Gagal mengunggah foto",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                })
                .finally(()=>{
                    this.isLoading = false
                    this.preview = ""
                })
        },
        deletePhoto() {
            axios.delete("/api/produk/delete_photo/"+this.fileName)
            .then((res)=>{
                console.log(res.data)
                this.$emit("fileDeleted", this.index)
            })
            .catch((err)=>{
                console.log(err);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Sepertinya ada masalah pada jaringan anda",
                    timer: 2000,
                    showConfirmButton: false,    
                })
            })
        }
    },
    computed: {
        linkImg() {
            return this.preview ? this.preview : "/api/produk/download_photo/"+this.fileName
        }
    }
};
</script>

<style scoped>
.loader {
    border: 4px solid #ffffffc7;
    border-left-color: transparent;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    animation: spin89345 1s linear infinite;
}

@keyframes spin89345 {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
