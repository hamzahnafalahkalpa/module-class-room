<?php

namespace Hanafalah\Moduletreatment\Concerns;

trait HasClassRoom
{
    protected $__foreign_key = 'treatment_id';

    protected static function bootHasClassRoom() {}

    public function initializeHasClassRoom()
    {
        $this->mergeFillable([
            $this->__foreign_key
        ]);
    }

    //EIGER SECTION
    //END EIGER SECTION

}
