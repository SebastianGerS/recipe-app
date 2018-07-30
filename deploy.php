<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'recipe-api');

// Project repository
set('repository', 'git@github.com:SebastianGerS/recipe-app.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('prod')
    ->hostname('me')
    ->set('branch','master')
	->set('deploy_path', '/var/www/recipe-api.sebastiangerstelsollerman.me')
	->user('root')
	->port(22);  
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

after('artisan:migrate', 'artisan:seed:all');

