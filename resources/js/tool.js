import Tool from './components/Tool.vue';

Nova.booting((Vue, router) => {
    Vue.component('grouped-resource-collapsable', Tool);
});
