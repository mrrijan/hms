import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const deleteRoom = ()=>{
    const deleteLoadingButton = ref(false);
    const destroyRoom = async (room_id)=>{
        deleteLoadingButton.value = true;
        await axiosInstance.delete(`/room/delete/${room_id}`)
            .then(()=>{
                deleteLoadingButton.value = false;
            })
            .catch((err)=>{
                deleteLoadingButton.value = false;
                throw err;
            })
    }
    return {destroyRoom,deleteLoadingButton};
}
export default deleteRoom;
