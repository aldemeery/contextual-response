<?php

namespace Aldemeery\ContextualResponse;

interface ContextualResponseInterface
{
    /**
     * Respond with a relevant response.
     *
     * @return mixed
     */
    public function respond();
}
