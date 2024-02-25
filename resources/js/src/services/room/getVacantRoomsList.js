import axiosInstance from '../../config/axios/axios.js';
import {ref} from "vue";

const getVacantRoomsList = () => {
    const vacantRoomsList = ref([]);

    const loadVacantRoomsList = async () => {
        await axiosInstance.get('/vacantRoomsList')
            .then((res) => {
                vacantRoomsList.value = res.data.data;
            }).catch((err) => {
                throw err;
            })
    }
    return {vacantRoomsList, loadVacantRoomsList};
}
export default getVacantRoomsList;
