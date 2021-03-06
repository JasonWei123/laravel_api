<?php

return [
    'log_request_details' => true,

    'log_input_data' => true,

    'log_request_headers' => true,

    'log_session_data' => true,

    'log_memory_usage' => true,

    'log_git_data' => true,

    // You can specify the inputs from the user that should not be logged
    'ignore_input_fields' => ['password', 'confirm_password', 'password_confirmation'],
];
