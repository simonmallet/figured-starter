<template>
    <div class="card card-default mb-3">
        <div class="card-header">
            <div class="float-left font-weight-bold">{{ title }}</div>
            <div class="float-right">
                {{ created_at }}
                <div class="float-right pl-5" v-if="$auth.check()">
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
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
