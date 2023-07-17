<?php

namespace App\Libraries;

class ErrorCode
{
    const SERVER_ERROR = 1;
    const PARAM_INVALID = 2;
    const VALIDATION_ERROR = 3;
    const API_NOT_FOUND = 4;
    const AUTH_ERROR = 5;
    const PARAM_EXISTS = 6;
    const TOKEN_EXPIRED = 7;
    const SERVER_MAINTAINING = 8;
    const NO_PERMISSION_ERROR = 9;
    const USER_BLACK_LIST = 10;

    // APP
    const APP_ERROR_DOWNLOAD_MODEL = 11;
}
