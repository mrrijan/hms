import axiosInstance from '../../config/axios/axios.js'
import {useAuth} from '../../stores/modules/auth.js'

const postLogin = ()=>{
    const userStore = useAuth();

    const login = async (credentials) =>{
        await axiosInstance.get("csrf-cookie")
        await axiosInstance.post('/login',credentials).then((res) =>{
                userStore.storeCredentials({
                    auth : true,
                    name : res.data.name,
                    email : res.data.email,
                    id : res.data.id
                });
        }).catch(err =>{
            throw err
        });
    }
    return {login}
}

export default postLogin;
