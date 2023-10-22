<template>
    <div class="mt-2 py-2 bg-white">
        <div class="w-full flex justify-between px-5">
            <span>Telusuri kategori</span>
            <!-- <span class="underline font-semibold">Lihat semua</span> -->
        </div>
        <div class="w-full overflow-x-auto">
            <div class="w-max flex">
                <div @click="goTo('mobil')" class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/mobil.png" alt="">
                    <p class="text-center text-xs">MOBIL</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/properti.png" alt="">
                    <p class="text-center text-xs">PROPERTI</p>
                </div>
                <div @click="goTo('motor')" class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/motor.png" alt="">
                    <p class="text-center text-xs">MOTOR</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/properti.png" alt="">
                    <p class="text-center text-xs">JASA & LOWONGAN</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/elektronik&gadget.png" alt="">
                    <p class="text-center text-xs">ELEKTRONIK & GADGET</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/hobi&olah-raga.png" alt="">
                    <p class="text-center text-xs">HOBI & OLAHRAGA</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/rumah-tangga.png" alt="">
                    <p class="text-center text-xs">RUMAH TANGGA</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/keperluan-pribadi.png" alt="">
                    <p class="text-center text-xs">KEPERLUAN PRIBADI</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/perlengkapan-bayi&anak.png" alt="">
                    <p class="text-center text-xs">PERLENGKAPA BAYI & ANAK</p>
                </div>
                <div class="w-[28.57vw] sm:w-[20vw] lg:w-[18vw] bg-white my-3">
                    <img class="w-12 h-12 mx-auto" src="/assets/kantor&industri.png" alt="">
                    <p class="text-center text-xs">KANTOR & INDUSTRI</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'list-category',
    methods: {
        goTo(category) {
            this.$router.push('/app/category/'+category)
        }
    }
}
</script>