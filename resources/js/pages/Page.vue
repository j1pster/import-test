<template>
    <div class="page">
        <template v-if="isLoading">
            Loading...
        </template>
        <template v-else>
            <div class="page__main">
                <div class="page__header">
                    <slot name="header"></slot>
                </div>
                <div class="page__body">
                    <slot name="body"></slot>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: 'page',
    setup () {

        return {}
    },
    components: {
    },
    props: {
        isLoading: {
            type: Boolean,
            default: false,
        },
    }
}
</script>

<style lang="scss" scoped>
.page {
    position: relative;
    flex: 1 1 auto;
    padding: 63px 40px;
    min-height: 100%;

    background: $c-blue-lightest;

    display: flex;
    align-items: flex-start;

    transition: opacity .5s;

    &.page-enter, &.page-leave-to, &.page-leave-active, &.u-hidden {
        opacity: 0
    }

    &__main {
        flex: 1 1 auto;
 
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    &__body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
    }

    &__header {
        display: flex;
        justify-content: space-between;
        min-height: 47px;
        margin-bottom: 43px;
    }
}
</style>