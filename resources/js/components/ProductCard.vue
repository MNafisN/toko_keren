<template>
    <div @click="goToDetailProduct" :class="`w-full shadow border rounded p-2`">
        <div class="h-[153px] min-w-[145px]">
            <img class="h-full w-full object-cover" :src="produk.produk_foto.length !== 0 ? '/api/produk/download_photo/'+produk.produk_foto[0].file_name : '/assets/gambartidakada.png'" alt="">
        </div>
        <div :class="`overflow-hidden flex flex-col w-full mt-3`">
            <p class="truncate font-bold text-xl">Rp. 12.000.000</p>
            <p class="truncate text-sm">{{ produk.tahun_keluaran }}</p>
            <p class="truncate text-xs text-slate-500 my-1">{{ produk.produk_judul }}</p>
            <div :class="`mt-auto text-[10px] text-slate-500 w-full gap-8 flex justify-between`">
                <p class="truncate">{{ produk.lokasi_provinsi }}, {{ produk.lokasi_kabupaten_kota }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'product-card',
    props: {
        page: String,
        produk: Object
    },
    methods: {
        goToDetailProduct() {
            this.$router.push('/app/product/'+ this.produk.produk_id)
        }
    }
}
</script>