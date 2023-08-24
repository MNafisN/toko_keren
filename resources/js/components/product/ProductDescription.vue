<template>
    <div class="bg-white p-4 mt-2">
        <h1 class="text-xl font-bold mb-4">Detail</h1>
        <p>{{ description }}</p>
    </div>
</template>

<script>
export default {
    name: 'product_description',
    props: {
        description: String
    }
}
</script>