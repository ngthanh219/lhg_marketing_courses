import env from '../../../env';

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
}

function rejectError(err, formDataError = null) {
    var errors = {
        message: null,
        validation: null
    };

    if (typeof (err.response) !== 'undefined') {
        err = err.response.data;

        if (typeof (err.error) !== 'undefined') {
            errors.message = err.error.error_message;
        } else {
            errors.err;
        }

        if (typeof (err.validation) !== 'undefined') {
            errors.validation = err.validation;
        }
    } else {
        errors.message = errorMessage;
    }

    handleFormDataError(errors, formDataError);
}

const actionParams = {
    API: env.api + 'admin/',
    getError: rejectError
};

export default actionParams;
