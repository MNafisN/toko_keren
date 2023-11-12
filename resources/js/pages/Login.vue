<template>
    <div class="bg-white h-screen">
        <div class="relative">
            <div @click="goToHome" class="i-x absolute top-3 right-3"></div>
        </div>
        <br />
        <br />
        <div class="container mx-auto md:border md:w-[640px] md:py-4 md:rounded-lg">
            <h1 class="font-extrabold text-3xl text-center">Toko Keren</h1>
            <p class="text-xl text-center mt-4">Masuk Ke Akun Anda</p>
            <div class="p-5">
                <input
                    type="text"
                    placeholder="Email"
                    :value="email"
                    @input="(e) => (email = e.target.value)"
                    class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                />
                <input
                    type="password"
                    placeholder="Password"
                    :value="password"
                    @input="(e) => (password = e.target.value)"
                    class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                />
                <button
                    @click="handleSubmit"
                    type="submit"
                    class="w-full h-11 rounded-md bg-buy-button text-white font-bold"
                >
                    Masuk
                </button>
            </div>
            <p class="text-center">
                <RouterLink to="/app/register">Register</RouterLink>
            </p>
        </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
import { login, getInfoUser } from "../services/authServices";

export default {
    name: "login-page",
    data() {
        return {
            email: "",
            password: "",
            isLoading: false,
        };
    },
    methods: {
        goToHome() {
            this.$router.push("/app")
        },
        handleSubmit() {
            if (!this.email || !this.password) {
                Swal.fire("Masukan input terlebih dahulu");
                return;
            }
            if (!this.email.split("@")[1]) {
                Swal.fire("Format email salah");
                return;
            }
            this.isLoading = true;
            const payload = {
                email: this.email,
                password: this.password,
            };

            login(payload)
                .then((res) => {
                    this.isLoading = false;
                    localStorage.setItem("access_token", res.data.access_token);
                    this.getInfoUser();
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.log(err);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: err.response.data.error,
                    });
                });
        },
        getInfoUser() {
            this.$store.dispatch('pullUserData', "login")
        },
        onkeydown(e) {
            if (e.key === "Enter" && this.email && this.password) {
                this.handleSubmit();
            }
        },
    },
    mounted() {
        document.addEventListener("keydown", this.onkeydown);
    },
};
</script>
