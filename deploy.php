<?php
namespace Deployer;

require 'recipe/common.php';

// Configuration
// Repository
set('repository', 'https://github.com/CodeFromHell/usaq-backend.git');
set('git_tty', false); // [Optional] Allocate tty for git on first deployment

set('keep_releases', 2);
set('ssh_multiplexing', false);

// Dirs
set('shared_dirs', [
    'var/database'
]);

set('shared_files', [
    '.env',
]);

set('writable_dirs', []);

// Hosts
host('solus-dev')
    ->hostname('solus')
    ->stage('development')
    ->roles('app')
    ->set('deploy_path', '~/applications/usaq/production')
    ->set('branch', 'development')
    ->configFile('~/.ssh/config');

// Tasks
desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');

desc('Run migrations');
task('deploy:run_migrations',function () {
    run('cd {{release_path}} && {{bin/php}} ./app/console.php database:migrate');
});
//after('deploy:clear_paths', 'deploy:run_migrations');

desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
