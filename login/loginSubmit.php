<?php
session_start();

if(!isset($_POST['mail']) || !isset($_POST['password'])) {
    header("Location: ../PHP/login.php");
}
require __DIR__ . '/vendor/autoload.php';

use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use LdapRecord\Models\ActiveDirectory\User;

// Create a new connection:
try {
    $connection = new Connection([
        'hosts' => ['dc01.ict.lab.locals', 'dc02.ict.lab.locals'],
        'port' => 389,
        'base_dn' => 'dc=ict,dc=lab,dc=locals',
        'username' => null,
        'password' => null,
    ]);
} catch (\LdapRecord\Configuration\ConfigurationException $e) {
    $_SESSION['loggedIn'] = false;
    header("Location: ../PHP/login.php");
    exit();
}

try {
    $connection->connect();

} catch (\LdapRecord\Auth\BindException $e) {
    $error = $e->getDetailedError();

    echo $error->getErrorCode();
    echo $error->getErrorMessage();
    echo $error->getDiagnosticMessage();
}

if(str_contains($_POST['mail'], '@glr.nl')) {
    $user = str_replace('@glr.nl', '', $_POST['mail']);
}
else {
    $user = $_POST['mail'];
}

$ad_suffix = '@ict.lab.locals';
$password = $_POST['password'];



try {
    if($_SESSION['key'] != $_POST['key']) {
        echo "You are not allowed to login";
        $_SESSION['loggedIn'] = false;
        exit();
    }

    $connection->auth()->bind($user.$ad_suffix, $password);

    // Further bound operations...
    $ldapuser = $connection->query()
        ->where('samaccountname', '=', $user)
        ->firstOrFail();


//    $userGroups = $ldapuser['memberof'];

    try {
        if (isset($ldapuser['memberof'])) {
            $userGroups = $ldapuser['memberof'];
        } else {
            throw new Exception("Invalid user groups");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        $_SESSION['loggedIn'] = false;
        header("Location: ../PHP/login.php");
        exit();
    }


    $allowed = [
        'CN=Docenten MT,OU=Docenten,DC=ict,DC=lab,DC=locals',
        'CN=Docenten,OU=Docenten,DC=ict,DC=lab,DC=locals',
        'CN=studenten,OU=DL groepen,DC=ict,DC=lab,DC=locals',
    ];

    // Normalize the group distinguished names and determine if
    // the user is a member of any of the allowed groups:
    $difference = array_intersect(
        array_map('strtolower', $userGroups),
        array_map('strtolower', $allowed)
    );

    if (count($difference) > 0) {

        //if it is a Docent give it admin rights
        if (in_array('CN=Docenten,OU=Docenten,DC=ict,DC=lab,DC=locals', $difference)) {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['admin'] = true; //CHANGE THIS TO FALSE WHEN DONE TESTING
        }
        $_SESSION['mail'] = $user . "@glr.nl";
        $_SESSION['name'] = $ldapuser['displayname'][0];
        $_SESSION['loggedIn'] = true;
        header("Location: ../PHP/FAQ.php");

        die("You are logged in");

    } else {
        echo "You are not allowed to login";
        $_SESSION['loggedIn'] = false;
        header("Location: ../PHP/login.php");
    }
    exit();

} catch (Exception $e) {
    echo $e->getMessage();
    $_SESSION['loggedIn'] = false;
    header("Location: ../PHP/login.php");
    exit();
}
