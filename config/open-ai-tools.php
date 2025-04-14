<?php

return [
    'database' => [
        /*
         * You can use this to prefix the tables this package creates:
         * e.g. 'open_ai_tools_' → 'open_ai_tools_assistants'
         *
         * You can leave this blank, but there's a higher chance of issues
         * if you have similarly named tables in your application
         */
        'prefix' => '',
    ],
    'logging' => [
        /*
         * This indicates whether you'd like action operations to be logged, as
         * actions are probably going to be run in queued tasks and the scheduler
         */
        'enabled' => true,
    ],
];
