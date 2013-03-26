<?php

return array(
    # Force true if you use the php internal HTTP server
    'debug' => true,
    'pomm' => array(
        'cist' => array(
            'dsn' => 'pgsql://sanpi:3.1416@127.0.0.1:5432/cist',
        ),
    ),
    'users' => array(
        // raw password is foo
        'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
    ),
);
