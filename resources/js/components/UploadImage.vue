<template>
    <div class="w-[100px] h-[100px] relative cursor-pointer">
        <!-- tombol hapus foto -->
        <div v-if="fileName || preview" @click="deletePhoto" class="absolute top-1 right-1 w-7 h-7 rounded-full bg-buy-button flex justify-center items-center">
            <div class="i-hapus"></div>
        </div>

        <label :for="'foto' + index" :class="`${fileName || preview ? 'pointer-events-none' : null}`">
            <div :class="`w-full h-full border-2 ${disabled ? 'border-[#9dadb6]' : 'border-black'}`">
                <!-- jika ada fotonya -->
                <img v-if="preview || fileName"  :src="linkImg" alt="preview" class="w-full h-full object-contain" />

                <!-- jika tidak ada foto -->
                <div v-else class="h-full flex justify-center items-center flex-col gap-1">
                    <div :class="`${disabled ? 'i-camera-plus-disabled' : 'i-camera-plus'}`"></div>
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
            :disabled="disabled"
            @input="(e) => selectImage(e.target.files[0])"
            class="hidden"
        />
    </div>
</template>

<script>
export default {
    name: "upload-image",
    props: {
        index: Number,
        disabled: Boolean,
        fileName: String,
        preview: String
    },
    emits: ["sendImage", "deleteImage"],
    methods: {
        selectImage (file) {
            const preview = URL.createObjectURL(file);
            this.$emit("sendImage", {file, preview})
        },
        deletePhoto() {
            this.$emit("deleteImage", this.index)
        }
    },
    computed: {
        linkImg() {
            return this.preview ? this.preview : "/api/produk/download_photo/"+this.fileName
        }
    }
};
</script>