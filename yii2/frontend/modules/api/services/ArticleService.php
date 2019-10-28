<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.10.2019
 * Time: 12:08
 */

namespace frontend\modules\api\services;

use common\domain\article\repositories\ArticleRepository;

class ArticleService
{

    public function getArticleData($page)
    {
        $repository = new ArticleRepository();

        $articleCount = $repository->getCountForList(); // get articles count
        $pages = round($articleCount / 5, 0, PHP_ROUND_HALF_UP); // get number of pages
        if ($page > $pages) {
            $page = $pages; // or we can just throw an exception
        }
        $offset = ($page - 1) * 5;
        $articles = $repository->getAllForList(5, $offset); // returning 5 max articles each page

        // get most frequent words
        $words = [];
        if (\Yii::$app->cache->exists('frequent_words')) {
            $words = \Yii::$app->cache->get('frequent_words');
        }

        return [
            'articles' => $articles,
            'words' => $words,
            'page_count' => $pages,
            'page' => $page
        ];
    }
}