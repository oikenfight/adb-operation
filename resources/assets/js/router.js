import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

export default new VueRouter ({
    routes: [
        {
            path: '/',
            name: 'index',
            component: require('./components/Index'),
        },
        {
            path: '/:date',
            name: 'list',
            component: require('./components/List'),
        },
        {
            path: '/:date/:image',
            name: 'show',
            component: require('./components/Show'),
        },
    ]
})
