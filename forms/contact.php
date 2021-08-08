<?php
  
  // Replace reelkamghofils@gmail.com with your real receiving email address

  $receiving_email_address = 'reelkamghofils@gmail.com';
  $errors = array();

  function validatePost($post_key, $min_lenght, $max_lenght)
  {
    global $errors;
    if (isset($_POST[$post_key]) && !empty($_POST[$post_key])) {
      if (strlen($_POST[$post_key]) > $min_lenght && strlen($_POST[$post_key]) < $max_lenght) {
         return htmlspecialchars($_POST[$post_key]);
      } else {
        $errors[$post_key] = 'La taille du ' . $post_key . ' doit etre entre ' . $min_lenght . ' et ' . $max_lenght;
      }
    } else {
        $errors[$post_key] = 'Vous devez remplire le champ ' . $post_key;
    }
  }

  $name = validatePost('name', 2, 30);
  $subject = validatePost('subject', 5, 100);
  $message = validatePost('message', 5, 10000);

  if (isset($_POST['email']) && !empty($_POST['email'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $email = htmlspecialchars($_POST['email']);
    } else {
      $errors['email'] = 'Syntase de l\'email incorette';
    }
  } else {
    $errors['email'] = 'Vous devez remplire le champ email';
  }


if (empty($errors)) {

    $message =
        'Email: ' . $email .
        ' | Nom: ' .  $name .
        ' | Message: ' . $message;

    if (mail($receiving_email_address,  $subject,  $message)) {

        die('Message envoyer');
    } else {

        die('Erreur inconnue');
    }
}
?>