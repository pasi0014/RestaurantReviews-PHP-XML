<?php

function ValidateCity($city)
{
    if(empty($city))
    {
        return "City is required";
    }else
        {
            return "";
        }
}

function ValidateStreetName($streetAddress)
{
    if(empty($streetAddress))
    {
        return "Street Address is required";
    }else
    {
        return "";
    }
}

function ValidateRestName($restName)
{
    if(empty($restName))
    {
        return "Restaurant name is required";
    }else
    {
        return "";
    }
}


function ValidatePostalCode($postalCode) {
    if ($postalCode === "")
    {
        return "Postal code is required";
    }
    if (preg_match("/[a-z]\d[a-z]\ ?\d[a-z]\d$/i", $postalCode) === 1)
    {
        return "";
    }
    return "Postal code is invalid";
}
