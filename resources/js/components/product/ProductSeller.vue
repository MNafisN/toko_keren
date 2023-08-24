<template>
    <div class="bg-white p-4 mt-2 flex justify-between items-center">
        <div class="w-full flex gap-4 items-center">
            <div class="rounded-full w-16 h-16 overflow-hidden">
                <img class="w-full h-full object-cover" src="/assets/avatar.png" alt="">
            </div>
            <span class="font-bold text-xl">{{ seller }}</span>
        </div>
        <div class="i-arrow-right"></div>
    </div>
</template>

<script>
export default {
    name: 'product_seller',
    props: {
        seller: String
    }
}
</script>