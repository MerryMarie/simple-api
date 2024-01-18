<?php



require_once(__DIR__."/core/mod.php");
require_once(__DIR__."/autoloader.php");

require_once(__DIR__."/core/root/controller.php");
require_once(__DIR__."/core/root/model.php");

require_once(__DIR__."/core/app.php");


require_once(__DIR__."/core/request.php");
require_once(__DIR__."/core/user.php");
require_once(__DIR__."/core/route.php");

//require_once(__DIR__."/aliases.php");

set_error_handler(function ($level, $message, $file = '', $line = 0)
{
    throw new ErrorException($message, 0, $level, $file, $line);
});
function err_handlr($e)
{
    Logger::log($e);
    http_response_code(500);
    if (ini_get('display_errors')) {
        echo '<pre>'.$e.'</pre>';
    } else {
        echo "<h1>500 Internal Server Error</h1>
              An internal server error has been occurred.<br>
              Please try again later.";
    }
}
set_exception_handler('err_handlr');
register_shutdown_function(function ()
{
    $error = error_get_last();
    if ($error !== null) {
        $e = new ErrorException(
            $error['message'], 0, $error['type'], $error['file'], $error['line']
        );
        err_handlr($e);
    }
});



Autoloader::init();
Mod::setDirRoot(__DIR__);
Logger::setLogFile(Mod::getDirRoot()."/assets/logs/errors.log");
DB::init();
Request::init();
App::run();