<?php

// All Deployer recipes are based on `recipe/common.php`.
require 'recipe/symfony.php';

// Configure servers
server('production', 'spongebob.remote')
    ->user('web')
    ->identityFile()
    ->env('deploy_path', '/home/web/sites/test.locatie-informatie.nl');

// Specify the repository from which to download your project's code.
// The server needs to have git installed for this to work.
// If you're not using a forward agent, then the server has to be able to clone
// your project from this repository.
set('repository', 'https://github.com/stefanius/locatie-informatie');

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:vendors',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');