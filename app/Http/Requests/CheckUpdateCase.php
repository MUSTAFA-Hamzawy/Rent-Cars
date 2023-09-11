<?php

namespace App\Http\Requests;

trait CheckUpdateCase
{
    /**
     * To check if the request for store or update
     * @return bool
     */
    private function isUpdateCase(): bool{
        return ! is_null($this->route(self::MODULE_NAME));
    }
}
