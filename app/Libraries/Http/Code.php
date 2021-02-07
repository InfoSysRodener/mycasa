<?php


namespace App\Libraries\Http;

class Code {

    // use for successful gets
    const HTTP_OK                           =   200;

    // use for successful store
    const HTTP_CREATED                      =   201;

    /**
     * use for requests that requires queueable requests
     * such as SMS-Notification, password reset that get sent to email
     * and etc
     */
    const HTTP_ACCEPTED                     =   202;
    const HTTP_NON_AUTHORATIZE_INFO         =   203;

    const HTTP_NO_CONTENT                   =   204;
    const HTTP_RESET_CONTENT                =   205;
    const HTTP_PARTIAL_CONTENT              =   206;
    const HTTP_MULTISTATUS                  =   207;
    const HTTP_ALREADY_REPORTED             =   208;
    const HTTP_IM_USED                      =   266;

    const HTTP_MULTIPLE_CHOICES             =   300;
    const HTTP_MOVED_PERMANENTLY            =   301;
    const HTTP_FOUND                        =   302;
    const HTTP_SEE_OTHER                    =   303;
    const HTTP_NOT_MODIFIED                 =   304;
    const HTTP_USE_PROXY                    =   305;
    const HTTP_SWITCH_PROXY                 =   306;
    const HTTP_TEMPORARY_REDIRECT           =   307;
    const HTTP_PERMANENT_REDIRECT           =   308;

    const HTTP_BAD_REQUEST                  =   400;

    // direct from oauth 2.0 mechanism
    const HTTP_UNAUTHORIZED                 =   401;
    const HTTP_PAYMENT_REQUIRED             =   402;

    // when the user_type does not allow the user to access a resource
    // anything that fails in the policy
    const HTTP_FORBIDDEN                    =   403;

    // if the id provided does not exist
    const HTTP_NOT_FOUND                    =   404;
    const HTTP_METHOD_NOT_ALLOWED           =   405;

    // if the header does not accept application/json
    const HTTP_NOT_ACCEPTABLE               =   406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED    = 407;
    const HTTP_REQUEST_TIMEOUT              =   408;
    const HTTP_CONFLICT                     =   409;
    const HTTP_GONE                         =   410;
    const HTTP_LENGTH_REQUIRED              =   411;
    const HTTP_PRECONDITION_FAILED          =   412;

    // if a file is too large, or a text
    const HTTP_PAYLOAD_TOO_LARGE            =   413;
    const HTTP_URI_TOO_LONG                 =   414;

    // for unsupported uploads such as svg on image
    const HTTP_UNSUPPORTED_MEDIA_TYPE       =   415;

    const HTTP_RANGE_NOT_SATISFIED          =   416;
    const HTTP_EXPECTATION_FAILED           =   417;
    const HTTP_MISREDIRECTED_REQUEST        =   421;

    // when the request failed due to validation problem
    const HTTP_UNPROCESSABLE_ENTITY         =   422;

    const HTTP_LOCKED                       =   423;
    const HTTP_FAILED_DEPENDENCY            =   424;
    const HTTP_UPGRADE_REQUIRED             =   426;
    const HTTP_PRECONDITION_REQUIRED        =   428;
    const HTTP_TOO_MANY_REQUEST             =   429;
    const HTTP_REQUEST_HEADER_FIELD_TOO_LARAGE  = 431;
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASON =   451;

    const HTTP_FAILED                       = 500;
}
