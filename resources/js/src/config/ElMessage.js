import { ElMessage  } from 'element-plus'

const isObject = (value) => {
    if (value == null) {
        return false;
    }
    return typeof value === "object";
};

export const showErrorMessage = (error) => {
    const objProps = (object) => {
        for (let value in object) {
            if (isObject(object[value])) {
                objProps(object[value]);
            } else {
                ElMessage({
                    showClose: true,
                    message: object[value],
                    type: 'error',
                    center: true,
                })
                // ElNotification({
                //     title: 'Error',
                //     message: object[value],
                //     type: 'error',
                //     position: 'bottom-left',
                // })
                // ElNotification.error({
                //     message:object[value],
                //     position: 'bottom-left',
                //     title: 'Error',
                // })
            }
        }
    };
    objProps(error);
};

export const showSuccessMessage = (message) => {
    const objProps = function (object) {
        for (let value in object) {
            if (isObject(object[value])) {
                objProps(object[value]);
            } else {
                ElMessage({
                    showClose: true,
                    message: object[value],
                    type: 'success',
                    center: true,
                })
            }
        }
    };
    objProps(message);
};

export const showWarningMessage = (message) => {
    const objProps = function (object) {
        for (let value in object) {
            if (isObject(object[value])) {
                objProps(object[value]);
            } else {
                ElMessage({
                    showClose: true,
                    message: object[value],
                    type: 'warning',
                    center: true,
                })
            }
        }
    };
    objProps(message);
};

export const showMessage = (message) => {
    const objProps = function (object) {
        for (let value in object) {
            if (isObject(object[value])) {
                objProps(object[value]);
            } else {
                ElMessage({
                    showClose: true,
                    message: object[value],
                    center: true,
                })
            }
        }
    };
    objProps(message);
};
