import axios from "axios"

export const login = async (payload)=> {
    try {
        const res = await axios.post("/api/user/login", payload)
        if (res.name === "AxiosError") throw new Error(res.response.data.error)
        return res
    } catch (err) {
    return err
}
}

export const register = async (payload)=> {
    try {
        const res = await axios.post("/api/user/register", payload)
        if (res.name === "AxiosError") throw new Error(res.response.data.error)
        return res
    } catch (err) {
        return err
    }
}
export const getInfoUser = async ()=> {
    try {
        const res = await axios.get("/api/user/data")
        return res
    } catch (err) {
        return err
    }
}

export const updateProfile = async (payload)=> {
    try {
        const res = await axios.put("/api/user/update", payload)
        return res
    } catch (err) {
        return err
    }
}