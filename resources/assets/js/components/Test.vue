<template>
    <div class="col-11">
        <!-- タイトル -->
        <div>
            <h2>スクリーンショット</h2>
        </div>

        <div class="row card" style="padding-top: 40px;">
            <div class="row">
                <div class="col-5">
                    <div class="col-12">
                        <img id="image-preview" :src="imageSrc"
                             v-on:mousedown="mouseDown"
                             v-on:mouseup="mouseUp"
                             v-on:mousemove="mouseMove"
                             v-on:mouseout="mouseOut"
                             draggable="false"
                        />
                    </div>
                </div>

                <div class="col-7">
                    <div class="col-12">
                        <!-- アラート -->
                        <div class="row">
                            <alert ref="message"></alert>
                        </div>

                        <!-- 座標 -->
                        <div class="row card card-body">
                            <h4>座標</h4>
                            <div class="col-12">
                                <p>マウス: ({{ mouse.current.x }}, {{ mouse.current.y }})</p>
                            </div>
                            <div class="col-12">
                                <p>タッチ: ({{ mouse.clickedAt.x }}, {{ mouse.clickedAt.y }}), ..... スワイプ: ({{ mouse.draggedAt.x }}, {{ mouse.draggedAt.y }})</p>
                            </div>
                        </div>

                        <!-- 操作 -->
                        <div class="row card card-body" style="padding-top: 50px;">
                            <h4>操作</h4>
                            <div class="col-12">
                                <!-- Task: Message component を使うため親コンポーネントでメソッド書いてるけど、vuex やる。 -->
                                <operation @parentBack="back" @parentEnter="enter" @parentHome="home"></operation>
                                <text-form @parentInput="input"></text-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import alert from './Alert'
    import text_form from './TextForm'
    import operation from './Operation'

    export default {
        components: {
            'alert': alert,
            'operation': operation,
            'text-form': text_form
        },
        data() {
            return {
                // date: this.$route.params.date,
                // image: this.$route.params.image,
                imageSrc: '/storage/test.png',
                enable: false,
                mouse: {
                    down: false,
                    current: {
                        x: 0,
                        y: 0,
                    },
                    clickedAt: {
                        x: 0,
                        y: 0,
                    },
                    draggedAt: {
                        x: 0,
                        y: 0,
                    },
                    setPreviousXY (x, y) {
                        this.clickedAt.x = x
                        this.clickedAt.y = y
                    },
                    setDragToXY (x, y) {
                        this.draggedAt.x = x
                        this.draggedAt.y = y
                    },
                    clearCurrentXY () {
                        this.current.x = 0
                        this.current.y = 0
                    },
                    clearXY () {
                        this.current.x = 0
                        this.current.y = 0
                        this.clickedAt.x = 0
                        this.clickedAt.y = 0
                        this.draggedAt.x = 0
                        this.draggedAt.y = 0
                    },
                }
            }
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
                    // tap or swipe
                    this.operateByMouse()
                } else if (!this.enabled && this.mouse.down) {
                    this.clear()
                }
                this.mouse.down = false
            },
            mouseMove (event) {
                console.log('mouse move')
                this.currentXY(event)
                if (!this.enabled) {
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
            operateByMouse () {
                // どの操作をしたのかを判定する
                const distanceX = Math.abs(this.mouse.clickedAt.x - this.mouse.draggedAt.x)
                const distanceY = Math.abs(this.mouse.clickedAt.y - this.mouse.draggedAt.y)

                if (distanceX < 5 && distanceY < 5) {
                    this.tap(this.mouse.clickedAt.x, this.mouse.clickedAt.y)
                } else {
                    this.swipe(this.mouse.clickedAt.x, this.mouse.clickedAt.y, this.mouse.draggedAt.x, this.mouse.draggedAt.y)
                }
            },
            back () {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/back')
                .then((response) => {
                    console.log(response)
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    console.log(error)
                    this.$refs.message.set('操作に失敗しました。', 'alert-danger')
                })
                this.updateScreen()
            },
            enter () {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/enter')
                .then((response) => {
                    console.log(response)
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    console.log(error)
                    this.$refs.message.set('操作に失敗しました。', 'alert-danger')
                })
                this.updateScreen()
            },
            home () {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/home')
                .then((response) => {
                    console.log(response)
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    console.log(error)
                    this.$refs.message.set('操作に失敗しました。', 'alert-danger')
                })
                this.updateScreen()
            },
            tap (x, y) {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/tap', {
                    params: {
                        x: x,
                        y: y,
                        // TASK maxX, maxY は表示している画像のサイズから自動で挿入する
                        maxX: 300,
                        maxY: 600,
                    }
                }).then((response) => {
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    this.$refs.message.set('タップに失敗しました。リロードしてからもう一度試してください。', 'alert-danger')
                })
                this.updateScreen()
            },
            swipe (x, y, toX, toY) {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/swipe', {
                    params: {
                        x: x,
                        y: y,
                        toX: toX,
                        toY: toY,
                        // TASK maxX, maxY は表示している画像のサイズから自動で挿入する
                        maxX: 300,
                        maxY: 600,
                    }
                }).then((response) => {
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    this.$refs.message.set('スワイプに失敗しました。リロードしてからもう一度試してください。', 'alert-danger')
                })
                this.updateScreen()
            },
            input (text) {
                this.$refs.message.set('処理中です。しばらくお待ち下さい。', 'alert-danger')
                axios.get('/api/input', {
                    params: {
                        text: text,
                    },
                }).then((response) => {
                    console.log(response)
                    this.$refs.message.set(response.data.message, 'alert-success')
                }).catch((error) => {
                    console.log(error)
                    this.$refs.message.set('テキストの入力に失敗しました。キーボード入力画面が表示されているか確認してください。', 'alert-danger')
                })
                this.updateScreen()
            },
            updateScreen () {
                const date = new Date()
                this.imageSrc = '/storage/test.png?' + date.getTime()
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