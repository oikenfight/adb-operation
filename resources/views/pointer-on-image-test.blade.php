<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>Hoge</title>
</head>
<body>
<div>
    <div>
        <h1>dummy title</h1>
    </div>
    <div>
        <img id="image-preview" src="/20180629_203619.png" />
    </div>
    <div>
        dummy2
    </div>
</div>
<script>
    /**
     * Point
     */
    class Point {
        constructor() {
            this._x = null;
            this._y = null;
            this.init();
        }
        init() {
            this._x = 0;
            this._y = 0;
        }
        setX(x) {
            this._x = x;
        }
        setY(y) {
            this._y = y;
        }
    }

    /**
     * ImagePointer
     */
    class ImagePointer {
        constructor(element) {
            this.element = element;
            this.dragging = false;
            this.inPoint = null;
            this.outPoint = null;
        }
        init () {
            this.initPoint();
            this.element.addEventListener('mousedown', event => this.mouseDown(event));
            this.element.addEventListener('mouseup', event => this.mouseUp(event));
            this.element.addEventListener('mousemove', event => this.mouseMove(event));
        }
        initPoint() {
            this.inPoint = new Point();
            this.outPoint = new Point();
        }
        startDragging() {
            this.dragging = true;
        }
        stopDragging() {
            this.dragging = false;
        }
        mouseMove(event) {
            event.preventDefault();
            console.log('mouseMove');
        }
        mouseDown(event) {
            event.preventDefault();
            this.startDragging();
            console.log('mouseDown');
            this.collectXY(event);

            // TODO: 要素外に Drag された時に this.initPoint(); と this.disableDragging(); を行う必要がある
        }
        mouseUp(event) {
            event.preventDefault();
            this.stopDragging();
            console.log('mouseUp');
            this.collectXY(event);
        }

        collectXY(event) {
            // マウス位置を取得する
            const mouseX = event.pageX ;    // X座標
            const mouseY = event.pageY ;    // Y座標

            // 要素の位置を取得
            const elem = event.target || event.srcElement || window.event.target || window.event.srcElement || element;
            const rect = elem .getBoundingClientRect() ;

            // 要素の位置座標を計算
            const positionX = rect.left + window.pageXOffset ;    // 要素のX座標
            const positionY = rect.top + window.pageYOffset ;    // 要素のY座標

            // 要素の左上からの距離を計算
            const offsetX = mouseX - positionX ;
            const offsetY = mouseY - positionY ;

            console.log(offsetX, offsetY);
        }
    }
    const imagePointer = new ImagePointer(document.getElementById('image-preview'));
    imagePointer.init();
</script>
</body>
</html>