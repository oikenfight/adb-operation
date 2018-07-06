まだ、実験中。

Docker file にまとめてないし、 docker-compose から使うにはとか、 VM の手順とか、 Docker for mac だったらどうかとか、色々抜けてるけど、手元の環境でとりあえず adb on docker が出来てので、その時の作業ログです。

### 成功したっぽいやつ


http://gw.tnode.com/docker/docker-machine-with-usb-support-on-windows-macos/

を読むと、  `--usbxhci on` ってあって、 `VirtualBox Extension Pack` を使ってる場合は必要らしくて、

https://macbootcamp.net/virtualbox/extension-pack-install.html

を読むと、 USB2 とかのサポートがあるらしいから、インストールした。

その上で、再度 VM 作りからやってみる。


```
$ docker-machine create -d virtualbox adb-on-docker-review
$ docker-machine-static-ip --ip 192.168.99.103 adb-on-docker-review
$ docker-machine ls
NAME                     ACTIVE   DRIVER       STATE     URL                         SWARM   DOCKER        ERRORS
adb-on-docker-review     *        virtualbox   Running   tcp://192.168.99.103:2376           v18.05.0-ce
```

VM の USB support を enable に。

`VirtualBox Extension Pack` も入れたので、 `--usbxhci on` でやる。

一旦 VM を止める必要があるらしい。

停止後に `vboxmanage modifyvm adb-on-docker-review --usbxhci on` して、再度起動させる。

```
$ docker-machine stop adb-on-docker-review
Stopping "adb-on-docker-review"...
Machine "adb-on-docker-review" was stopped.
$ vboxmanage modifyvm adb-on-docker-review --usbxhci on
$ docker-machine start adb-on-docker-review
```

で、ここで mac に Android Device を接続して認識させる。(手動。前もって指しておいても良い、と思う。)

で、認識されてる USB の確認をし、その値を使って Filter を追加する。

```
$ vboxmanage list usbhost
Host USB Devices:

UUID:               a83eef5a-6497-4fd2-903f-057b931aec59
VendorId:           0x12d1 (12D1)
ProductId:          0x107e (107E)
Revision:           2.153 (02153)
Port:               2
USB version/speed:  0/High
Manufacturer:       HUAWEI
Product:            MHA-L29
SerialNumber:       AHK0217228000695
Address:            p=0x107e;v=0x12d1;s=0x000295efc834577e;l=0x14200000
Current State:      Unavailable

UUID:               f627008d-f343-4a6e-89b9-dcc2455c85f0
VendorId:           0x05ac (05AC)
ProductId:          0x8290 (8290)
Revision:           1.25 (0125)
Port:               3
USB version/speed:  0/Full
Manufacturer:       Broadcom Corp.
Product:            Bluetooth USB Host Controller
Address:            p=0x8290;v=0x05ac;s=0x000295c84e0520d0;l=0x14300000
Current State:      Available

```

だったので、 Manufacturer, Product, VendorId, ProductId を以下のように指定する。

```
$ vboxmanage usbfilter add 0 --target adb-on-docker-review --name 'HUAWEI MHA-L29' --vendorid 0x12d1 --productid 0x107e
```

最後に env を適用。

```
$ eval $(docker-machine env adb-on-docker-review)
```

で、 https://github.com/sorccu/docker-adb に戻る。

```
$ docker run -d --privileged -v /dev/bus/usb:/dev/bus/usb --name adbd sorccu/adb
```

して、

```
$ docker run --rm -ti --net container:adbd sorccu/adb adb devices
List of devices attached

```

たけど、何も出てこねー。。。

しかたないので、一旦 sh で入って lsusb してみる。

```
$ docker run --rm -ti --net container:adbd sorccu/adb sh
/ # lsusb
Bus 001 Device 001: ID 1d6b:0002
Bus 002 Device 001: ID 1d6b:0003
```

なにもつながってないっぽいね。

```
/ # lsusb
Bus 001 Device 001: ID 1d6b:0002
Bus 001 Device 003: ID 12d1:107e
Bus 002 Device 001: ID 1d6b:0003
```

Android の USB を抜き差ししたら1つ増えた。けど、なにこれ？

もう一度 `adb devices` してみる。

```
/ # adb devices
List of devices attached
AHK0217228000695	device
```

何か居た！

container から抜けて、 mac 側から叩いてみる。

```
/ #
$ docker run --rm -ti --net container:adbd sorccu/adb adb devices
List of devices attached
AHK0217228000695	device
```

いた！？

適当な adb コマンドを送ってみる。(ねこあつめ起動)

```
$ docker run --rm -ti --net container:adbd sorccu/adb adb shell am start -n jp.co.hit_point.nekoatsume/.GActivity
```

できたー！
