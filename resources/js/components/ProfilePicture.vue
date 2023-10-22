<template>
    <label for="changePicture">
        <div :class="`rounded-full overflow-hidden relative ${page === 'register' ? 'min-w-[120px] w-[120px] h-[120px] mx-auto mb-4' : 'min-w-[96px] w-[96px] h-[96px]'}`">
            <div
                v-if="alias"
                class="w-full h-full bg-blue-500 flex justify-center items-center text-5xl text-white"
            >
                {{ alias }}
            </div>
            <img
                v-else
                class="w-full h-full object-cover"
                :src="'/api/user/download_photo/' + username"
                alt="profile_picture"
            />
            <div class="w-full h-1/3 bg-[rgba(0,0,0,0.5)] absolute bottom-0 flex justify-center p-1">
                <div class="i-camera"></div>
            </div>
            <div
                v-if="isLoading"
                class="absolute top-0 w-full h-full flex justify-center items-center"
            >
                <div class="loader"></div>
            </div>
        </div>
    </label>
    <input
        type="file"
        id="changePicture"
        accept="image/*"
        class="hidden"
        @input="(e) => selectImage(e.target.files[0])"
    />
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import Compressor from 'compressorjs'

export default {
    name: "profile-picture",
    data() {
        return {
            isLoading: false,
            refresh: false
        }
    },
    props: {
        page: String
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData
        },
        username() {
            return this.$store.getters.getUsername
        },
        alias() {
            if (this.userData.profile_picture && !this.refresh) {
                return false
            } else {
                return this.username.split("")[0]
            }
        }
    },
    methods: {
        selectImage(file) {
            this.isLoading = true;
            const ref = this;

            // compress image
            new Compressor(file, {
                quality: 0.5,
                success(result) {
                    ref.uploadImage(result);
                },
                error(err) {
                    console.log("error compress file / file tidak valid");
                    this.isLoading = false;
                },
            });
        },
        uploadImage(file) {
            // upload image
            const formData = new FormData();
            formData.append("profile_picture", file, file.name);
            axios.post("/api/user/upload_photo", formData)
            .then((res) => {
                console.log(res.data);
                this.refresh = true
                this.isLoading = false;
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Foto profile berhasil dirubah",
                    timer: 2000,
                    showConfirmButton: false
                })
                .then(()=>this.refresh = false)
            })
            .catch((err) => {
                console.log(
                    "error upload image / ada masalah di jaringan anda"
                );
                console.log(err);
                this.isLoading = false;
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: err.response.data.error.profile_picture[0],
                    timer: 2000,
                    showConfirmButton: false
                })
            });
        },
    }
}
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