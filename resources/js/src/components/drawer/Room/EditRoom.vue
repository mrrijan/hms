<script setup>
import {onMounted, reactive, ref} from "vue";
import getRoom from '../../../services/room/getRoom.js';
import putRoom from '../../../services/room/putRoom.js';

const {updateRoom,updateLoadingButton} = putRoom();
const {room , loadRoom} = getRoom();
const props = defineProps(['roomId']);
const editRoomDrawer = defineModel();
const formRef = ref(null);
const emits = defineEmits(['content-updated']);

const validateMaximumOccupancy = (rule,value,callback)=>{
    if(!value) callback(new Error('Maximum Occupancy cannot be empty'));
    if(value == null) callback(new Error('Maximum occupancy cannot be empty'));
    return true;
}
const validateNumberOfBeds = (rule , value , callback) =>{
    if(!value) callback(new Error('Number of beds cannot be empty'));
    if(value == null) callback(new Error('Number of beds cannot be empty'));
    return true;
}
const rules = reactive({
    maximum_occupancy : [{validator : validateMaximumOccupancy , trigger : 'blur'}],
    number_of_beds : [{validator : validateNumberOfBeds , trigger : 'blur'}]
});

const handleSubmit = (formEl)=>{
    const roomData = {
        id : props.roomId,
        room_number : room.value.room_number,
        maximum_occupancy : room.value.maximum_occupancy,
        occupancy_status : room.value.occupancy_status,
        number_of_beds : room.value.number_of_beds,
    }
    formEl.validate((valid)=>{
        if (valid) updateRoom(roomData)
            .then(()=>{
                editRoomDrawer.value = false;
                emits('content-updated');
            }).catch((err) => {
                console.log(err);
            });
    }).catch();
}

const handleDrawerOpen = () => {
    loadRoom(props.roomId).then(()=> {
        room.value.occupancy_status = Boolean(room.value.occupancy_status)
    }).catch()
}
</script>

<template>
    <el-drawer
        v-model="editRoomDrawer"
        title="Edit Room"
        direction="rtl"
        @open="handleDrawerOpen"
    >
        <el-form  ref="formRef" :model="room" label-position="top" size="small">
            <el-form-item prop="room_number" label="Room Number" :rules="[{required : true , message : 'Please enter room number'}]" required>
                <el-input v-model="room.room_number"/>
            </el-form-item>
            <el-form-item prop="maximum_occupancy" label="Maximum Occupancy">
                <el-input-number min="1" v-model="room.maximum_occupancy"/>
            </el-form-item>
            <el-form-item prop="occupancy_status" label="Occupancy Status">
                <el-checkbox v-model="room.occupancy_status" label="Occupied" />
            </el-form-item>
            <el-form-item prop="number_of_beds" label="Number of beds">
                <el-input-number min="1" v-model="room.number_of_beds"/>
            </el-form-item>
            <el-form-item>
                <el-button :loading="updateLoadingButton" type="primary" @click="handleSubmit(formRef)">Update</el-button>
            </el-form-item>
        </el-form>
    </el-drawer>
</template>

<style scoped>

</style>
