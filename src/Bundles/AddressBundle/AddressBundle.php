<?php

namespace Bundles\AddressBundle;

use Bundles\AddressBundle\DependencyInjection\AddressExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AddressBundle.
 */
class AddressBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AddressExtension();
    }
}
