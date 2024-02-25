import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const putRoom = ()=>{
    const updateLoadingButton = ref(false);
    const updateRoom = async (room) =>{
        updateLoadingButton.value = true;
        await axiosInstance.post('/room/update',room)
            .then(()=>{
                updateLoadingButton.value = false;
            })
            .catch((err) =>{
                updateLoadingButton.value = false;
                throw err;
            });
    }
    return {updateRoom,updateLoadingButton};
}
export default putRoom;
