<template>
    <div v-if="hasErrors" class="z-50 bg-black bg-opacity-80 min-h-full h-screen min-w-full w-screen grid place-items-center absolute top-0 left-0 backdrop-filter backdrop-blur-md">
        <div class="p-3 p-top-5 bg-red-600 text-red-200 relative shadow-2xl rounded-md">
            <div class="absolute top-2 right-2 cursor-pointer" @click="this.resetErrors()">
                <div class="rounded-full text-white border-2 border-white text-xl font-bold w-6 h-6 leading-5 font-bold text-center">X</div>
            </div>
            <div class="font-medium text-red-200">Fehler aufgetreten:</div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-200 arrow-list">
                <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            document.addEventListener("keyup",ev => {
                if (ev.code=="Escape") {
                    this.resetErrors()
                    ev.preventDefault()
                }
            })
        },
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        },
        methods: {
            resetErrors() {
                this.$page.props.errors = {}
            }
        },
    }
</script>
