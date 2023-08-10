<template>
    <div class="bg-white h-screen">
        <div class="relative">
            <div class="i-x absolute top-3 right-3"></div>
        </div>
        <br>
        <br>
        <h1 class="font-extrabold text-3xl text-center">Fake Olx</h1>
        <p class="text-xl text-center mt-4">Masuk Ke Akun Anda</p>
        <div class="p-5">
            <form>
                <input type="text"
                placeholder="Email"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                >
                <input type="password"
                placeholder="Password"
                class="w-full h-11 rounded-md border border-subTitle p-2 mb-5"
                >
                <button type="submit" class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Masuk</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: "login-page"
}
</script>