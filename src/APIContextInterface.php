<?php
/**
 * Copyright (c) 2019.
 *
 * Amandio Khuta Nhamande <amandio16@gmail.com>
 */

namespace Codeonweekends\MPesa;

interface APIContextInterface
{
    /**
     * Generates a base64 encoded token
     *
     */
    public function getToken (): string;

    /**
     * Creates a well formatted URL
     *
     * @return string
     */
    public function getUrl(): string;
}