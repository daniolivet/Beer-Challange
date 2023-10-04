<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'../vendor/autoload.php';

if ( ! class_exists( Dotenv::class) ) {
    throw new LogicException( 'Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.' );
}

( new Dotenv( false ) )->loadEnv( dirname( __DIR__ ) . '../.env' );