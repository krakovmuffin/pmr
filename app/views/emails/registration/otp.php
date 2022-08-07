<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title><?= __("Here's your one-time password") ?></title>
    </head>
    <body>
        <p><?= __("Howdy,") ?></p>

        <p><?= __("You recently attempted to create a new account.") ?></p>

        <p><?= __("So here's a private one-time password to confirm your identity :") ?></p>

        <p><strong><?= $params['otp'] ?></strong></p>

        <p><?= __("Don't waste time, this password will be valid only for 15 minutes.") ?></p>

        <p><?= __("If you did not originate this one-time password request, contact us immediately.") ?></p>

        <p><?= __("Enjoy your stay,") ?></p>

        <p><?= __("PMR") ?></p>
    </body>
</html>
