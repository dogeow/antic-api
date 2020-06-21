<?php

Route::post('callback', function () {
    file_put_contents('../233.log', var_export($_POST, 1).PHP_EOL, FILE_APPEND);
});
