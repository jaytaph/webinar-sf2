<?php

namespace Noxlogic\BlogBundle\Service;

class BlogTransformService {

    protected $transformer;

    public function __construct(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    public function transform(array $blogs) {
        foreach ($blogs as $blog) {
            $blog->setTitle( $this->transformer->transformItem($blog->getTitle()));
        }
    }

}
