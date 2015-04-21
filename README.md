Victoire CMS Filter Bundle
============

Need to add a filter in a victoire cms website ?
Get this filter bundle and so on

First you need to have a valid Symfony2 Victoire edition.
Then you just have to run the following composer command :

    php composer.phar require friendsvictoire/filter-widget

Do not forget to add the bundle in your AppKernel !

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\FilterBundle\VictoireWidgetFilterBundle(),
            );

            return $bundles;
        }
    }
