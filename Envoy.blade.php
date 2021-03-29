@setup
$now = new DateTime();
$environment = isset($env) ? $env : "testing";
@endsetup

@servers(['web' => 'root@dogeow.com', 'localhost' => '127.0.0.1'])

@story('deploy', ['on' => 'web'])
git
composer
@endstory

@task('git')
cd /var/www/learn-api
git pull
@endtask

@task('composer')
cd /var/www/learn-api
sudo -u www-data composer install --no-plugins --no-scripts
php artisan migrate
@endtask

@after
echo "\r\n新版本发布完成！\r\n";
@endafter
