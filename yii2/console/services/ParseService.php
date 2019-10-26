<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 1:19
 */

namespace console\services;

use common\domain\article\models\Article;
use common\domain\article\repositories\ArticleRepository;
use common\domain\author\models\Author;
use common\domain\author\repositories\AuthorRepository;

class ParseService
{

    const URL = "https://www.theregister.co.uk/software/headlines.atom";

    private $articleRepo;
    private $authorRepo;

    /**
     * ParseService constructor.
     */
    public function __construct()
    {
        $this->articleRepo = new ArticleRepository();
        $this->authorRepo = new AuthorRepository();
    }

    /**
     * @throws \Exception
     */
    public function parse()
    {
        $response = file_get_contents(self::URL);
        $simpleXML = new \SimpleXMLElement($response);
        foreach ($simpleXML->entry as $entry) {
            $this->entryHandling($entry);
        }

    }

    /**
     * @param \SimpleXMLElement $entry
     * @return bool
     * @throws \Exception
     */
    private function entryHandling($entry)
    {
        $article = (new ArticleRepository())->getOneByParseId($entry->id);
        if ($article) {
            if ($article->parse_updated_at == $entry->updated) {
                return true;
            }
        } else {
            $article = new Article();
        }
        $article->parse_id = (string)$entry->id;
        $article->parse_updated_at = (string)$entry->updated;
        $article->link = (string)$entry->link->attributes()['href'];
        $article->title = (string)$entry->title;
        $article->summary = (string)$entry->summary;
        $article->author_id = $this->authorHandling($entry->author);
        if (!$this->articleRepo->save($article, true)) {
            throw (new \Exception('Error while saving article, check data!'));
        }
        return true;
    }

    /**
     * @param \SimpleXMLElement $entryAuthor
     * @return int
     * @throws \Exception
     */
    private function authorHandling($entryAuthor)
    {
        $author = $this->authorRepo->getOneByNameAndUrl($entryAuthor->name, $entryAuthor->uri);
        if ($author) {
            return $author->id;
        }
        $author = new Author();
        $author->name = (string)$entryAuthor->name;
        $author->url = (string)$entryAuthor->uri;
        if (!$this->authorRepo->save($author, true)) {
            throw (new \Exception('Error while saving author, check data!'));
        }
        return \Yii::$app->db->lastInsertID;
    }
}