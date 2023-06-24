<template>
    <Page class="home">
        <template v-slot:header>
            <h1 class="t-heading">Home</h1>
        </template>
        <template v-slot:body>
            <DropUpload class="home__drop" :file-types="allowedFiletypes" @dropped="onFilesDroped">
                <FileList v-if="files.length > 0" :files="files" @remove="removeFile"></FileList>
            </DropUpload>
        </template>
    </Page>
</template>

<script setup>

    import { ref } from 'vue';
    import Page from './Page.vue';
    import FileList from '../components/FileList.vue';
    import DropUpload from '../components/DropUpload.vue';


    const allowedFiletypes = ref(['application/json']);
    const files = ref([]);

    function onFilesDroped(droppedFiles) {
        files.value = droppedFiles;
    }

    function removeFile(index) {
        console.log(index);
        files.value.splice(index, 1);
    }

</script>

<style lang="scss">
.home {

}
</style>