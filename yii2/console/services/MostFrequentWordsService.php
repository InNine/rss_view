<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 15:55
 */

namespace console\services;

use common\domain\article\repositories\ArticleRepository;

/**
 * Class CommonWordsService
 * @package console\services
 */
class MostFrequentWordsService
{
    /* top 50 as in test task */
    const COMMON_WORDS = ['the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'i', 'it', 'for', 'not', 'on',
        'with', 'he', 'as', 'you', 'do', 'at', 'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she',
        'or', 'an', 'will', 'my', 'one', 'all', 'would', 'there', 'their', 'what', 'so', 'up', 'out', 'if', 'about', 'who',
        'get', 'which', 'go', 'me'];

    public function addFrequentWords()
    {
        $text = $this->makeOneString();
        $this->frequentWords($text);
    }

    /**
     * making one big string without symbols and numbers
     * @return string
     */
    private function makeOneString(): string
    {
        $articles = (new ArticleRepository())->getAllText();
        $text = '';
        foreach ($articles as $article) {
            $title = strtolower(strip_tags($article->title));
            $summary = strtolower(strip_tags($article->summary));
            $text .= ' ' . preg_replace('/[^\p{L}\p{N}\s]/u', '', $title);
            $text .= ' ' . preg_replace('/[^\p{L}\p{N}\s]/u', '', $summary);
        }
        $text = preg_replace('/[0-9]+/', '', $text);
        $text = str_replace('  ', ' ', $text);
        return $text;
    }

    /**
     * calculating most frequent words and caching them
     * @param string $text
     */
    private function frequentWords(string $text)
    {
        $words = explode(' ', $text);
        $wordCount = [];
        foreach ($words as $word) {
            if (in_array($word, self::COMMON_WORDS)) {
                continue;
            }
            key_exists($word, $wordCount) ? $wordCount[$word]++ : $wordCount[$word] = 1;
        }
        arsort($wordCount);
        array_splice($wordCount, 10);
        if (\Yii::$app->cache->exists('frequent_words')) {
            echo 'qwe';
            \Yii::$app->cache->set('frequent_words', $wordCount, 3600);
        } else {
            echo 'add';
            \Yii::$app->cache->add('frequent_words', $wordCount, 3600);
        }
    }
}