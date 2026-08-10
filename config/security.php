<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HR API IP Whitelist
    |--------------------------------------------------------------------------
    |
    | Daftar IP yang diizinkan mengakses endpoint API mesin (mis. n8n) yang
    | dilindungi middleware `restrict.ip`. Dipisah koma. Mendukung exact match,
    | CIDR (10.0.0.0/24), wildcard (10.0.0.*), dan variasi localhost.
    |
    | Kosongkan untuk menonaktifkan pembatasan (fail-open).
    |
    */

    'api_allowed_ips' => env('API_ALLOWED_IPS', ''),

];
