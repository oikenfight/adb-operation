<template>
    <div class="col-12">
        <div @v-if="visible" @click="clear" class="alert" :class="alertType" role="alert">
            {{ message }}
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                visible: false,
                message: '',
                alertType: ''
            }
        },
        methods: {
            set (message, alertType) {
                this.visible = true
                this.message = message
                this.alertType = alertType
            },
            clear () {
                this.visible = false
                this.message = ''
                this.alertType = ''
            },
        },
    }
</script>

<style scoped>

</style>