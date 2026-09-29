<?php

class Token
{
    private int $idToken;
    private string $tokenHash;
    private string $token;
    private int $idUtilisateur;

    function __construct(int $idToken, string $tokenHash, string $token, int $idUtilisateur)
    {

    }
}