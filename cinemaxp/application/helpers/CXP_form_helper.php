<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Always check if the function exists first.
if (!function_exists('custom_form_input'))
{
    function custom_form_input($label = '', $data = '', $value = '', $extra = '')
    {
        // check if $data is an array, if not, make it one.
        is_array($data) OR $data = ['name' => $data];

        // create an ID if one wasn't given.
        array_key_exists('id', $data) OR $data['id'] = uniqid();

        $output = '<div class="form-group row">';
        $output .= form_label($label, $data['id'], ['class' => 'col-sm-2 col-form-label']);
        $output .= '<div class="col-10">';
        $output .= form_input($data, $value, $extra);
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

if (!function_exists('custom_form_upload'))
{
    function custom_form_upload($label = '', $data = '', $value = '', $extra = '')
    {
        // check if $data is an array, if not, make it one.
        is_array($data) OR $data = ['name' => $data];

        // create an ID if one wasn't given.
        array_key_exists('id', $data) OR $data['id'] = uniqid();

        // create a class if one wasn't specified.
        array_key_exists('class', $data) OR $data['class'] = '';
        $data['class'] .= ' custom-file-input';

        $output = '<div class="custom-file">';
        $output .= form_upload($data, $value, $extra);

        if (empty($label)) $label = 'Choose File';
        $output .= form_label($label, $data['id'], ['class' => 'custom-file-label']);
        $output .= '</div>';

        return $output;
    }
}
