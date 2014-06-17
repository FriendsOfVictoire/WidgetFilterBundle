<?php

namespace Victoire\Widget\FilterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Victoire\Widget\FilterBundle\DependencyInjection\Compiler\FilterCompilerPass;

/**
 *
 * @author Thomas Beaujean
 *
 */
class VictoireWidgetFilterBundle extends Bundle
{
    /**
     * Build bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FilterCompilerPass());
    }
}
