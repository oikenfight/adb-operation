<template>
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                <button @click="show" class="btn btn-outline-secondary">{{ btnValue }}</button>
            </div>
        </div>
        <div class="col-12" v-show="showInput">
            <div class="form-group row">
                <label for="inputTextArea">Input Text</label>
                <textarea v-model="inputText" class="form-control" id="inputTextArea" rows="3"></textarea>
            </div>
            <div class="form-group row">
                <button @click="input" type="button" class="btn btn-primary float-right">送信</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showInput: false,
                keyboardShown: false,
                inputText: ''
            }
        },
        methods: {
            show () {
                this.showInput = !this.showInput
            },
            input () {
                this.$emit('parentInput', this.inputText)
                this.inputText = ''
            },
        },
        computed: {
            btnValue () {
                return this.showInput ? '閉じる' : '入力する'
            },
        }
    }
</script>

<style scoped>

</style>