<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="float-left font-weight-bold">{{ title }}</div>
            <div class="float-right">{{ created_at }}</div>
        </div>
        <div class="card-body">
            <p>
                {{ content }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'content', 'created_at']
    }
</script>
