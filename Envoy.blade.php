@servers(['web' => 'root@dogeow.com', 'localhost' => '127.0.0.1'])

@setup
$now = new DateTime();
$environment = isset($env) ? $env : "testing";
@endsetup

@story('deploy', ['on' => 'web'])
git
composer
laravel
lighthouse
@endstory

@task('git')
cd /var/www/antic-api
git pull
@endtask

@task('composer')
cd /var/www/antic-api
sudo -u www-data composer install --no-plugins --no-scripts
@endtask

@task('laravel')
cd /var/www/antic-api
php artisan migrate --force
php artisan optimize
@endtask

@task('lighthouse')
php artisan lighthouse:clear-cache
php artisan lighthouse:cache
@endtask

@after
echo "\r\n新版本发布完成！\r\n";
@endafter
