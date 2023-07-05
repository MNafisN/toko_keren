<template>
    <div class="relative">
        <label :for="id" :class="`text-sm block ${required ? 'required' : null}`">{{ label }}</label>

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

        <!-- type text -->
        <input v-if="type === 'text'"
            type="text"
            :id="id"
            :max="max ? max : Infinity"
            :value="value"
            @input="e => value = e.target.value"
            class="w-full h-12 border border-subTitle rounded-md px-2"
        >

        <!-- type textarea -->
        <textarea v-if="type === 'textarea'"
            :id="id"
            :maxlength="max ? max : Infinity"
            :value="value"
            @input="e => value = e.target.value"
            class="w-full h-textarea  border border-subTitle rounded-md p-2 resize-none"
        ></textarea>

        <!-- type radio -->
        <div v-if="type === 'radio'" class="w-full flex gap-2 flex-wrap">
            <template v-for="(item, i) in list">
                <input type="radio" :id="id+i" :value="item" v-model="value" class="hidden">
                <label :for="id+i" :class="`py-2 px-3 rounded-md border text-sm ${item === value ? 'bg-[#c8f8f6] border-black' : 'bg-white'}`">{{ item }}</label>
            </template>
        </div>

        <!-- type price -->
        <input v-if="type === 'price'" type="number" class="w-full h-12 border  border-subTitle rounded-md" >
        <div v-if="type === 'price'" class="h-8 w-10 border-r border-[rgba(0,47,52,0.36)] absolute top-7 flex justify-center items-center">
            <span class="text-xs text-subTitle">Rp</span>
        </div>


        <!-- footNote -->
        <div v-if="footNote" class="flex justify-between gap-4">
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
            value : ""
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
        list: Array
    },
    watch: {
        value: function() {
            console.log(this.value)
        }
    },
    computed: {
        maxlength() {
            if(!this.max) return;
            const length = this.value.length
            return `${length} / ${this.max}`
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