<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Blog
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $blogId;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $title;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $date;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $author;

    /**
     * @MongoDB\Field(type="raw")
     */
    protected $comments = [];

    public function setDetails($blogId, $title, $description, $date, $author, $comments)
    {
        $this->blogId = $blogId;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->author = $author;
        $this->comments = $comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getBlogId(){
        return $this->blogId;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getDate(){
        return $this->date;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getComments(){
        return $this->comments;
    }

}
