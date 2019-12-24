Usage
=====

Step 1: Create entity
--------------------------

.. code-block:: bash

    $ php bin/console make:entity ...

Step 2: Create form layer for entity
----------------------------------------

.. code-block:: bash

    $ php bin/console make:form-layer

Command will generate basic FormLayer code for you. Next step you can customize it:

.. code-block:: php

    namespace App\FormLayer;

    use Symfony\Component\Validator\Constraints as Assert;
    use Pfilsx\FormLayer\Layer\EntityFormLayer;

    /**
    * @method CustomEntity create(bool $force = false)
    * @method void load(CustomEntity $entity)
    */
    class CustomFormLayer extends EntityFormLayer
    {
        public $id;
        /**
        * @Assert\NotBlank()
        */
        public $field1;

        private $field2;

        public function getField2()
        {
            return $this->field2; // by get... method you can customize how layer should send data to form
        }

        public function setField2($value)
        {
            $this->field2 = $value; // by set... method you can customize how layer should take data from form
            return $this;
        }

        public function loadField2(\DateTime $value)
        {
            $this->field2 = $value->format('d.m.Y'); // by load... method you can customize how layer should take data from entity
        }

        public function saveField2()
        {
            return new \DateTime($this->field2); // by save... method you can customize how layer should send data to entity
        }
    }

Step 3: Use your layer in your controller
----------------------------------------

.. code-block:: php

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
