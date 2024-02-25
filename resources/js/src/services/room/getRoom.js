import axiosInstance from '../../config/axios/axios.js'
import {ref} from 'vue';

const getRoom = ()=>{
    const room = ref({});
    const loadRoom = async (room_id)=>{
        await axiosInstance.get(`/room/${room_id}`)
            .then((res)=>{
                room.value = res.data.data;
            })
    }
    return {room , loadRoom};
}
export default getRoom;
