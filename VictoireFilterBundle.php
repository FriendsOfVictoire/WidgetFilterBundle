<?php

namespace Victoire\FilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Victoire\FilterBundle\DependencyInjection\Compiler\FilterCompilerPass;

class VictoireFilterBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FilterCompilerPass());
    }
}
