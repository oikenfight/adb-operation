<template>
    <div class="col-10" style="padding-top: 40px;">
        <!-- パンくず -->
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        Home
                    </li>
                </ol>
            </div>
        </div>

        <!-- タイトル -->
        <div>
            <h2>日程一覧</h2>
        </div>

        <!-- コンテンツ -->
        <div>
            <ul v-for="date in dates">
                <li>
                    <router-link :to="{ name: 'list', params: {date: date} }">{{ date }}</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dates: []
            }
        },
        created() {
            axios.get('/api/index')
                .then(response => {
                    this.dates = response.data.dates
                })
        }
    }
</script>
