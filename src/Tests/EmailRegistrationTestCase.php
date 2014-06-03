<?php

/**
 * @file
 * Contains \Drupal\email_registration\Tests\EmailRegistrationTestCase.
 */

namespace Drupal\email_registration\Tests;

use Drupal\simpletest\WebTestBase;

class EmailRegistrationTestCase extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('email_registration');

  /**
   * Implementation of getInfo().
   */
  public static function getInfo() {
    return array(
      'name' => 'Email registration.',
      'description' => 'Test the email registration module.',
      'group' => 'Email registration',
    );
  }

  /**
   * Test various behaviors for anonymous users.
   */
  function testRegistration() {
    $user_config = $this->container->get('config.factory')->get('user.settings');
    $user_config
      ->set('verify_mail', FALSE)
      ->set('register', USER_REGISTER_VISITORS)
      ->save();
    // Try to register a user.
    $name = $this->randomName();
    $pass = $this->randomName(10);
    $register = array(
      'mail' => $name . '@example.com',
      'pass[pass1]' => $pass,
      'pass[pass2]' => $pass,
    );
    $this->drupalPost('/user/register', $register, t('Create new account'));
    $this->drupalLogout();

    $login = array(
      'name' => $name . '@example.com',
      'pass' => $pass,
    );
    $this->drupalPost('user/login', $login, t('Log in'));

    // Really basic confirmation that the user was created and logged in.
    $this->assertRaw('<title>' . $name . ' | Drupal</title>', t('User properly created, logged in.'));

    // Now try the immediate login.
    $this->drupalLogout();
    $user_config
      ->set('verify_mail', FALSE)
      ->save();
    $name = $this->randomName();
    $pass = $this->randomName(10);
    $register = array(
      'mail' => $name . '@example.com',
      'pass[pass1]' => $pass,
      'pass[pass2]' => $pass,
    );
    $this->drupalPost('/user/register', $register, t('Create new account'));
    $this->assertRaw('Registration successful. You are now logged in.', t('User properly created, immediately logged in.'));
  }

}
