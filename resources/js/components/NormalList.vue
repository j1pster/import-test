<template>
    <div class="normal-list">
        <div class="normal-list__header">
            <div class="normal-list__cell normal-list__header-item">
            
            </div>
        </div>
        <template v-for="item in items">
            <slot :item="item"></slot>
        </template>
    </div>
</template>

<script setup>

import ListItem from './ListItem.vue';

import { ref } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        required: true
    }
})

</script>

<style lang="scss" scoped>
    .normal-list {
        position: relative;

        &__header {
            width: 100%;
            padding: 14px 23px 14px 51px;

            display: grid;
            grid-gap: 5%;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));

            &--sortable {
                padding-left: 61px;
            }
        }

        &__header {
            padding-bottom: 8px;
        }

        &__header-item {
            color: $c-grey-dark;
            user-select: none;
            cursor: pointer;

            &.active {
                color: $c-blue
            }
            &.inverted {
                svg {
                    transform: rotateZ(180deg)
                }
            }
        }

        &__title {
            margin-right: 5px;
        }

        &__tags {
            padding: 0 20px;
        }

        &__spinner {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%)
        }

        &__drag-handle {
            position: absolute;
            top: 50%;
            left: 8px;
            transform: translateY(-50%)
        }

        &__cell {
            display: flex;
            align-items: center;
            overflow: hidden;

            &--checkbox {
                padding-left: 6px;
                padding-top: 2px;
            }

            &--image {
                overflow: visible;
                img {
                    box-shadow: 0 2px 7px 0 rgba(0,0,0,.1);
                    width: 58px;
                    height: 58px;
                }
            }

            &--more {
                justify-content: flex-end;
                overflow: visible;
            }
        }

        &__cell-content {
            a {
                display: flex;
                width: 100%;
                height: 100%;

                align-items: center;

                &:hover {
                    color: $c-blue;
                }
            }
        }

        &__pagination {
            padding-top: 35px;
        }
    }

</style>