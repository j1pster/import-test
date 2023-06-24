<template>
    <div class="drop-upload" :class="{ 'drop-upload--active' : active }" @dragenter.prevent="setDragActive" @dragover.prevent="setDragActive" @dragleave.prevent="setDragInactive" @drop.prevent="onDrop">
        <div v-if="active" class="drop-upload__content">
            <span class="drop-upload__title t-small-title">Drop files to add them</span>
            <span v-if="fileTypes.length > 0" class="drop-upload__body t-body">
                Allowed file types: {{ allowedTypesString }}
            </span>
        </div>
        <div v-else class="drop-upload__content">
            <span class="drop-upload__title t-small-title">Drag Files here</span>
            <span v-if="fileTypes.length > 0" class="drop-upload__body t-body">
                Allowed file types: {{ allowedTypesString }}
            </span>

            <div v-if="showError" class="drop-upload__error t-body u-danger">
                One or more files has an invalid type
            </div>
        </div>

        <slot></slot>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';

    const emit = defineEmits(['dropped']);
    const props = defineProps({
        fileTypes: {
            type: Array,
            default: () => [],
        }
    });

    let active = ref(false);
    let showError = ref(false);

    const allowedTypesString = computed(() => {
        return props.fileTypes.map(type => {
            return `.${type.split('/')[1]}`;
        }).join(', ');
    });

    function onDrop(e) {

        let files = [...e.dataTransfer.files];

        debugger;
        if (props.fileTypes.length > 0) {
            const allowedFiles = files.filter(file => {
                return props.fileTypes.includes(file.type);
            });

            if (allowedFiles.length !== files.length) {
                showError.value = true;
            } else {
                showError.value = false;
            }

            if (allowedFiles.length === 0) {
                return setDragInactive();
            }

            files = allowedFiles;
        }

        files = formatFiles(files);

        emit('dropped', files);
        return setDragInactive();
    }

    function formatFiles(files) {
        return files.map(file => {
            return {
                name: file.name,
                type: file.type,
                size: formattedSize(file.size, 2),
                message: null,
            }
        });
    }

    function formattedSize(a, b) {
        if (a == 0) return '0 Bytes'; 
        const c = 1024; 
        const d = b || 2; 
        const e = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const f = Math.floor(Math.log(a) / Math.log(c)); 
        return parseFloat((a / (c ** f)).toFixed(d)) + ' ' + e[f];
    }

    function setDragActive() {
        active.value = true;
    }

    function setDragInactive() {
        active.value = false;
    }

</script>

<style lang="scss" scoped>
.drop-upload {
    position: relative;
    background: $c-blue-lightest;
    border: 1px dashed $c-blue-light;
    border-radius: 4px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    cursor: pointer;

    &--active {
        background: $c-white;
        border: 1px solid $c-blue-light;
    }

    &__content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 2em;
        margin-bottom: 2em;
    }

    &__title {
        margin-bottom: 1em;
    }
}

</style>