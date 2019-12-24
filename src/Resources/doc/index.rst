Getting started with FormLayerBundle
========================================

Overview
--------

The bundle integrates special layer between your doctrine entities and forms for `Symfony`_ project. It
automatically registers all FormLayer classes as services, so you can wire it.

Here, an example how to use FormLayer:

.. code-block:: php

    use App\FormLayer\CustomFormLayer;

    ...

    public function update(CustomFormLayer $layer, CustomEntity $entity): Response
    {
        $layer->load($entity);
        $form = $this->createForm(CustomType::class, $layer);
        // ... your code with form and if form is submitted and valid
            $layer->update(); // updates props in associated entity
            $this->getDoctrine()->getManager()->flush(); // for example
        return $this->render('entity/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

.. toctree::

    installation
    usage

.. _`Symfony`: http://symfony.com/
