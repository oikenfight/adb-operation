<template>
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                <div class="col-4">
                    <button @click="show" class="btn btn-outline-secondary btn-block">{{ btnValue }}</button>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    {{ inputableMessage }}
                </div>
            </div>

            <div v-show="showForm" class="form-group row">
                <div class="col-12">
                    <label class="col-form-label" for="inputTextArea">Input Text</label>
                    <textarea v-model="inputText" class="form-control" id="inputTextArea" rows="3"></textarea>
                </div>
            </div>
            <div v-show="showForm" class="form-group row">
                <div class="col-12">
                    <button @click="input" type="button" class="btn btn-primary float-right">送信</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showForm: false,
                inputableMessage: '',
                keyboardShown: false,
                inputText: ''
            }
        },
        methods: {
            show () {
                if (!this.showForm) {
                    // 「入力」ボタンを押して、フォームを開く場合
                    axios.get('/api/inputable')
                        .then((response) => {
                            console.log(response)
                            this.showForm = true
                            this.inputableMessage = '入力可能です。'
                        }).catch((error) => {
                            console.log(error)
                            this.showForm = false
                            this.inputableMessage = '端末にキーボードが表示されていません。操作し直してください。'
                        })
                } else {
                    // 「閉じる」ボタンを押して、フォームを閉じる場合
                    this.showForm = false
                    this.inputableMessage = ''
                }
            },
            input () {
                this.$emit('parentInput', this.inputText)
                this.inputText = ''
                this.showForm = false
                this.inputableMessage = ''
            },
        },
        computed: {
            btnValue () {
                return this.showForm ? '閉じる' : 'キーボード入力'
            },
        }
    }
</script>

<style scoped>

</style>