let helper = {
    appendFormData(form) {
        const formData = new FormData();

        for (var param in form) {
            formData.append(param, form[param]);
        }

        return formData;
    },

    getQueryString(form) {
        return '?' + new URLSearchParams(form).toString();
    },

    isNumber(e) {
        let keyCode = (e.keyCode ? e.keyCode : e.which);

        if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
            e.preventDefault();
        }
    },
}

export default helper;