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

        <!-- コンテンツ -->
        <div class="row">
            <div class="offset-3 col-6">
                <img :src="imageSrc" class="img-fluid" :alt="image">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                date: this.$route.params.date,
                image: this.$route.params.image,
                imageSrc: ''
            }
        },
        created() {
            this.imageSrc = '/storage/' + this.date + '/' + this.image + '.png'
        },
    }
</script>

<style scoped>

</style>