Victoire Filter Bundle
============

Need to add a filter in a victoire website ?
Get this filter bundle and so on

First you need to have a valid Symfony2 Victoire edition.
Then you just have to run the following composer command :

    php composer.phar require friendsofvictoire/filter-widget

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

**Create you're custom filter with VictoireFilterBundle**

[VictoireFilterBundle]: https://github.com/victoire/victoire/blob/master/Bundle/FilterBundle/README.md "Readme Victoire Filter"

**Manage ExtraFields for your custom Filter**

[ManageExtrafields]: https://github.com/FriendsOfVictoire/WidgetFilterBundle/doc/manageExtraFields.md "Readme Manage ExtraFields"