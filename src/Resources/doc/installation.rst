Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the following
command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require pfilsx/form-layer-bundle

This command requires you to have Composer installed globally, as explained
in the `installation chapter`_ of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the ``app/AppKernel.php``
file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new Pfilsx\FormLayer\FormLayerBundle(),
            );

            // ...
        }

        // ...
    }

.. _`installation chapter`: https://getcomposer.org/doc/00-intro.md
