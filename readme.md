# ADB OPERATION

adb コマンドを利用して Android 端末を遠隔操作するアプリケーション。
Android 端末のスクリーンショットを撮りブラウザ上で表示して、ブラウザからタップやキーボード入力などの操作ができるようにする。

# Getting Started.

### Environment

- git
- git-flow
- hub-flow
- adb
- composer1.6.3
- php7.2
- npm

#### laravel's ".env" files

Copy laravel's ".env" file template.

```bash
$ cp .env.examaple .env
```

#### Directory Permission

Just run following command.

```bash
$ chmod -R 777 storage/
```

#### link public/ to storage/ 
```bash
## in your container
$ php artisan storage:link
```

### Install dependencies

```bash
$ composer install
```

```bash
$ npm install
```

```bash
$ artisan key:generate
```

### server start

```bash
$ php artisan serve --port=8080
```

```bash
## press ctl+c in your container
$ php artisan serve --port=8080
```
