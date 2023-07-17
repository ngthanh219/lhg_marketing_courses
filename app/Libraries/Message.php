<?php

namespace App\Libraries;

class Message
{
    // system
    const CANNOT_SERVER = 'Cannot connect to server';
    const SERVER_ERROR = 'System error';
    const LOGIC_ERROR = 'Error! An error occurred. Please try again later';
    const API_NOT_FOUND = 'Current resources not found but may be available in the future';
    const PARAM_INVALID = 'Parameter was invalid';
    const PARAM_EXISTS = 'Parameter already exists';

    // Auth
    const AUTH_ERROR = 'Not authentication';
    const LOGIN_ERROR = 'Email or password was invalid';
}
