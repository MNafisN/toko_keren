<template>
    <div class="bg-white min-h-screen">
        <Header />
        <div class="h-[68px]"></div>
        <div class="p-4">
            <h1 class="font-bold text-xl mb-4">Informasi Dasar</h1>
            <div class="w-full mb-4 flex gap-4">
                <div class="min-w-[96px] h-[96px] rounded-full overflow-hidden relative">
                    <img class="w-full h-full object-fill" src="/assets/avatar.png" alt="">
                    <div class="w-full h-1/3 bg-[rgba(0,0,0,0.5)] absolute bottom-0 flex justify-center p-1">
                        <div class="i-camera"></div>
                    </div>
                </div>
                <div class="w-full">
                    <input type="text"
                    placeholder="Nama"
                    class="w-full h-12 p-2 rounded-md border border-subTitle mt-4">
                    <span class="text-left text-xs float-right">10/30</span>
                </div>
            </div>
            <div>
                <textarea class="w-full h-[78px] border border-subTitle rounded p-2" placeholder="Tentang Saya (opsional)"></textarea>
                <span class="float-right text-xs">0/200</span>
            </div>
        </div>
        <div class="h-[1px] w-full bg-subTitle"></div>
        <div class="p-4">
            <h1 class="font-bold text-xl mb-4">Informasi Kontak</h1>
            <div class="w-full h-12 rounded border border-subTitle flex items-center">
                <span class="px-3 border-r-2 text-[rgba(0,0,0,0.5)]">+62</span>
                <input type="number" class="w-full h-11 p-2" placeholder="Masukan nomor HP">
            </div>
            <p class="text-xs text-subTitle my-4">Ini adalah nomor untuk kontak pembeli, pengingat, dan notifikasi lainnya</p>
            <input type="email" class="w-full h-12 rounded border border-subTitle p-2" placeholder="Email">
            <p class="text-xs text-subTitle my-4">Kami tidak akan mengungkapkan email Anda kepada orang lain atau menggunakannya untuk mengirim Anda spam</p>
        </div>
        <div class="fixed z-20 bottom-0 w-full p-4">
            <button class="w-full h-12 bg-buy-button text-white font-bold rounded">Simpan Perubahan</button>
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue';
export default {
    name: 'edit-profile',
    components: {
        Header
    }
}
</script>