<?php
namespace Victoire\FilterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;


class FilterCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('victoire_cms.filter_chain')) {

            $definition = $container->getDefinition(
                'victoire_cms.filter_chain'
            );

            $taggedServices = $container->findTaggedServiceIds(
                'victoire_cms.filter'
            );
            foreach ($taggedServices as $id => $attributes) {
                $definition->addMethodCall(
                    'addFilter',
                    array(new Reference($id))
                );
            }
        }
    }
}
