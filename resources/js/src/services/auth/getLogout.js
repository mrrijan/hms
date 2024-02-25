import axiosInstance from '../../config/axios/axios.js';
import {useAuth} from '../../stores/modules/auth.js';

const getLogout = ()=>{
    const useStore = useAuth();
    const logout =async  ()=>{
        await axiosInstance.get('/logout').then((res)=>{
                useStore.deleteCredentials();
        }).catch(err=>{
            throw err
        })
    }
    return {logout};
}

export default getLogout;
