<?php

namespace CanalTP\MediaManager\Category;

class DefaultCategory extends AbstractCategory
{
    public function __construct()
    {
        parent::__construct();
        $this->id = 'default';
        $this->name = 'Default';
        $this->ressourceId = 'defaults';
    }
}
