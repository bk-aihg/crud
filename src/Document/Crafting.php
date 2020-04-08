<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Crafting
{

    /**
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @MongoDB\Field(type="int")
     */
    protected $itemId;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /**
     * @MongoDB\Field(type="int")
     */
    protected $number;

    /**
     * @MongoDB\Field(type="raw")
     */
    protected $need = [];

    /**
     * @MongoDB\Field(type="string")
     */
    protected $image;

    public function setDetails($itemId, $name, $number, $need, $image)
    {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->number = $number;
        $this->need = $need;
        $this->image = $image;
    }

    public function getItemId(){
        return $this->itemId;
    }
    public function getName(){
        return $this->name;
    }
    public function getNumber(){
        return $this->number;
    }
    public function getNeed(){
        return $this->need;
    }
    public function getImage(){
        return $this->image;
    }


}
