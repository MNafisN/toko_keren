<template>
    <div :class="`w-full shadow border rounded ${page === 'home' ? 'p-2' : 'flex gap-2'}`">
        <div :class="page === 'home' ? 'h-[153px] min-w-[145px]' : 'h-[130px] w-[130px] min-w-[130px]'">
            <img class="h-full w-full object-cover" src="/assets/image.webp" alt="">
        </div>
        <div :class="`overflow-hidden flex flex-col w-full ${page === 'home' ? 'mt-3' : 'p-2'}`">
            <p class="truncate font-bold text-xl">Rp. 12.000.000</p>
            <p class="truncate text-sm">2012</p>
            <p class="truncate text-xs text-slate-500 my-1">Vario 125 Black</p>
            <div :class="`mt-auto text-[10px] text-slate-500 w-full gap-8 ${page !== 'home' ? 'flex justify-between' : null}`">
                <p class="truncate">KARANG TENGAH, DEMAK KAB</p>
                <p class="min-w-max">HARI INI</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'product-card',
    props: {
        page: String
    }
}
</script>