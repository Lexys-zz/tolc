<?php

// set error handler
set_error_handler('error_handler');

/**
 * Error handler function. Replaces PHP's error handler.
 *
 * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING are always handled by PHP.
 * E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE are handled by this function.
 */
function error_handler($err_no, $err_str, $err_file, $err_line) {
    // if error_reporting is set to 0, exit. This is also the case when using @
    if (ini_get('error_reporting') == '0') return;
    // handle error
    switch ($err_no) {
        case E_WARNING:
            $msg = '[ErrNo=' . $err_no . ' (WARNING), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
            log_error($msg, (!defined('INSTALLING'))); // e.g. warnings are hidden while installing
            if (!defined('INSTALLING')) exit;
            break;
        case E_USER_ERROR:
            $msg = '[ErrNo=' . $err_no . ' (USER_ERROR), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
            log_error($msg);
            exit;
            break;
        case E_USER_WARNING:
            $msg = $err_str;
            set_last_message(false, $msg);
            header('Location: ' . PROJECT_FULL_URL . '/index.php');
            exit;
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
        case 2048: // E_STRICT in PHP5
            // ignore
            break;
        default:
            // unknown error. Log in file (only) and continue execution
            $msg = '[ErrNo=' . $err_no . ' (UNKNOWN_ERROR), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
            log_error($msg, false);
            break;
    }
}

/**
 * Log an error to custom file (error.log in project's directory)
 */
function log_error($msg, $show_onscreen = true) {
    // put in screen
    if ($show_onscreen)
        print $msg;

    // put in file
    @error_log(date('Y-m-d H:i:s') . ': ' . $msg . "\n", 3, PROJECT_DIR . '/log/error.log');
}
?>
