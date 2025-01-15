<?php 
function assets_url()
{
    if($_SERVER['CI_ENV'] == 'development')
    {
        return base_url();
    }
    else
    {
        return 'https://d2ug6sq6fhwt5k.cloudfront.net/';
    }
    
}