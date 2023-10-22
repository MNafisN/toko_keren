<template>
    <div class="bg-white fixed w-full">
        <div class="bg-[rgba(0,47,52,0.03)] w-full h-16 pl-8 flex items-center gap-4">
            <div @click="goToHome" class="i-arrow-left"></div>
            <span class="text-xl lg:hidden">Pasang iklan anda</span>
        </div>
    </div>
    <div class="h-16"></div>
    <div class="bg-white sm:flex sm:items-center sm:flex-col">
        <span class="hidden lg:block text-2xl font-bold py-4">PASANG IKLAN ANDA</span>
        <div class="sm:w-5/6 lg:w-2/3 sm:border sm:border-slate-400">
            <h2 class="font-bold text-xl text-center py-3">PILIH KATEGORI</h2>
            <ul class="w-full flex flex-wrap">
                <li
                    @click="goToPostForm('mobil')"
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-r border-slate-400">
                    <div class="i-mobil"></div>
                    <p class="text-sm text-center w-4/5 font-bold">MOBIL</p>
                </li>
                <li class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center">
                    <div class="i-properti"></div>
                    <p class="text-sm text-center w-4/5 font-bold">PROPERTI</p>
                </li>
                <li
                    @click="goToPostForm('motor')"
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-motor"></div>
                    <p class="text-sm text-center w-4/5 font-bold">MOTOR</p>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-mobil"></div>
                    <p class="text-sm text-center w-4/5 font-bold">JASA & LOWONGAN KERJA</p>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-elektronik"></div>
                    <p class="text-sm text-center w-4/5 font-bold">ELEKTRONIK & GADGET</p>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-hobi"></div>
                    <p class="text-sm text-center w-4/5 font-bold">HOBI & OLAHRAGA</p>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-perabotan"></div>
                    <p class="text-sm text-center w-4/5 font-bold">RUMAH TANGGA</p>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-lainnya"></div>
                    <p class="text-sm text-center w-4/5 font-bold">OPSI LAINNYA</p>
                </li>
            </ul>
        </div>
    </div>
    <Footer />
</template>
<script>
import Footer from '../components/Footer.vue';

export default {
    name: 'post-category',
    components: {
        Footer
    },
    methods: {
        goToPostForm(category) {
            this.$router.push('/app/post/' + category)
        },
        goToHome() {
            this.$router.push('/app')
        }
    }
}
</script>