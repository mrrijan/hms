import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const putStaff = () => {
    const updateLoadingButton = ref(false);
    const updateStaff = async (staff) => {
        updateLoadingButton.value = true;
        await axiosInstance.post('/staff/update', staff)
            .then(() => {
                updateLoadingButton.value = false;
            }).catch((err) => {
                updateLoadingButton.value = false;
                throw err;
            })
    };
    return {updateStaff, updateLoadingButton};
}
export default putStaff;
