<?php


namespace App\Entity;


abstract class AbstractYandexEntity
{
    protected $code;
    protected $title;
    protected $id;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return AbstractYandexEntity
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return AbstractYandexEntity
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    abstract public function setRelation(AbstractYandexEntity $entity = null);
}