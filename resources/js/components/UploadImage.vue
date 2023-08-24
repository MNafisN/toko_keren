<template>
    <div :class="`w-[100px] h-[100px] border-2 flex justify-center items-center flex-col gap-1 ${disabled ? 'border-[#9dadb6]' : 'border-black'}`">
        <div :class="`${disabled ? 'i-camera-plus-disabled' : 'i-camera-plus'}`"></div>
        <p v-if="!disabled" class="text-center text-sm leading-4">Tambahkan Foto</p>
    </div>
</template>

<script>
export default {
    name: 'upload-image',
    props: {
        disabled: Boolean
    }
}
</script>