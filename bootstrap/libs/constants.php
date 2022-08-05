<?php

    /**
     * This internal library is responsible for defining handy 
     * constants that are used through the whole project
     */

    class Constants {
        public static $HTTP_SUCCESS_CODE = 200;
        public static $HTTP_SUCCESS_STATUS = 'Success';

        public static $HTTP_MALFORMED_CODE = 400;
        public static $HTTP_MALFORMED_STATUS = 'Bad request';

        public static $HTTP_UNAUTHORIZED_CODE = 401;
        public static $HTTP_UNAUTHORIZED_STATUS = 'Unauthorized';

        public static $HTTP_FORBIDDEN_CODE = 403;
        public static $HTTP_FORBIDDEN_STATUS = 'Forbidden';

        public static $HTTP_NOTFOUND_CODE = 404;
        public static $HTTP_NOTFOUND_STATUS = 'Not found';

        public static $HTTP_CONFLICT_CODE = 409;
        public static $HTTP_CONFLICT_STATUS = 'Conflict';

        public static $HTTP_ERROR_CODE = 500;
        public static $HTTP_ERROR_STATUS = 'Failure';
    }
