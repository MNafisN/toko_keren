<template>
    <div class="relative">
        <label :for="id" :class="`text-sm block ${required ? 'required' : null}`">{{ label }}</label>
        <input
            type="text"
            class="w-full pl-11 h-12 border border-subTitle rounded-md"
            :id="id"
            :value="value"
            @keydown="onkeydown"
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
            value: ""
        }
    },
    props: {
        id: String,
        label: String,
        required: Boolean,
    },
    methods: {
        onkeydown(e) {
            // console.log(e.key)
            const number = ["0","1","2","3","4","5","6","7","8","9"]
            if (number.includes(e.key)) this.value += e.key
        }
    }
}
</script>

<style scoped>
.required::after{
    content: '*';
    color: red;
    margin-left: 5px;
}
</style>