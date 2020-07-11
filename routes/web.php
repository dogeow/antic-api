<?php

Route::post('callback', function (Illuminate\Http\Request $request) {
    file_put_contents('../233.log', var_export($request->all(), 1).PHP_EOL, FILE_APPEND);
});

