<template>
    <div class="bg-white fixed w-full">
        <div class="bg-[rgba(0,47,52,0.03)] w-full h-16 pl-8 flex items-center gap-4">
            <div class="i-arrow-left"></div>
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
                    <P class="text-sm text-center w-4/5 font-bold">MOBIL</P>
                </li>
                <li class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center">
                    <div class="i-properti"></div>
                    <P class="text-sm text-center w-4/5 font-bold">PROPERTI</P>
                </li>
                <li
                    @click="goToPostForm('motor')"
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-motor"></div>
                    <P class="text-sm text-center w-4/5 font-bold">MOTOR</P>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-mobil"></div>
                    <P class="text-sm text-center w-4/5 font-bold">JASA & LOWONGAN KERJA</P>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-elektronik"></div>
                    <P class="text-sm text-center w-4/5 font-bold">ELEKTRONIK & GADGET</P>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-hobi"></div>
                    <P class="text-sm text-center w-4/5 font-bold">HOBI & OLAHRAGA</P>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-r border-slate-400">
                    <div class="i-perabotan"></div>
                    <P class="text-sm text-center w-4/5 font-bold">RUMAH TANGGA</P>
                </li>
                <li
                    class="w-1/2 h-[125px] box-border flex flex-col gap-4 justify-center items-center border-t border-slate-400">
                    <div class="i-lainnya"></div>
                    <P class="text-sm text-center w-4/5 font-bold">OPSI LAINNYA</P>
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
        }
    }
}
</script>