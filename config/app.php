<?php

$envVal = env('WAREHOUSE_CODE');

return [
    // app.warehouseCode
    // 'warehouseCode' => ['a', 'b'],
    'warehouseCode' => $envVal ? explode(',', $envVal) : [],
    'global_auth_key' => env('GLOBAL_AUTH_KEY'),

];
