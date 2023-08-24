<template>
    <div class="bg-white p-4 mt-2">
        <h1 class="text-xl font-bold mb-4">Detail</h1>
        <div class="grid grid-cols-2">
            <p class="text-sm h-7 text-subTitle">Merek</p>
            <p class="text-sm h-7">{{ data.merek }}</p>

            <p class="text-sm h-7 text-subTitle">Model</p>
            <p class="text-sm h-7">{{ data.model }}</p>

            <p class="text-sm h-7 text-subTitle">Tahun</p>
            <p class="h-7">{{ data.tahun_keluaran }}</p>

            <p class="text-sm h-7 text-subTitle">Jarak tempuh</p>
            <p class="text-sm h-7">{{ data.jarak_tempuh }}</p>

            <p class="text-sm h-7 text-subTitle">Tipe penjual</p>
            <p class="text-sm h-7">Individu</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'product_detail',
    props: {
        data: Object
    }
}
</script>