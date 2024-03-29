<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- FontAwsome -->
  <script src="https://kit.fontawesome.com/b24469f289.js" crossorigin="anonymous"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/bootstrap-5.0.2/css/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>/bootstrap-5.0.2/js/bootstrap.min.js" charset="utf-8"></script>

  <!-- TinyMCE -->
  <script src="https://cdn.tiny.cloud/1/715z15p0goo0jibbxy5gev7voi0rekzepfc8fxl97vz2wrpo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <title><?php echo "$page_title"; ?></title>


  <script>
    tinymce.init({
      selector: '#comment',
      menubar: '',
      toolbar: "emoticons",
      plugins: ['emoticons'],
      emoticons_database: 'emojis',
      setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
      }
    });
  </script>
</head>
<body style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
