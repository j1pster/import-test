<template>
    <Page class="home">
        <template v-slot:header>
            <h1 class="t-page-title">Import records</h1>
        </template>
        <template v-slot:body>
            <DropUpload class="home__drop" :file-types="allowedFiletypes" @dropped="onFilesDroped">
                <div v-if="files.length > 0" class="home__drop-content t-body">
                    <FileList class="home__files" :files="files" @remove="removeFile"></FileList>
                    <Button class="home__upload-btn btn btn--primary" @click="onSubmit">Upload</Button>
                </div>
            </DropUpload>

            <NormalList class="home__list" :items="imports">
                <template #default="props">
                    <ListItem>
                        <div class="list__cell">{{ props.item.name }}</div>
                        <div class="list__cell">{{ props.item.created_at }}</div>
                        <div class="list__cell list__cell" :class="`u-${ statusString(props.item.status) }`">{{ props.item.status }}</div>
                    </ListItem>
                </template>
            </NormalList>
        </template>
    </Page>
</template>

<script setup>

    import { ref, onMounted } from 'vue';
    import Page from './Page.vue';
    import FileList from '../components/FileList.vue';
    import NormalList from '../components/NormalList.vue';
    import ListItem from '../components/ListItem.vue';
    import DropUpload from '../components/DropUpload.vue';
    import axios from 'axios';


    const allowedFiletypes = ref(['application/json']);
    const files = ref([]);

    let imports = ref([]);

    onMounted(() => {
        axios.get('/api/import').then(response => {
            imports.value = response.data;
        }).catch(error => {
            console.log(error);
        })
    });

    function onFilesDroped(droppedFiles) {
        files.value.push(...droppedFiles);
    }

    function removeFile(index) {
        console.log(index);
        files.value.splice(index, 1);
    }

    function statusString(status) {
        let string = '';
        switch(status) {
            case 'processing':
                string = 'warning';
                break;
            case 'completed':
                string = 'success';
                break;
            case 'failed':
                string = 'danger';
                break;
        }

        return string;

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
                file.messageType = 'success';
                imports.value.push(response.data);
                console.log(response);
            }).catch(({ response }) => {
                file.message = response.data.message;
                file.messageType = 'danger';
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

    &__list {
        width: 100%;
        max-width: 800px;
    }
}
</style>