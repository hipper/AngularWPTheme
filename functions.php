<?php

$includes = [
    'lib/init.php',                    // Initial theme setup and constants
    'lib/wrapper.php',                 // Theme wrapper class
    'lib/config.php',                  // Configuration
    'lib/extras.php',                  // Custom functions
    'lib/angular-app/angular-app.php', // Angular app
];

foreach ($includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'awp'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);
