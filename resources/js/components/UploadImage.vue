<template>
    <label :for="'foto' + index">
        <div
            :class="`w-[100px] h-[100px] border-2 ${disabled ? 'border-[#9dadb6]' : 'border-black'}`"
        >
            <img v-if="preview" :src="preview" alt="preview" class="w-full h-full object-contain" />
            <div v-else class="h-full flex justify-center items-center flex-col gap-1">
                <div
                    :class="`${
                        disabled ? 'i-camera-plus-disabled' : 'i-camera-plus'
                    }`"
                ></div>
                <p v-if="!disabled" class="text-center text-sm leading-4">
                    Tambahkan Foto
                </p>
            </div>
        </div>
    </label>
    <input
        type="file"
        accept="image/*"
        :id="'foto' + index"
        @input="(e) => selectImage(e.target.files[0])"
        class="hidden"
    />
</template>

<script>
export default {
    name: "upload-image",
    props: {
        index: Number,
        disabled: Boolean,
        preview: String
    },
    emits: ["sendValue"],
    methods: {
        selectImage(file) {
            const path = URL.createObjectURL(file);
            this.$emit("sendValue", {preview: path, name: file.name})
        },
    },
};
</script>
