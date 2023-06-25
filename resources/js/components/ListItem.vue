<template>
    <div class="list-item">
        <slot></slot>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>
    .list-item {
        width: calc(100% - 28px);
        padding: 14px 23px 14px 51px;

        display: grid;
        grid-gap: 5%;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));

        margin-bottom: 5px;
        background: #FFFFFF;
        border: 1px solid #E9EFF4;
        border-radius: 4px;
        position: relative;
    }
</style>