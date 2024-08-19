<?php

declare(strict_types=1);

namespace Faster\Model;

/**
 * DbPaginationInterface
 * -----------
 * DbPaginationInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Model
 */
interface DbPaginationInterface
{    
    /**
     * pageCount
     *
     * @return int
     */
    public function pageCount(): int;    
    /**
     * recordCount
     *
     * @return int
     */
    public function recordCount(): int;    
    /**
     * perPage
     *
     * @return int
     */
    public function perPage(): int;    
    /**
     * currentPage
     *
     * @return int
     */
    public function currentPage(): int;   
    /**
     * currentRecordCount
     *
     * @return int
     */
    public function currentRecordCount(): int;
    /**
     * offset
     *
     * @return int
     */
    public function offset(): int;    
    /**
     * html
     *
     * @return string
     */
    public function html(): string;
}
