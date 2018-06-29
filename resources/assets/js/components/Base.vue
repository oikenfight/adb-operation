<template>
    <div class="row justify-content-center">
        <div class="col-10" style="padding-top: 40px;">
            <div class="row">
                <div class="col-12 clearfix">
                    <!-- TASK: これ上手くできなかった。。 -->
                    <button @click="stopUpload" class="btn btn-lg btn-outline-secondary float-right" :class="{active: !uploading}" aria-pressed="true">ストップ</button>
                    <button @click="startUpload" class="btn btn-lg btn-outline-primary float-right" :class="{active: uploading}">スタート</button>
                </div>
            </div>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                uploading: false,
            }
        },
        methods: {
            startUpload () {
                this.uploading = true
            },
            stopUpload () {
                this.uploading = false
            },
        },
    }
</script>

<style scoped>

</style>