@servers(['web' => 'root@dogeow.com', 'localhost' => '127.0.0.1'])

@setup
$path = '/var/www/antic-api';
$reactPath = '/var/www/antic';
$now = new DateTime();
$environment = isset($env) ? $env : 'testing';
@endsetup

@story('deploy', ['on' => 'web'])
git
composer
laravel
lighthouse
@endstory

@task('git')
cd {{$path}}
git pull
@endtask

@task('composer')
cd {{$path}}
sudo -u www-data composer install --no-plugins --no-scripts
@endtask

@task('laravel')
cd {{$path}}
php artisan migrate --force
php artisan optimize
@endtask

@task('lighthouse')
cd {{$path}}
php artisan lighthouse:clear-cache
php artisan lighthouse:cache
@endtask

@task('react')
cd {{$reactPath}}
git pull
yarn
yarn build
rm -rf static
cp -r build static
@endtask

@finished
echo PHP_EOL;
if ($exitCode > 0) {
echo "有一些错误！";
} else {
echo "新版本发布完成！";
}
@endfinished


