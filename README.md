Victoire DCMS Filter Bundle
============

##What is the purpose of this bundle

This bundle gives you access to the *Filter Widget*.

##Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/setup.md)*

##Install the Bundle

Run the following composer command :

    php composer.phar require friendsofvictoire/filter-widget

###Reminder

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

**Create your custom filter with VictoireFilterBundle**

[VictoireFilterBundle](https://github.com/victoire/victoire/blob/master/Bundle/FilterBundle/README.md)

**Manage ExtraFields for your custom Filter**

[ManageExtrafields](https://github.com/FriendsOfVictoire/WidgetFilterBundle/doc/manageExtraFields.md)
