import{
    ArticleListHandler,

}from './article';


if (document.getElementById('article-search-form')) {
    new ArticleListHandler({
        indexRoute: AppData.ArticlesIndexRoute,
        csrfToken: AppData.csrfToken,
    });
}
