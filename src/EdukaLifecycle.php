<?php

namespace Eduka\Abstracts;

abstract class EdukaLifecycle
{
    /**
     * Returns the current authenticated visitor.
     *
     * @return null|Eduka\Analytics\Models\Visitor
     */
    protected function visitor()
    {
    }
}
