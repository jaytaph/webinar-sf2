<?php

namespace Noxlogic\BlogBundle\Service;

class ColorService implements TransformerInterface {

    public function transformItem($value)
    {
        return "<font color=red>".$value."</font>";
    }

}
