<template>
    <div class="file-list">
        <div class="file-list__header">
            <span class="file-list__title t-small-title">Files</span>
        </div>
        <div class="file-list__body">
            <div v-for="(file, index) in props.files" class="file-list__item">
                <span class="file-list__item-name t-body">{{ file.name }}</span>
                <span class="file-list__item-size t-body t-small">{{ file.size }}</span>
                <button class="file-list__remove t-button t-button--danger" @click="removeItem(index)">x</button>
            </div>
        </div>
    </div>
</template>

<script setup>
    const emit = defineEmits(['remove']);
    const props = defineProps({
        'files': {
            type: Array,
            default: () => [],
        }
    })

    function removeItem(index) {
        emit('remove', index);
    }
</script>

<style lang="scss" scoped>
.file-list {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: flex-start;

    &__header {
        margin-bottom: 1em;
    }

    &__body {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        grid-gap: 1em;
        width: 100%;
    }

    &__item {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px 10px;
        border: 1px solid $c-blue-light;
        border-radius: 4px;
    }

    &__remove {
        position: absolute;
        right: 0px;
        top: 0px;
        transform: translate(50%, -50%);
        background-color: $c-white;
        border: 1px solid $c-blue-light;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;

        &:hover {
            background-color: $c-blue-light;
            color: $c-white;
        }
    }
}
</style>