<template>
    <div class="row justify-content-center">
        <div class="col-10" style="padding-top: 40px;">
            <!-- パンくず -->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ name: 'index' }">Home</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                            Date
                        </li>
                    </ol>
                </div>
            </div>

            <!-- タイトル -->
            <div>
                <h2>スクリーンショット一覧</h2>
            </div>

            <!-- コンテンツ -->
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-sm-4">name</th>
                            <th class="">image</th>
                        </tr>
                        </thead>
                        <tbody v-for="image in images">
                            <tr>
                                <td>
                                    <router-link :to="{ name:'show', params:{date:date, image:image} }">{{ image }}</router-link>
                                </td>
                                <td>
                                    <img :src="getSrc(image)" class="img-fluid" :alt="image">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                images: [],
                date: this.$route.params.date,
            }
        },
        created() {
            axios.get('/api/list/' + this.date)
                .then(response => {
                    this.images = response.data.images
                })

            Echo.channel('upload.screen.shot')
                .listen('.upload.screen.shot.event', (e) => {
                    console.log(e.filename + ' is uploaded.')
                    this.images.unshift(e.filename)
                });
        },
        methods: {
            getSrc(image) {
                return '/storage/' + this.date + '/' + image + '.png'
            }
        }
    }
</script>

<style scoped>

</style>