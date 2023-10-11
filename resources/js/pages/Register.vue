<template>
    <div class="bg-white h-screen">
        <div class="relative">
            <RouterLink to="/app/login">
                <div class="i-x absolute top-3 right-3"></div>
            </RouterLink>
        </div>
        <br />
        <br />
        <h1 class="font-extrabold text-3xl text-center">Fake Olx</h1>
        <p class="text-xl text-center mt-4">{{ isLogged ? 'Lengkapi Profile Anda' : 'Buat Akun Baru' }}</p>
        <div v-if="!isLogged" class="p-5">
            <input
                type="text"
                :value="email"
                @input="(e) => (email = e.target.value)"
                placeholder="Email"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
            />
            <input
                type="password"
                :value="password"
                @input="(e) => (password = e.target.value)"
                placeholder="Password"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
            />
            <input
                type="password"
                :value="confirmPassword"
                @input="(e) => (confirmPassword = e.target.value)"
                placeholder="Confirm Password"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
            />
            <button
                @click="handleSubmit"
                type="submit"
                class="w-full h-11 rounded-md bg-buy-button text-white font-bold"
            >
                Daftar
            </button>
        </div>
        <div v-else class="p-5">
            <ProfilePicture page="register" />
            <input
                type="text"
                placeholder="Nama Lengkap"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                @input="(e) => inputValue('full_name', e.target.value)"
            />
            <textarea
                placeholder="Bio Anda"
                class="w-full h-textarea border border-subTitle rounded-md p-2 mb-3 resize-none"
                @input="(e) => inputValue('about', e.target.value)"
            ></textarea>
            <Input
                type="phone"
                placeholder="No Telepon"
                class="mb-5" 
                @send-value="(value) => inputValue('phone_number', value)"
                />
            <button
                class="w-full h-11 rounded-md bg-buy-button text-white font-bold"
                @click="updateProfile"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
import Input from "../components/Input.vue";
import ProfilePicture from "../components/ProfilePicture.vue";
import axios from "axios";
import Swal from "sweetalert2"

export default {
    name: "register-page",
    data() {
        return {
            email: "",
            password: "",
            confirmPassword: "",
            isLoading: false,
            isLogged: false,
            userData: {
                full_name: "",
                about: "",
                email: "",
                profile_picture: "",
                phone_number: "",
                username: "",
            }
        };
    },
    components: {
        Input,
        ProfilePicture
    },
    computed: {
        getUsername() {
            return this.$store.getters.getUsername
        }
    },
    methods: {
        inputValue(key, value) {
            this.userData[key] = value;
        },
        handleSubmit() {
            const ref = this;
            this.isLoading = true;
            if (this.password === this.confirmPassword) {
                const payload = {
                    email: this.email,
                    password: this.password,
                };
                axios.post("/api/user/register", payload)
                .then((res) => {
                    console.log(res.data);
                    ref.login(payload);
                })
                .catch((err) => {
                    console.log(err);
                });
            } else {
                console.log("password dan confirm password harus sama");
            }
        },
        login(payload) {
            const ref = this;
            axios.post("/api/user/login", payload)
            .then((res) => {
                localStorage.setItem("access_token", res.data.access_token);
                console.log(res.data);
                ref.getInfoUser();
                this.isLogged = true
            });
        },
        getInfoUser() {
            axios.get("/api/user/data").then((res) => {
                console.log(res.data.user_data);
                this.userData.username = res.data.user_data.username
                this.userData.email = res.data.user_data.email
                this.$store.commit("setUserData", res.data.user_data);
            });
        },
        updateProfile() {
            console.log(this.userData);
            const payload = {
                new_username: this.userData.username,
                full_name: this.userData.full_name,
                about: this.userData.about,
                phone_number: this.userData.phone_number
            }
            axios.put("/api/user/update", payload)
            .then((res) => {
                console.log(res.data);
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Info user berhasil diupdate",
                    timer: 2000,
                    showConfirmButton: false
                })
                .then(()=>this.$router.push("/app"))
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
        onkeydown(e) {
            const ref = this
            if (e.key === "Enter" && this.email && this.password && this.confirmPassword) {
                ref.handleSubmit()
            }
        },
    }, 
    mounted() {
        document.addEventListener("keydown", this.onkeydown);
    }
};
</script>

<style>
.h-textarea {
    height: 96px !important;
}
input:focus {
    outline: 1px solid black;
}
textarea:focus {
    outline: 1px solid black;
}
</style>
