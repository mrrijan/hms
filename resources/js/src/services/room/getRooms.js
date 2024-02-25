import axiosInstance from '../../config/axios/axios.js';
import {ref} from 'vue';

const getRooms = () => {

    const rooms = ref([]);
    const meta = ref([]);
    const roomsLoading = ref(false)

    const loadRooms = async (url = '/rooms') => {
        roomsLoading.value = true
        await axiosInstance.get(url).then((res) => {
            roomsLoading.value = false
            rooms.value = res.data.data;
            meta.value = res.data.meta;
        }).catch((err) => {
            roomsLoading.value = false
            throw err;
        })
    }

    return {rooms, meta, loadRooms, roomsLoading};
}

export default getRooms;
