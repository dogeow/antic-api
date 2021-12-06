<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', '/var/www/antic-api');

// Project repository
set('repository', 'git@github.com:likunyan/antic-api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts

host('dogeow.com')
    ->user('root')
    ->set('deploy_path', '{{application}}');

// Tasks

task('build', function (): void {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
