<template>
    <div class="relative">
        <label v-if="label" :for="id" :class="`text-sm block ${required ? 'required' : null}`">{{ label }}</label>

        <!-- type select -->
        <select v-if="type === 'select'"
            :id="id"
            v-model="value"
            class="cursor-pointer w-full h-12 bg-transparent border border-subTitle rounded-md appearance-none relative z-10 pl-2 pr-8 truncate"
        >
            <!-- option select -->
            <option value=""></option>
            <option v-for="item in list" :value="item">{{ item }}</option>
            
        </select>
        <!-- attributes -->
        <div v-if="type === 'select'" class="absolute right-4 top-9 select-none">
            <div class="w-3 h-3 border-r-2 border-b-2 border-black rotate-45"></div>
        </div>

        <!-- type number -->
        <input v-if="type === 'number'"
            type="number"
            :id="id"
            :placeholder="placeholder"
            :value="value"
            @input="e => value = e.target.value"
            class="w-full h-12 border border-subTitle rounded-md px-2"
            :disabled="disabled"
        >

        <!-- type text -->
        <input v-if="type === 'text'"
            type="text"
            :id="id"
            :max="max ? max : Infinity"
            :placeholder="placeholder"
            :value="value"
            @input="e => value = e.target.value"
            class="w-full h-12 border border-subTitle rounded-md px-2"
            :disabled="disabled"
        >

        <!-- type textarea -->
        <textarea v-if="type === 'textarea'"
            :id="id"
            :maxlength="max ? max : Infinity"
            :placeholder="placeholder"
            :value="value"
            @input="e => value = e.target.value"
            class="w-full h-textarea  border border-subTitle rounded-md p-2 resize-none"
            :disabled="disabled"
        ></textarea>

        <!-- type radio -->
        <div v-if="type === 'radio'" class="w-full flex gap-2 flex-wrap">
            <template v-for="(item, i) in list">
                <input type="radio" :id="id+i" :value="item" v-model="value" class="hidden">
                <label :for="id+i" :class="`py-2 px-3 rounded-md border text-sm ${item === value ? 'bg-[#c8f8f6] border-black' : 'bg-white'}`">{{ item }}</label>
            </template>
        </div>

        <!-- type price -->
        <input v-if="type === 'price'"
            type="number"
            class="w-full pl-11 h-12 border border-subTitle rounded-md"
            :id="id"
            :placeholder="placeholder"
            :value="value"
            @input="e => value = e.target.value"
            :disabled="disabled"
        >
        <div v-if="type === 'price'" class="h-8 w-10 border-r border-[rgba(0,47,52,0.36)] absolute top-7 flex justify-center items-center">
            <span class="text-xs text-subTitle">Rp</span>
        </div>

        <!-- type phone -->
        <input v-if="type === 'phone'"
            type="number"
            class="w-full pl-11 h-12 border border-subTitle rounded-md"
            :id="id"
            :placeholder="placeholder"
            :value="value"
            @input="e => value = e.target.value"
            :disabled="disabled"
        >
        <div v-if="type === 'phone'" :class="`h-8 w-10 border-r border-[rgba(0,47,52,0.36)] absolute flex justify-center items-center ${label ? 'top-7' : 'top-2'}`">
            <span class="text-xs text-subTitle">+62</span>
        </div>


        <!-- footNote -->
        <div v-if="footNote || maxlength" class="flex justify-between gap-4">
            <p class="text-xs text-[rgba(0,47,52,0.64)] w-fit">{{ footNote }}</p>
            <p class="text-xs text-[rgba(0,47,52,0.64)] min-w-max">{{ maxlength }}</p>
        </div>
    </div>
</template>

<script>

export default {
    name: 'input-component',
    data() {
        return {
            value : "",
        }
    },
    props: {
        id: String,
        type: String,
        label: String,
        required: Boolean,
        option: Array,
        footNote: String,
        max: Number,
        list: Array,
        initValue: String,
        placeholder: String,
        disabled: Boolean
    },
    emits: ['sendValue'],
    watch: {
        value: function() {
            if (this.type === "price" || this.type === "number") {
                this.$emit('sendValue', parseInt(this.value))
            } else {
                this.$emit('sendValue', this.value)
            }     
        },
        initValue: function() {
            this.value = this.initValue
        }
    },
    computed: {
        maxlength() {
            if(this.max){
                const length = this.value.length
                return `${length} / ${this.max}`
            } else return;
        }
    },
}
</script>

<style scoped>
.required::after{
    content: '*';
    color: red;
    margin-left: 5px;
}

.h-textarea{
    height: 96px !important;
}
input:focus{
    outline: 1px solid #00a49f;
}
select:focus{
    outline: 1px solid #00a49f;
}
textarea:focus{
    outline: 1px solid #00a49f;
}
</style>