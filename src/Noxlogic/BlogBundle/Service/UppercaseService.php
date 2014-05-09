<?php

namespace Noxlogic\BlogBundle\Service;

class UppercaseService implements TransformerInterface {

    public function transformItem($value)
    {
        return strtoupper($value);
    }

}
