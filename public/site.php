<?php

const CGT_PAGE_DEFAULT = 'page-default';
const CGT_PAGE_FORM = 'page-form';
const CGT_PAGE_FORM_SM = 'page-form-sm';

function site_header($title = '', $page_type = CGT_PAGE_DEFAULT)
{
    global $PAGE_TITLE, $PAGE_TYPE;

    $PAGE_TITLE = $title;
    $PAGE_TYPE = $page_type;

    include_once 'header.php';
}
