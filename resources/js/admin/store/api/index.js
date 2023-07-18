import env from '../../../env';

const errorMessage = {
    error: {
        error_message: 'An error has occurred'
    }
};

function rejectError(err) {
    if (typeof (err.response) !== 'undefined') {
        return err.response.data;
    } else {
        return errorMessage;
    }
}

const actionParams = {
    API: env.api,
    getError: rejectError
};

export default actionParams;
