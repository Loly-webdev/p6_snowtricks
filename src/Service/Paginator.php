<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class Paginator
 * @package App\Service
 */
class Paginator
{
    private                        $entity;
    private int                    $limit       = 5;
    private int                    $currentPage = 1;
    private EntityManagerInterface $manager;
    private                        $order;
    private                        $attribute;

    /**
     * Paginator constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return object[]
     */
    public function getData(): array
    {
        if (empty($this->entity)) {
            throw new Exception("L'entité n'a pas été spécifié");
        }
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo   = $this->manager->getRepository($this->entity);

        return $repo->findBy($this->attribute, $this->order, $this->limit, $offset);
    }

    /**
     * @return false|float
     */
    public function getPages()
    {
        if (empty($this->entity)) {
            throw new Exception("L'entité n'a pas été spécifié");
        }
        $repo  = $this->manager->getRepository($this->entity);
        $total = count($repo->findBy($this->attribute));

        return ceil($total / $this->limit);
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param $entity
     *
     * @return $this
     */
    public function setEntity($entity): Paginator
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit(int $limit): Paginator
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     *
     * @return $this
     */
    public function setCurrentPage(int $currentPage): Paginator
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $order
     *
     * @return $this
     */
    public function setOrder($order): Paginator
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param $attribute
     *
     * @return $this
     */
    public function setAttribute($attribute): Paginator
    {
        $this->attribute = $attribute;

        return $this;
    }
}
