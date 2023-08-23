<template>
    <div class="bg-white p-4">
        <div class="flex justify-between items-center mb-1 mt-2">
            <span class="font-bold text-xl">Rp {{ harga }}</span>
            <div class="flex items-center gap-4">
                <div class="i-share"></div>
                <div class="i-love"></div>
            </div>
        </div>
        <p class="text-sm">{{ title }}</p>
        <div class="h-[1px] w-full bg-slate-300 mt-5"></div>
        <div class="flex justify-between mt-2 text-subTitle text-sm">
            <p class="text-xs">Wedung, Demak, Jawa Tengah</p>
            <p class="text-xs">Hari ini</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'product_title',
    props: {
        harga: Number,
        title: String
    }
}
</script>