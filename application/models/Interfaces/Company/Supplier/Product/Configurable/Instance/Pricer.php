<?php
namespace Interfaces\Company\Supplier\Product\Configurable\Instance;

interface Pricer
{
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Instance $Instance
     */
    public static function price($Instance);
}

?>
