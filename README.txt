Email Registration allows users to register and login with their e-mail address
instead of using a separate username in addition to the e-mail address. It will
automatically generate a username based on the e-mail address but that behavior
can be overridden with a custom hook implementation in a site specific module.

INSTALLATION
============

Required step:

1. Enable the module as you normally would.


Optional steps:

2. You will probably want to change the welcome e-mail
    (Administer -> User Management -> User Settings) and replace instances of
    the token !username with !mailto

3. This automatically generated username is still displayed name for posts,
    comments, etc. You can allow your users to change their username by
    going to: (Administer -> User Management -> Access Control) and granting
    the permission to "change own username"
    This privilege allows a user to change their username in "My Account".

4. If a user enters an invalid email or password they will see a message:
 "Sorry, unrecognized username or password. Have you forgotten your password?"
    That message is confusing because it mentions username when all other
    language on the page mentions entering their E-mail. This can be easily
    overridden in your settings.php file with an entry like this:

$conf['locale_custom_strings_en'][''] = array(
  'Sorry, unrecognized username or password. <a href="@password">Have you forgotten your password?</a>' => 'Sorry, unrecognized e-mail or password. <a href="@password">Have you forgotten your password?</a>',
);

5. If you use Behat for testing user scenarios you should override the default
    login behavior so the e-mail address will be used to log in instead of the
    username. To do this you should install the Service Container Extension
    which allows to override the default authentication service from Behat
    Drupal Extension:

    $ composer require --dev friends-of-behat/service-container-extension

    Then add the following to your `behat.yml` configuration file:

default:
  extensions:
    FriendsOfBehat\ServiceContainerExtension:
      imports:
        - "./path/to/modules/contrib/email_registration/behat.services.yml"

    Replace the last line with the actual path to where the Email Registration
    module is located in your project.

    Note that this only works with Behat Drupal Extension 4.x. Older versions do
    not have a way to override the default authentication functionality.



BUGS, FEATURES, QUESTIONS
=========================
Post any bugs, features or questions to the issue queue:

http://drupal.org/project/issues/email_registration

