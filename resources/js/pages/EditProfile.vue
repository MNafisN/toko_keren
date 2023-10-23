<template>
    <div class="bg-white min-h-screen">
        <Header />
        <div class="h-[52px]"></div>
        <div class="p-4">
            <h1 class="font-bold text-xl mb-4">Informasi Dasar</h1>
            <div class="w-full mb-4 flex gap-4">
                <ProfilePicture />
                <div class="w-full pt-3">
                    <Input
                        type="text"
                        id="fullName"
                        placeholder="Nama"
                        :init-value="userData.full_name"
                        :max="30"
                        @send-value="(value) => inputValue('full_name', value)"
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
                @send-value="(value) => inputValue('phone_number', value)"
            />
            <br />
            <div class="relative">
                <Input
                    type="text"
                    id="email"
                    placeholder="Email"
                    foot-note="Kami tidak akan mengungkapkan email Anda kepada orang lain atau menggunakannya untuk mengirim Anda spam"
                    :init-value="userData.email"
                    disabled
                />
                <div @click="showAlert" class="i-edit-form absolute right-2 top-3"></div>
            </div>
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
import Swal from 'sweetalert2';
import ProfilePicture from "../components/ProfilePicture.vue";

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
            isLoading: false,
        };
    },
    components: {
        Header,
        Input,
        ProfilePicture
    },
    methods: {
        inputValue(key, value) {
            this.userData[key] = value;
        },
        submit() {
            console.log("submit");
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
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Info user berhasil diupdate",
                        timer: 2000,
                        showConfirmButton: false
                    })
                    .then(()=>this.$router.go())
                })
                .catch((err) => {
                    console.log(err);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Info user gagal diupdate"
                    })
                });
        },
        showAlert: async() => {
            const {value : formValue} = await Swal.fire({
                title: "Change Email",
                html: `
                <div class="flex flex-col items-start">
                    <label for="swal-input1">New Email</label>
                    <input id="swal-input1" type="email" placeholder="Email" class="w-full pl-2 h-12 border border-subTitle rounded-md mb-2">
                    <label for="swal-input2">Password</label>
                    <input id="swal-input2" type="password" placeholder="password" class="w-full pl-2 h-12 border border-subTitle rounded-md">
                </div>
                `,
                confirmButtonText: "Confirm",
                confirmButtonColor: "#002f34",
                preConfirm: function() {
                    const email = Swal.getPopup().querySelector('#swal-input1').value
                    const password = Swal.getPopup().querySelector('#swal-input2').value
                    if(!email || !password) {
                        Swal.showValidationMessage('Masukan input terlebih dahulu')
                    }
                    if(!email.split("@")[1]) {
                        Swal.showValidationMessage('Email tidak valid')
                    }
                    return {email, password}
                },
            })
            console.log(formValue)
            axios.put("/api/user/update_email", {
                password: formValue.password,
                new_email: formValue.email
            })
            .then(()=>{
                Swal.fire('Email berhasil diganti')
            })
            .catch((err)=>{
                Swal.fire(err.message)
            })
        }
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
