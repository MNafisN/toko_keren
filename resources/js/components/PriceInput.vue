<template>
    <div class="relative">
        <label for="priceInput" :class="`text-sm block ${required ? 'required' : null}`">Harga</label>
        <input
            type="text"
            class="w-full pl-11 h-12 border border-subTitle rounded-md"
            v-model="value"
            @focusin="focusin"
            @focusout="focusin"
        >
        <div class="h-8 w-10 border-r border-[rgba(0,47,52,0.36)] absolute top-7 flex justify-center items-center">
            <span class="text-xs text-subTitle">Rp</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "input-price",
    data() {
        return {
            value: "0",
        }
    },
    props: {
        required: Boolean,
        initValue: Number
    },
    watch: {
        value(val) {
            const result = val.split("")[0] === "0"
            ? val.slice(1,1)
            : val.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            this.$nextTick(()=>this.value = result)
            
            const sendValue = parseInt(result.replace(/\D/g, ""))
            this.$emit('sendValue', sendValue)
        },
        initValue(val) {
            this.value = val.toString()
        }
    },
    emits: ['sendValue']
}
</script>