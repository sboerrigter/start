<?php

namespace Deployer;

require 'recipe/composer.php';

// General settings
set('application', 'application');
set('repository', 'https://github.com/sboerrigter/start.git');

set('git_ssh_command', 'ssh');
set('default_timeout', 3600);

// Defaults
set('branch', 'main');
set('local_url', 'http://www.start.test');
set('local_domain', 'www.start.test');
set('deploy_path', '/var/www/vhosts/TB01-004/{{alias}}/site');
set('port', 2223);

set('identityFile', '~/.ssh/id_rsa');
set('addSshOption', 'UserKnownHostsFile', '/dev/null');
set('addSshOption', 'StrictHostKeyChecking', 'no');
set('addSshOption', 'HostBasedAuthentication', 'no');
set('use_atomic_symlink', false);

set('shared_files', ['.env', 'auth.json', 'web/wp-content/debug.log']);
set('shared_dirs', ['web/wp-content/uploads']);

// Hosts
host('start.bonsjoerd.eu')
  ->set('branch', 'main')
  ->set('hostname', 'tw-server-05.twservices.eu')
  ->set('remote_user', 'start.bonsjoerd.eu')
  ->set('remote_url', 'https://start.bonsjoerd.eu')
  ->set('remote_domain', 'start.bonsjoerd.eu');

host('hannahservices.com')
  ->set('branch', 'hannah')
  ->set('hostname', 'tw-server-05.twservices.eu')
  ->set('remote_user', 'hannahservices.com')
  ->set('remote_url', 'https://www.hannahservices.com')
  ->set('remote_domain', 'www.hannahservices.com');

// Custom tasks

// Install NPM dependencies, build and upload compiled styles and scripts
task('deploy:build', function () {
  runLocally('npm install');
  runLocally('npm run build');
  upload(
    'web/wp-content/themes/theme/dist/',
    '{{release_path}}/web/wp-content/themes/theme/dist/'
  );
});

// SSH into remote server: dep ssh
task('ssh', function () {
  runLocally('ssh {{remote_user}}@{{hostname}}');
});

// Pull database: dep db:pull
task('db:pull', function () {
  set('ssh_multiplexing', false);

  run('cd {{deploy_path}}/current && wp db export {{deploy_path}}/db.sql');
  download('{{deploy_path}}/db.sql', 'db.sql');
  run('rm -f {{deploy_path}}/db.sql');
  runLocally('wp db import db.sql');
  runLocally('rm -f db.sql');
  runLocally('wp search-replace {{remote_url}} {{local_url}} --all-tables');
  runLocally(
    'wp search-replace {{remote_domain}} {{local_domain}} --all-tables'
  );
});

// Push database: dep db:push
task('db:push', function () {
  $sure = askConfirmation(
    'Are you sure you want to overwite the remote database?',
    false
  );
  if (!$sure) {
    die('Task aborted.');
  }

  runLocally('wp db export db.sql');
  upload('db.sql', '{{deploy_path}}');
  runLocally('rm -f db.sql');
  run('cd {{deploy_path}}/current && wp db import {{deploy_path}}/db.sql');
  run(
    'cd {{deploy_path}}/current && wp search-replace {{local_url}} {{remote_url}} --all-tables'
  );
  run(
    'cd {{deploy_path}}/current && wp search-replace {{local_domain}} {{remote_domain}} --all-tables'
  );
  run('rm -f {{deploy_path}}/db.sql');
});

// Pull uploads: dep uploads:pull
task('uploads:pull', function () {
  runLocally(
    'rsync -avz -e "ssh -p {{port}}" {{remote_user}}@{{hostname}}:{{deploy_path}}/shared/web/wp-content/uploads ./web/wp-content'
  );
});

// Push uploads: dep uploads:push
task('uploads:push', function () {
  runLocally(
    'rsync -avz -e "ssh -p {{port}}" ./web/wp-content/uploads {{remote_user}}@{{hostname}}:{{deploy_path}}/shared/web/wp-content'
  );
});

// Purge Varnish
task('purge:varnish', function () {
  run(
    'curl -sX BAN -H "X-Ban-Method: exact" -H "X-Ban-Host: {{ alias }}" http://localhost/ > /dev/null'
  );
});

// Hooks
after('deploy:prepare', 'deploy:build');
after('deploy', 'purge:varnish');
after('deploy:failed', 'deploy:unlock');
