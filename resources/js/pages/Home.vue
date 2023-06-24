<template>
    <Page class="home">
        <template v-slot:header>
            <h1 class="t-title">Home</h1>
        </template>
        <template v-slot:body>
            <DropUpload class="home__drop" :file-types="allowedFiletypes" @dropped="onFilesDroped">
                <div v-if="files.length > 0" class="home__drop-content t-body">
                    <FileList class="home__files" :files="files" @remove="removeFile"></FileList>
                    <Button class="home__upload-btn btn btn--primary" @click="onSubmit">Upload</Button>
                </div>
            </DropUpload>
        </template>
    </Page>
</template>

<script setup>

    import { ref } from 'vue';
    import Page from './Page.vue';
    import FileList from '../components/FileList.vue';
    import DropUpload from '../components/DropUpload.vue';
    import axios from 'axios';


    const allowedFiletypes = ref(['application/json']);
    const files = ref([]);

    function onFilesDroped(droppedFiles) {
        files.value.push(...droppedFiles);
    }

    function removeFile(index) {
        console.log(index);
        files.value.splice(index, 1);
    }

    function onSubmit() {
        
        files.value.forEach(file => {

            if(file.uploadedAlready) {
                return;
            }

            const formData = new FormData();
            formData.append('file', file.file);

            axios.post('/api/import', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                file.message = 'Succesfully uploaded'
                console.log(response);
            }).catch(error => {
                file.message = 'Failed to upload'
                console.log(error);
            }).finally(() => {
                file.uploading = false;
                file.uploadedAlready = true;
            })
        });

    }

</script>

<style lang="scss">
.home {
    display: flex;

    &__drop {
        width: 100%;
        max-width: 800px;
    }

    &__drop-content {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    &__files {
        width: 100%;
        margin-bottom: 1em;
    }
}
</style>