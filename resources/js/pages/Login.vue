<template>
    <div class="bg-white h-screen">
        <div class="relative">
            <RouterLink to="/app">
                <div class="i-x absolute top-3 right-3"></div>
            </RouterLink>
        </div>
        <br />
        <br />
        <h1 class="font-extrabold text-3xl text-center">Fake Olx</h1>
        <p class="text-xl text-center mt-4">Masuk Ke Akun Anda</p>
        <div class="p-5">
                <input
                    type="text"
                    placeholder="Email"
                    :value="email"
                    @input="e=>email = e.target.value"
                    class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                />
                <input
                    type="password"
                    placeholder="Password"
                    :value="password"
                    @input="e=>password = e.target.value"
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
</template>
<script>
import axios from 'axios';

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
        handleSubmit() {
            this.isLoading = true;
            const payload = {
                email: this.email,
                password: this.password,
            };

            axios
                .post('/api/user/login', payload)
                .then((res)=> {
                    this.isLoading = false
                    localStorage.setItem('access_token', res.data.access_token)
                    console.log(res.data)
                    this.$router.push('/app')
                })
                .catch((err)=>{
                    this.isLoading = false
                    console.log(err)
                })
        },
    },
};
</script>
