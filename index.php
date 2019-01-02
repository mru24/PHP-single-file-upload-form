<?php
  Define('TITLE', 'WW Project Studio | Learn PHP');
  $success = false;
  $fail = false;
  $msg = '';

  if(isset($_POST['submit'])):
    // Upload folder location
    $dir = 'images/';
    $sub = $_POST['subfolder'].'/';
    $filesize = $_FILES['file']['size'];
    $filetype = array(
      'image/gif',
      'image/jpeg',
      'image/pjpeg'
    );
    $dirOK = false;
    $sizeOK = false;
    $typeOK = false;

    // check and create folder when necessary
    if(file_exists( $dir . $sub )):
      $dirOK = true;
    else:
      if(!mkdir( $dir . $sub, 0777, true)):
        die('Failed to create folder');
      else:
        $dirOK = true;
      endif;
    endif;
    // check file size
    if($filesize < 1572864):
      $sizeOK = true;
    endif;
    // check file type
    foreach ($filetype as $permitted):
      if($permitted == $_FILES['file']['type']):
        $typeOK = true;
        break;
      endif;
    endforeach;


    if(!$dirOK):
      $fail = true;
      $msg = 'Folder could not be created';
    else:
      if(!$sizeOK):
        $fail = true;
        $msg = 'Image size can not be greater than 1.5 MB';
      else:
        if(!$typeOK):
          $fail = true;
          $msg = 'Acceptable file types: gif, jpg';
        else:
          if(!move_uploaded_file( $_FILES['file']['tmp_name'], $dir . $sub . $_FILES['file']['name'])):
            die([
              $fail = true,
              $msg = 'Failed to copy image'
            ]);
          else:
            $success = true;
            $msg = 'File copied';
          endif;

        endif;

      endif;

    endif;

  endif;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo TITLE; ?></title>
  </head>

<!-- Styles -->

  <style media="screen">
    body
    {
      font-family: sans-serif;
      background: #f5f5f5;
    }
    #demo
    {
      width: 80%;
      margin: auto;
    }
    form
    {
      width: 60%;
      margin: 40px auto;
      padding: 20px;
      border: 1px solid #999;
      border-radius: 4px;
      box-shadow: 0 0 25px #999;
      background: #fafafa;
      text-align: center;
    }
    .title
    {
      border-bottom: 1px solid #bbb;
      padding: 5px;
    }
    label
    {
      display: block;
      width: 100%;
      text-align: left;
      margin-bottom: 10px;
    }
    select, input
    {
      width: 100%;
    }
    select
    {
      text-transform: capitalize;
    }
    input, select
    {
      height: 30px;
    }
    button
    {
      margin-top: 20px;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      background: #43a736;
      color: white;
      transition: .4s;
      cursor: pointer;
    }
    button:hover
    {
      background: #3bd427;
    }
    @media only screen and (max-width: 700px){
      #demo
      {
        width: 100%;
      }
      form
      {
        width: 90%;
      }
    }
    .success, .fail
    {
      border-radius: 5px;
      color: white;
      text-align: center;
      animation: fadeIn 0.7s;
      margin: auto;
    }
    .success
    {
      background: #3ec640;
      border: 4px solid #17aa18;
    }
    .fail
    {
      background: #d53838;
      border: 4px solid #a71717;
    }
    .msgText
    {
      padding: 30px 0;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        width: 0;
      }
      to {
        opacity: 1;
        width: 100%;
      }
    }
  </style>


  <body>
    <div id="demo">
      <form action="" method="post" enctype="multipart/form-data">
        <h3 class="title">Single file upload form</h3>
        <p>
          <input type="file" name="file">
          <label><small>Maximum file size 1.5 MB</small></label>
        </p>
        <p>
          <select name="subfolder">
            <option value="cats">cats</option>
            <option value="cars">cars</option>
            <option value="computers">computers</option>
          </select>
        </p>
        <p>
          <button type="submit" name="submit">Submit</button>
        </p>
      </form>

<!-- Success or fail messages -->
<?php
  if($success):
?>
      <div class="success">
        <h2 class="msgText"><?php echo $msg; ?></h2>
      </div>
<?php
  endif;

  if($fail):
?>
      <div class="fail">
        <h2 class="msgText"><?php echo $msg; ?></h2>
      </div>
<?php
  endif;
?>
    </div>

<!-- Scripts -->

    <script type="text/javascript"></script>

  </body>
</html>
