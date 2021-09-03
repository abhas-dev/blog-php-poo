<?php

namespace App;

class Form
{
    public static function begin($action, $method)
    {
        return sprintf('<form action="%s" method="%s">', $action, $method);
    }

    public static function end()
    {
        return '</form>';
    }





//    private string $formCode = '';
//
//    /**
//     * Genere le formulaire HTML
//     *
//     * @return string
//     */
//    public function create()
//    {
//        return $this->formCode;
//    }
//
//    /**
//     * Valid if all the proposed fields are filled in
//     *
//     * @param array $form array returned by the form
//     * @param array $fields list of required fields
//     * @return bool
//     */
//    public static function validate(array $form, array $fields)
//    {
//        foreach ($fields as $field)
//        {
//            if(!isset($field) || $field === null)
//            {
//                return false;
//            }
//        }
//
//        return true;
//    }
//
//    /**
//     * Ajoutes les attributs envoyés a la balise
//     *
//     * @param array $attributes
//     * @return string
//     */
//    public function setAttributes(array $attributes): string
//    {
//        $str = '';
//
//        // On liste les attributs "courts"
//        $shorts = ['checked', 'disable', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formvalidate'];
//
//        // On boucle sur le tableau d'attributs
//        foreach($attributes as $attribute => $value)
//        {
//            // Si l'attributs est dans la liste des attributs courts
//            if(in_array($attribute, $shorts) && $value == true)
//            {
//                $str .= " $attribute";
//            } else{
//                // On ajoute attribut='valeur'
//                $str .= " $attribute='$value'";
//            }
//        }
//
//        return $str;
//    }


}