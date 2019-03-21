<?php

const SITE_TITLE = 'CGT Internship Program';

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'cgt456_project01';

/**
 * @return PdoConnection
 */
function env_default_conn()
{
    return new PdoConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
