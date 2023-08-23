<template>
    <div class="bg-white p-4 mt-2 flex justify-between items-center">
        <span class="font-bold text-sm">ID IKLAN {{ id }}</span>
        <span class="font-bold text-sm">LAPORKAN IKLAN INI</span>
    </div>
</template>

<script>
export default {
    name: 'product_id',
    props: {
        id: String
    }
}
</script>