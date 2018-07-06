<template>
    <div class="col-10" style="padding-top: 40px;">
        <!-- パンくず -->
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link :to="{ name: 'index' }">Home</router-link>
                    </li>
                    <li class="breadcrumb-item">
                        <router-link :to="{ name: 'list', params: {date: date} }">Date</router-link>
                    </li>
                    <li class="breadcrumb-item active">
                        Show
                    </li>
                </ol>
            </div>
        </div>

        <!-- タイトル -->
        <div>
            <h2>スクリーンショット</h2>
        </div>

        <div>
            <p>currentXY: ({{ mouse.current.x }}, {{ mouse.current.y }})</p>
            <p>previousXY: ({{ mouse.previous.x }}, {{ mouse.previous.y }}), ..... dragToXY: ({{ mouse.dragTo.x }}, {{ mouse.dragTo.y }})</p>
        </div>

        <div>
            <img id="image-preview" :src="imageSrc"
                 v-on:mousedown="mouseDown"
                 v-on:mouseup="mouseUp"
                 v-on:mousemove="mouseMove"
                 v-on:mouseout="mouseOut"
                 draggable="false"
            />
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                date: this.$route.params.date,
                image: this.$route.params.image,
                imageSrc: '',
                position: {
                    left: 0,
                    top: 0,
                    right: 0,
                    bottom: 0,
                },
                enable: false,
                mouse: {
                    down: false,
                    current: {
                        x: 0,
                        y: 0,
                    },
                    previous: {
                        x: 0,
                        y: 0,
                    },
                    dragTo: {
                        x: 0,
                        y: 0,
                    },
                    setPreviousXY (x, y) {
                        this.previous.x = x
                        this.previous.y = y
                    },
                    setDragToXY (x, y) {
                        this.dragTo.x = x
                        this.dragTo.y = y
                    },
                    clearCurrentXY () {
                        this.current.x = 0
                        this.current.y = 0
                    },
                    clearXY () {
                        this.current.x = 0
                        this.current.y = 0
                        this.previous.x = 0
                        this.previous.y = 0
                        this.dragTo.x = 0
                        this.dragTo.y = 0
                    },
                }
            }
        },
        mounted() {
            this.imageSrc = '/storage/' + this.date + '/' + this.image + '.png'
            // this.getPosition()
        },
        methods: {
            mouseDown (event) {
                console.log('mouse down')
                this.mouse.setPreviousXY(this.mouse.current.x, this.mouse.current.y)
                this.mouse.down = true;
            },
            mouseUp (event) {
                console.log('mouse up')
                if (this.enabled && this.mouse.down) {
                    this.mouse.setDragToXY(this.mouse.current.x, this.mouse.current.y)
                    // TASK: tap or drag
                    this.tap(this.mouse.previous.x, this.mouse.previous.y)
                } else if (!this.enabled && this.mouse.down) {
                    this.clear()
                }
                this.mouse.down = false
            },
            mouseMove (event) {
                console.log('mouse move')
                this.currentXY(event)
                if (!this.enabled) {
                    console.log(this.enabled)
                    this.enabled = true
                }
            },
            mouseOut (event) {
                console.log('mouse out')
                this.enabled = false
                if (this.mouse.down) {
                    this.clear()
                }
                this.clearCurrentXY()
            },
            clear () {
                this.mouse.clearXY()
            },
            clearCurrentXY() {
                this.mouse.clearCurrentXY()
            },
            currentXY (event) {
                const mouseX = event.pageX    // X座標
                const mouseY = event.pageY    // Y座標

                // 要素の位置を取得
                const elem = event.target || event.srcElement || window.event.target || window.event.srcElement || element
                const rect = elem.getBoundingClientRect()

                // 要素の位置座標を計算
                const positionX = rect.left + window.pageXOffset    // 要素のX座標
                const positionY = rect.top + window.pageYOffset    // 要素のY座標

                // 要素の左上からの距離を計算
                const offsetX = mouseX - positionX
                const offsetY = mouseY - positionY

                this.mouse.current.x = offsetX
                this.mouse.current.y = offsetY

                return this.mouse.current
            },
            tap (x, y) {
                // TASK maxX, maxY は表示している画像のサイズから自動で挿入する
                axios.get('/api/tap', {
                    params: {
                        x: x,
                        y: y,
                        maxX: 300,
                        maxY: 600,
                    }
                }).then(response => {
                    console.log(response)
                })
            },
        },
    }
</script>

<style scoped>
    #image-preview {
        width: 300px;
        height: 600px;
    }
</style>