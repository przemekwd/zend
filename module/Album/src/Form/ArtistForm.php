<?php

namespace Album\Form;

use Zend\Form\Form as Form;

class ArtistForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('artist');

        $this
            ->add([
                'name' => 'id',
                'type' => 'hidden',
            ])
            ->add([
                'name' => 'name',
                'type' => 'text',
                'options' => [
                    'label' => 'Nazwa',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nazwa',
                ],
            ])
            ->add([
                'name' => 'firstname',
                'type' => 'text',
                'options' => [
                    'label' => 'Imię',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Imię',
                ],
            ])
            ->add([
                'name' => 'lastname',
                'type' => 'text',
                'options' => [
                    'label' => 'Nazwisko',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nazwisko',
                ],
            ])
            ->add([
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => [
                    'value' => 'Dodaj',
                    'id'    => 'submit',
                ],
            ]);/*
            ->add('birth_date', 'text', [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control mb-2 js-datepicker',
                ],
                'label' => Lang::get('artist.form.birthdate_person_band'),
                'required' => true,
            ])
            ->add('country', 'text', [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => Lang::get('artist.form.country'),
                'required' => true,
            ])
            ->add('band', 'checkbox', [
                'label' => Lang::get('artist.form.band'),
                'value' => 1,
                'default' => 1
            ]);*/
        //$this->setAttribute('method', 'GET');
    }
}

