<template>
    <div class="row justify-content-center">
        <!--<div class="col-10 clearfix" style="padding-top: 40px;">-->
            <!--&lt;!&ndash; TASK: これ上手くできなかった。。 &ndash;&gt;-->
            <!--<div class="float-right">-->
                <!--<div class="row">-->
                    <!--<div>-->
                        <!--<button @click="startUpload" class="btn btn-lg btn-outline-primary" :class="{active: uploading}">スタート</button>-->
                    <!--</div>-->
                    <!--<div style="padding-left: 10px;">-->
                        <!--<button @click="stopUpload" class="btn btn-lg btn-outline-secondary" :class="{active: !uploading}" aria-pressed="true">ストップ</button>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->

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