<?php
  
  // Replace reelkamghofils@gmail.com with your real receiving email address

  $receiving_email_address = 'reelkamghofils@gmail.com';
  $errors = array();

  function validatePost($post_key, $min_lenght, $max_lenght)
  {
    global $errors;
    if (isset($_POST[$post_key]) && !empty($_POST[$post_key])) {
      if (strlen($_POST[$post_key]) < $min_lenght && strlen($_POST[$post_key]) > $max_lenght) {
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

  // if (!empty($_POST)) {
  //   if (isset($_POST['name']) && !empty($_POST['name'])) {
  //     if (strlen($_POST['name']) < 2 && strlen($_POST['name']) > 30) {
  //        $name = htmlspecialchars($_POST['name']);
  //     } else {
  //       $errors['name'] = 'La taille du nom doit etre entre 2 et 30';
  //     }
  //   } else {
  //       $errors['name'] = 'Vous devez remplire le champ nom';
  //   }

  //   if (isset($_POST['email']) && !empty($_POST['email'])) {
  //     if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  //       $email = htmlspecialchars($_POST['email']);
  //     } else {
  //       $errors['email'] = 'Syntase de l\'email incorette';
  //     }
  //   } else {
  //       $errors['email'] = 'Vous devez remplire le champ email';
  //   }

  //   if (isset($_POST['subject']) && !empty($_POST['subject'])) {
  //     if (strlen($_POST['subject']) < 5 && strlen($_POST['subject']) > 100) {
  //        $subject = htmlspecialchars($_POST['subject']);
  //     } else {
  //       $errors['subject'] = 'La taille du subject doit etre entre 2 et 30';
  //     }
  //   } else {
  //       $errors['subject'] = 'Vous devez remplire le champ nom';
  //   }

  //   if (isset($_POST['message']) && !empty($_POST['message'])) {
  //        $message = htmlspecialchars($_POST['message']);
  //   } else {
  //       $errors['message'] = 'Vous devez remplire le champ message';
  //   }
  // }

  if (empty($errors)) {
    
    $message =
      'Email: ' . $email .
      'Nom: ' .  $name .
      'Message: ' . $message;

    if (mail($receiving_email_address,  $subject,  $message)) {

      echo 'Message envoyer';
    } else {

      echo 'Erreur inconnue';
    }
  }

  var_dump($errors);
  exit();



  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $reelkamghofils = new PHP_Email_Form;
  $reelkamghofils->ajax = true;
  
  
  $reelkamghofils->to = $receiving_email_address;
  $reelkamghofils->from_name = $_POST['name'];
  $reelkamghofils->from_email = $_POST['email'];
  $reelkamghofils->subject = $_POST['subject'];

  /*
  $reelkamghofils->smtp = array(
    'host' => 'gmail.com',
    'username' => 'gmail',
    'password' => 'pass',
    'port' => '587'
  );
  */
  //smtp=simple-mail-transfert-protocol

  $reelkamghofils->add_message( $_POST['name'], 'From');
  $reelkamghofils->add_message( $_POST['email'], 'Email');
  $reelkamghofils->add_message( $_POST['message'], 'Message', 10);

  echo $reelkamghofils->send();
?>
