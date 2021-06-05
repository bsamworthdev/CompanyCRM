<template>
    <div v-show="errors.length">
        <p v-for="error in errors" :key="error" class="text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>

<script>
    export default {
        props: ['errors']
    }
</script>
