<template>
    <div class="form-group row">
        <div class="col-4">
            <button @click="back" class="btn btn-outline-secondary btn-block">戻る</button>
        </div>
        <div class="col-4">
            <button @click="enter" class="btn btn-outline-secondary btn-block">決定</button>
        </div>
        <div class="col-4">
            <button @click="home" class="btn btn-outline-secondary btn-block">ホーム</button>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            // TASK: 大きくなってきたから vuex 使うべき…
            back () {
                this.$emit('parentBack')
            },
            enter () {
                this.$emit('parentEnter')
            },
            home () {
                this.$emit('parentHome')
            },
        }
    }
</script>

<style scoped>

</style>