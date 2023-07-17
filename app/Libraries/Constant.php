<?php

namespace App\Libraries;

class Constant
{
    // Directory path
    const ROOT_FOLDER = 'public';

    const ROOT_PATH = 'public/';
    const GENERAL_PATH = 'general/';
    const BOXES_PATH = 'boxes/';
    const BOX_IMAGES_PATH = 'box_images/';
    const MODELS_PATH = 'models/';
    const AVAILABLE_MODEL_PATH = 'available/';
    const RESIZE_IMAGE = 'resize/';
    const TRAINING_MODEL_PATH = 'training/';

    const PREFIX_BOX_IMAGE_FILE = 'box_';
    const PREFIX_MASK_URL = 'mask_';
    const PREFIX_SOURCE_URL = 'source_';
    const PREFIX_TEST_URL = 'test_';
    const PREFIX_MODEL_FOLDER = 'model_';
    const SUBFIX_ORIGINAL_IMAGE = '_original_image';

    CONST NG_FOLDER = 'NG';
    CONST OK_FOLDER = 'OK';

    // Model, collection
    const FIRESTORE_COLLECTION_NAME = 'box_images_company_';

    // RealtimeDB
    const REALTIME_COLLECTION = 'box_collection';
    const REALTIME_DOCUMENT_KEY = 'box_';
    const REALTIME_DOCUMENT_NAME = 'box_';
    const REALTIME_COLLECTION_APP_CAPTURE = 'app_capture';
    const REALTIME_COLLECTION_APP_CAPTURE_TEST = 'app_capture_test';
    const REALTIME_COLLECTION_APP_CAPTURE_TRAINING = 'app_capture_training';
    const REALTIME_COLLECTION_APP_CAPTURE_FRAME = 'app_capture_frame';
    const REALTIME_COLLECTION_APP_PICO = 'app_pico';
    const REALTIME_COLLECTION_WEB_REFRESH_INSTALLER_CHART = 'web_refresh_installer_chart';
    const REALTIME_COLLECTION_WEB_REFRESH_MONITORING_CHART = 'web_refresh_monitoring_chart';
    const REALTIME_COLLECTION_WEB_SET_FRAME = 'web_set_frame';

    // Firestore
    const SQL_WHERE = 'where';
    const SQL_WHERE_IN = 'whereIn';
    const SQL_WHERE_NOT = 'whereNot';
    const SQL_ORDER_BY = 'orderBy';

    // Key
    const SCORE_RESULT_KEY_PREFIX = 'model_';

    // Storage
    const TRAINED_MODEL_FILE_NAME = 'trained_model';
    const TRAINED_MODEL_FILE_EXT = 'onnx';
}
