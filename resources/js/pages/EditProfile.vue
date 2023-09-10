<template>
    <div class="bg-white min-h-screen">
        <Header />
        <div class="h-[52px]"></div>
        <div class="p-4">
            <h1 class="font-bold text-xl mb-4">Informasi Dasar</h1>
            <div class="w-full mb-4 flex gap-4">
                <!-- profile picture -->
                <label for="changePicture">
                    <div class="min-w-[96px] h-[96px] rounded-full overflow-hidden relative">
                        <img
                            v-if="userData.profile_picture"
                            class="w-full h-full object-fill"
                            src="/api/user/download_photo"
                            alt="profile_picture"
                        />
                        <div
                            v-else
                            class="w-full h-full bg-blue-500 flex justify-center items-center text-4xl text-white"
                        >I</div>
                        <div class="w-full h-1/3 bg-[rgba(0,0,0,0.5)] absolute bottom-0 flex justify-center p-1">
                            <div class="i-camera"></div>
                        </div>
                        <div v-if="isLoading" class="absolute top-0 w-full h-full flex justify-center items-center">
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
                <!-- /// profile picture /// -->

                <div class="w-full pt-3">
                    <Input
                        type="text"
                        id="fullName"
                        placeholder="Nama"
                        :init-value="userData.full_name"
                        :max="30"
                        @send-value="(value) => inputValue('fullName', value)"
                    />
                </div>
            </div>
            <div>
                <Input
                    type="textarea"
                    id="about"
                    placeholder="Tentang Saya (opsional)"
                    :init-value="userData.about"
                    :max="200"
                    @send-value="(value) => inputValue('about', value)"
                />
            </div>
        </div>
        <div class="h-[1px] w-full bg-subTitle"></div>
        <div class="p-4">
            <h1 class="font-bold text-xl mb-4">Informasi Kontak</h1>
            <Input
                type="phone"
                id="phone"
                placeholder="Masukan nomor HP"
                foot-note="ini adalah nomor untuk kontak pembeli, pengingat dan notifikasi lainnya"
                :init-value="userData.phone_number"
                @send-value="(value) => inputValue('phoneNumber', value)"
            />
            <br />
            <Input
                type="text"
                id="email"
                placeholder="Email"
                foot-note="Kami tidak akan mengungkapkan email Anda kepada orang lain atau menggunakannya untuk mengirim Anda spam"
                :init-value="userData.email"
                @send-value="(value) => inputValue('email', value)"
            />
        </div>
        <div class="fixed z-20 bottom-0 w-full p-4">
            <button
                @click="submit"
                class="w-full h-12 bg-buy-button text-white font-bold rounded"
            >
                Simpan Perubahan
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Header from "../components/Header.vue";
import Input from "../components/Input.vue";
import Compressor from "compressorjs";

export default {
    name: "edit-profile",
    data() {
        return {
            userData: {
                full_name: "",
                about: "",
                email: "",
                profile_picture: "",
                phone_number: "",
                username: "",
            },
            isLoading: false
        };
    },
    components: {
        Header,
        Input,
    },
    methods: {
        inputValue(key, value) {
            this.userData[key] = value;
        },
        selectImage(file) {
            this.isLoading = true
            const ref = this

            // compress image
            new Compressor(file, {
                quality: 0.5,
                success(result) {
                    ref.uploadImage(result);
                },
                error(err) {
                    console.log("error compress file / file tidak valid");
                    this.isLoading = false
                },
            });
        },
        uploadImage(file) {
            // upload image
            const formData = new FormData();
            formData.append("profile_picture", file);
            axios
                .post("/api/user/upload_photo", formData)
                .then((res) => {
                    console.log(res.data);
                    this.isLoading = false
                })
                .catch((err) => {
                    console.log("error upload image / ada masalah di jaringan anda");
                    console.log(err);
                    this.isLoading = false
                });
        },
        submit() {
            const data = {
                new_username: this.userData.username,
                full_name: this.userData.full_name,
                about: this.userData.about,
                phone_number: this.userData.phone_number,
            };
            axios
                .put("/api/user/update", data)
                .then((res) => {
                    console.log(res.data);
                    this.$router.push("/app");
                })
                .catch((err) => console.log(err));
        },
    },
    mounted() {
        axios
            .get("/api/user/data")
            .then((res) => {
                console.log(res.data);
                this.userData = res.data.user_data;
            })
            .catch((err) => console.log(err.data));
    },
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
