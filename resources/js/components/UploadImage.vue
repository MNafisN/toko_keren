<template>
    <label :for="'foto' + index">
        <div
            :class="`w-[100px] h-[100px] border-2 relative ${disabled ? 'border-[#9dadb6]' : 'border-black'}`"
        >
            <img v-if="preview || fileName" :src="linkImg" alt="preview" class="w-full h-full object-contain" />
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
            <div v-if="isLoading" class="absolute top-0 w-full h-full flex justify-center items-center">
                <div class="loader"></div>
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
</template>

<script>
import axios from 'axios';

export default {
    name: "upload-image",
    data() {
        return {
            isLoading: false,
            preview: ""
        }
    },
    props: {
        index: Number,
        disabled: Boolean,
        fileName: String
    },
    emits: ["fileUploaded", "uploadFailed"],
    methods: {
        selectImage (file) {
            // membuat preview image
            this.preview = URL.createObjectURL(file);

            // isLoading
            this.isLoading = true

            // upload image
            const formData = new FormData()
            formData.append("photo", file)
            axios
                .post('/api/produk/upload_photo', formData)
                .then((res)=>{
                    console.log(res.data.data)
                    this.$emit("fileUploaded", res.data.data.file_name)
                })
                .catch((err)=>{
                    console.log(err);
                    this.$emit("uploadFailed")
                })
                .finally(()=>{
                    this.isLoading = false
                    this.preview = ""
                })
        },
    },
    computed: {
        linkImg() {
            return this.preview ? this.preview : "/api/produk/download_photo/"+this.fileName
        }
    }
};
</script>

<style scoped>
.loader {
    border: 4px solid #ffffffc7;
    border-left-color: transparent;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    animation: spin89345 1s linear infinite;
}

@keyframes spin89345 {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
