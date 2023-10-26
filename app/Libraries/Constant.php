<?php

namespace App\Libraries;

class Constant
{
    const ROLE_ADMIN = 0;
    const ROLE_CLIENT = 1;

    const IS_NOT_LOGGED = 0;
    const IS_LOGGED = 1;
    const IS_ALL_LOGGED = 2;

    const IS_SHOW = 0;
    const IS_NOT_SHOW = 1;
    const IS_ALL_SHOW = 2;

    const IS_NOT_CHANGE_PASSWORD = 0;
    const IS_CHANGE_PASSWORD = 1;

    const IS_DELETED = 1;

    const IMAGE_FOLDER = 'images/';
    const VIDEO_FOLDER = 'videos/';

    const EXPIRE_IMAGE = 60;
    const EXPIRE_VIDEO = 300;

    const IS_NOT_CHANGE_VIDEO = 0;
    const IS_CHANGE_VIDEO = 1;

    const COURSE_USER_USING = 0;
    const COURSE_USER_PENDING = 1;
    const COURSE_USER_NO_ACTION = 2;

    const VIDEO_EXT = '.mp4';

    const IS_NOT_VERIFIED_EMAIL = 0;
    const IS_VERIFIED_EMAIL = 1;
}
