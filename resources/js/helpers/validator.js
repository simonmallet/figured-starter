const ARTICLE_CANNOT_BE_EMPTY = 'Article content cannot be empty. Write something cool!';

export default {
    ARTICLE_CANNOT_BE_EMPTY: ARTICLE_CANNOT_BE_EMPTY,
    isEmptyArticleContent(content) {
        return (content === '' || content === '<p></p>' || content === '<h1></h1>' || content === '<h2></h2>' || content === '<h3></h3>');
    }
}
