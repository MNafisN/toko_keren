import axios from "axios";

export const uploadPhoto = async (file) => {
    try {
        const formData = new FormData()
        formData.append("photo", file)
    
        const res = await axios.post("/api/produk/upload_photo", formData)
        return res.data
    } catch (err) {
        return err
    }
} 

export const deletePhoto = async (fileName) => {
    try {
        const res = await axios.delete("/api/produk/delete_photo/"+fileName)
        return res
    } catch (err) {
        return err
    }
}

export const uploadAllPhoto = async (files) => {
    try {
        const list = []
        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if(file) {
                const res = await uploadPhoto(file.file)
                list.push(res.data)
            } else {
                list.push(null)
            }
        }
        return list
    } catch (err) {
        console.log(err);
        return err
    }
}

export const postProduct = async (produk) => {
    try {
        const res = await axios.post('/api/produk', produk)
        if (res.name === "AxiosError") throw new Error(res.response.data.error)
        return res
    } catch (err) {
        return err
    }
}

export const updateProduct = async (id, produk) => {
    try {
        const res = await axios.put("/api/produk/update/" + id, produk)
        if (res.name === "AxiosError") throw new Error(res.response.data.error)
        return res
    } catch (err) {
        console.log(err);
        return err
    }
}

