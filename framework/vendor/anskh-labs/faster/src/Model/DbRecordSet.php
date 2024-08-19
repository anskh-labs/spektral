<?php

declare(strict_types=1);

namespace Faster\Model;

/**
 * DbRecordSet
 * -----------
 * Storage to store query result with pagination
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Model
 */
class DbRecordSet
{
    private array $rows;
    private DbPaginationInterface $pagination;    
    
    /**
     * __construct
     *
     * @param  array $rows
     * @param  DbPaginationInterface $pagination
     * @return void
     */
    public function __construct(array $rows, DbPaginationInterface $pagination)
    {
        $this->rows = $rows;
        $this->pagination = $pagination;
    }    
    /**
     * rows
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }    
    /**
     * pagination
     *
     * @return DbPaginationInterface
     */
    public function getPagination(): DbPaginationInterface
    {
        return $this->pagination;
    }
}
