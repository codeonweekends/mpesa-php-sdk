<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 *
 */

namespace CodeonWeekends\MPesa\Interfaces;

interface TransactionsInterface
{
    /**
     * This function is responsible for preparing and send the request to MPesa api server
     */
    public function send (): void;
}