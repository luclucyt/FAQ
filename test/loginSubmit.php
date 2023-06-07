<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use LdapRecord\Models\ActiveDirectory\User;

// Create a new connection:
$connection = new Connection([
    'hosts' => ['dc01.ict.lab.locals', 'dc02.ict.lab.locals'],
    'port' => 389,
    'base_dn' => 'dc=ict,dc=lab,dc=locals',
    'username' => null,
    'password' => null,
]);

try {
    $connection->connect();

} catch (\LdapRecord\Auth\BindException $e) {
    $error = $e->getDetailedError();

    echo $error->getErrorCode();
    echo $error->getErrorMessage();
    echo $error->getDiagnosticMessage();
}
$user = $_POST['mail'];

$ad_suffix = '@ict.lab.locals';
$password = $_POST['password'];

try {
    $connection->auth()->bind($user.$ad_suffix, $password);

    // Further bound operations...
    $ldapuser = $connection->query()
        ->where('samaccountname', '=', $user)
        ->firstOrFail();

    $userGroups = $ldapuser['memberof'];

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
            $_SESSION['admin'] = false;
        }
        $_SESSION['name'] = $ldapuser['displayname'][0];
        $_SESSION['loggedIn'] = true;
        echo "<script>alert('Ingeloged')</script>";
        header("Location: ../PHP/FAQ.php");
        exit();

    } else {
        echo "You are not allowed to login";
        $_SESSION['loggedIn'] = false;
        header("Location: ../PHP/login.php");
        exit();
    }

} catch (Exception $e) {
    echo $e->getMessage();
    $_SESSION['loggedIn'] = false;
    header("Location: ../PHP/login.php");
    exit();
}
