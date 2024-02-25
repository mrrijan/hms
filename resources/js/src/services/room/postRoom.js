import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const postRoom = () => {
    const addLoadingButton = ref(false);
    const addRoom = async (room) => {
        addLoadingButton.value = true;
        await axiosInstance.post('/room/create', room)
            .then(() => {
                addLoadingButton.value = false;
            }).catch((err) => {
                addLoadingButton.value = false;
                throw err;
            });
    }
    return {addRoom, addLoadingButton};
}
export default postRoom;
