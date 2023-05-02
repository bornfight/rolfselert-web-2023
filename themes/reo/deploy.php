<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'rolfselert-web-2023');

set('release_name', function () {
    return (string) run('date +"%s"');
});

set('projects', 'bwp_projects');
set('projects-staging', 'bwp_projects-staging');

// Project repository
set('repository', 'git@github.com:bornfight/rolfselert-web-2023.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('staging')
    ->hostname('18.185.224.204')
    ->stage('staging')
    ->set('branch', 'staging')
    ->user('bitnami')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->set('deploy_path', '~/{{projects-staging}}/{{application}}');

host('production')
    ->hostname('18.185.224.204')
    ->stage('production')
    ->set('branch', 'master')
    ->user('bitnami')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->set('deploy_path', '~/{{projects}}/{{application}}');

/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
after('deploy', 'success');
