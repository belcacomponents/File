<?php

/**
 *
 */
trait TraitName
{  
    public function files()
    {
        return $this->hasMany(File::class, 'author_id');
    }
}
