<template>
    <div class="bg-white h-screen">
        <div class="relative">
            <RouterLink to="/app">
                <div class="i-x absolute top-3 right-3"></div>
            </RouterLink>
        </div>
        <br>
        <br>
        <h1 class="font-extrabold text-3xl text-center">Fake Olx</h1>
        <p class="text-xl text-center mt-4">Buat Akun Baru</p>
        <div class="p-5">
                <input type="text"
                :value="email"
                @input="e=> email = e.target.value"
                placeholder="Email"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                >
                <input type="password"
                :value="password"
                @input="e => password = e.target.value"
                placeholder="Password"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                >
                <input type="password"
                :value="confirmPassword"
                @input="e => confirmPassword = e.target.value"
                placeholder="Confirm Password"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5">
                <button @click="handleSubmit" type="submit" class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Daftar</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "register-page",
    data() {
        return {
            email: "",
            password: "",
            confirmPassword: "",
            isLoading: false
        }
    },
    methods: {
        handleSubmit() {
            this.isLoading = true
            if(this.password === this.confirmPassword) {
                const payload = {
                    email: this.email,
                    password: this.password
                }

                axios
                    .post('/api/user/register', payload)
                    .then((res)=> {
                        console.log(res.data)
                        this.$router.push('/app/login')
                    })
                    .catch((err)=> {
                        console.log(err)
                    })
            } else {
                console.log('password dan confirm password harus sama')
            }
        }
    }
}
</script>