<template>
    <div class="app">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'App',
    setup () {
        

        return {}
    }
}
</script>

<style lang="scss">
    @import './resources/sass/app.scss';

    .app {
        position: relative;
        width: 100%;
        height: 100%;
    }
</style>