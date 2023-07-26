import env from '../../../env';
import helper from '../../helpers/helper';

const errorMessage = 'An error has occurred!';

function handleFormDataError(errors, formDataError) {
    if (errors.validation) {
        for (var param in formDataError) {
            formDataError[param] = '';

            if (errors.validation[param]) {
                formDataError[param] = errors.validation[param][0];
            }
        }
    } else {
        for (var param in formDataError) {
            formDataError[param] = '';
        }

        formDataError.message = errors.message;
    }

    return formDataError;
}

function rejectError(err, formDataError = null) {
    var errors = {
        message: null,
        validation: null
    };

    var notification = {
        success: 0,
        message: null
    };

    if (typeof (err.response) !== 'undefined') {
        if (typeof (err.response.status) !== 'undefined' && err.response.status === 401) {
            helper.setAuth({
                user: null,
                access_token: null
            });

            helper.setNotification(0, null);
        }

        err = err.response.data;

        if (typeof (err.error) !== 'undefined') {
            errors.message = err.error.error_message;
        }

        if (typeof (err.validation) !== 'undefined') {
            errors.validation = err.validation;
        }

        notification.message = errors.message;
    } else {
        errors.message = errorMessage;
        notification.message = errors.message;
    }

    helper.setNotification(notification.success, notification.message);

    return handleFormDataError(errors, formDataError);
}

function resetFormError(formError) {
    if (formError) {
        for (var param in formError) {
            formError[param] = '';
        }
    }
}

const actionParams = {
    API: env.api,
    getError: rejectError,
    resetFormError: resetFormError,
};

export default actionParams;
