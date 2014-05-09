<?php

namespace Noxlogic\BlogBundle\Service;

class ReverseService implements TransformerInterface {

    public function transformItem($value)
    {
        return strrev($value);
    }

}
