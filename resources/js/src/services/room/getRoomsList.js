import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getRoomsList = ()=>{
    const roomsList = ref([]);
    const loadRoomsList = async (url = '/roomsList')=>{
        await axiosInstance.get(url)
            .then((res)=>{
                roomsList.value = res.data.data;
            }).catch((err) =>{
                throw err;
            })
    }
    return {roomsList , loadRoomsList};
}
export default getRoomsList;
