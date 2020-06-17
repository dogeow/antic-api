<?php

Route::any('callback', function(){
    file_put_contents('../233.log', var_export($_REQUEST, 1) . PHP_EOL, FILE_APPEND);
});
