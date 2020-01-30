<template>
    <div class="card card-default mb-3">
        <div class="card-header">
            <div class="float-left font-weight-bold">{{ article.title }}</div>
            <div class="float-right">
                {{ article.created_at }}
                <div class="float-right pl-5" v-if="$auth.check()">
                    <router-link :to="{name: 'admin.update.article', params: {articleId: article._id}}" class="pr-3">Update</router-link>
                    <button type="button" class="close" aria-label="Close" v-on:click.once="deleteArticle">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p>
                {{ article.body }}
            </p>
        </div>
    </div>
</template>

<script>
    import ArticleService from '../services/article.js';
    export default {
        props: ['article'],
        methods: {
            deleteArticle() {
                ArticleService.deleteArticle(this.article._id)
                    .then(response => {
                        app.success = true;
                        this.$emit('delete-article');
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>
