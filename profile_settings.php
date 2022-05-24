<?php

@session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

?>

<h2 class="mb-4"> Profile Settings </h2>

<!-- form starts -->
<form method="post" enctype="multipart/form-data">

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Full Name </label>

        <div class="col-md-8">

            <input type="text" name="seller_name" value="<?php echo $login_seller_name; ?>" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Email </label>

        <div class="col-md-8">

            <input type="text" name="seller_email" value="<?php echo $login_seller_email; ?>" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Country </label>

        <div class="col-md-8">

            <input type="text" name="seller_country" value="<?php echo $login_seller_country; ?>" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Main Conversational Language </label>

        <div class="col-md-8">

            <select name="seller_language" class="form-control" required>

                <?php if ($login_seller_language == 0) { ?>

                    <option class="hidden"> Select Language </option>

                    <?php

                    $get_languages = "select * from seller_languages";

                    $run_languages = mysqli_query($con, $get_languages);

                    while ($row_languages = mysqli_fetch_array($run_languages)) {

                        $language_id = $row_languages['language_id'];

                        $language_title = $row_languages['language_title'];

                        ?>

                        <option value="<?php echo $language_id; ?>"> <?php echo $language_title; ?> </option>

                    <?php } ?>


                <?php } else { ?>


                    <?php

                    $get_languages = "select * from seller_languages where language_id='$login_seller_language'";

                    $run_languages = mysqli_query($con, $get_languages);

                    $row_languages = mysqli_fetch_array($run_languages);

                    $language_id = $row_languages['language_id'];

                    $language_title = $row_languages['language_title'];

                    ?>

                    <option value="<?php echo $language_id; ?>">
                        <?php echo $language_title; ?>
                    </option>


                    <?php

                    $get_languages = "select * from seller_languages where not language_id='$login_seller_language'";

                    $run_languages = mysqli_query($con, $get_languages);

                    while ($row_languages = mysqli_fetch_array($run_languages)) {

                        $language_id = $row_languages['language_id'];

                        $language_title = $row_languages['language_title'];

                        ?>

                        <option value="<?php echo $language_id; ?>"> <?php echo $language_title; ?> </option>

                    <?php } ?>


                <?php } ?>

            </select>

        </div>

    </div>
    <!-- form-group row ends -->


    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Profile Photo </label>

        <div class="col-md-8">

            <input type="file" name="profile_photo" class="form-control">

            <p class="mt-2">
                This photo is your identity on FreeBird<br>
                and it appears on your profile and proposals.
            </p>

            <?php if (!empty($login_seller_image)) { ?>

                <img src="user_images/<?php echo $login_seller_image; ?>" width="80" class="img-thumbnail img-circle">

            <?php } else { ?>

                <img src="user_images/empty-image.png" width="80" class="img-thumbnail img-circle">


            <?php } ?>

        </div>

    </div>
    <!-- form-group row ends -->


    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label"> Headline </label>

        <div class="col-md-8">

            <textarea name="seller_headline" id="textarea-headline" rows="2" class="form-control" maxlength="150"> <?php echo $login_seller_headline; ?> </textarea>

            <span class="float-right mt-1">

                <span class="count-headline"> 0 </span> / 150 MAX

            </span>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-3 col-form-label">
            Description
            <span class="text-muted">
                (SOMETHING ABOUT YOU)
            </span>
        </label>

        <div class="col-md-8">

            <textarea name="seller_about" id="textarea-about" rows="5" class="form-control" maxlength="300"> <?php echo $login_seller_about; ?> </textarea>

            <span class="float-right mt-1">

                <span class="count-about"> 0 </span> / 300 MAX

            </span>

        </div>

    </div>
    <!-- form-group row ends -->

    <hr>

    <button type="submit" name="submit" class="btn btn-success float-right">

        <i class="fa fa-user-md"></i> Save Changes

    </button>

</form>
<!-- form ends -->

<script>
    $(document).ready(function() {

        $("#textarea-headline").keydown(function() {

            var textarea_headline = $("#textarea-headline").val();

            $(".count-headline").text(textarea_headline.length);


        });

        $("#textarea-about").keydown(function() {

            var textarea_about = $("#textarea-about").val();

            $(".count-about").text(textarea_about.length);


        });


    });
</script>



<?php

if (isset($_POST['submit'])) {

    $seller_name = mysqli_real_escape_string($con, $_POST['seller_name']);

    $seller_email = mysqli_real_escape_string($con, $_POST['seller_email']);

    $seller_country = mysqli_real_escape_string($con, $_POST['seller_country']);

    $seller_language = mysqli_real_escape_string($con, $_POST['seller_language']);

    $seller_headline = mysqli_real_escape_string($con, $_POST['seller_headline']);

    $seller_about = mysqli_real_escape_string($con, $_POST['seller_about']);

    $profile_photo = $_FILES['profile_photo']['name'];

    $profile_photo_tmp = $_FILES['profile_photo']['tmp_name'];


    move_uploaded_file($profile_photo_tmp, "user_images/$profile_photo");

    if (empty($profile_photo)) {

        $profile_photo = $login_seller_image;
    }

    $update_proposals = "update proposals set language_id='$seller_language' where proposal_seller_id='$login_seller_id'";

    $run_proposals = mysqli_query($con, $update_proposals);


    $sel_languages_relation = "select * from languages_relation where seller_id='$login_seller_id' and language_id='$seller_language'";

    $run_languages_relation = mysqli_query($con, $sel_languages_relation);

    $count_languages_relation = mysqli_num_rows($run_languages_relation);

    if ($count_languages_relation == 0) {

        $insert_language = "insert into languages_relation (seller_id,language_id,language_level) values ('$login_seller_id','$seller_language','conversational')";

        $run_language = mysqli_query($con, $insert_language);
    }


    $update_seller = "update sellers set seller_name='$seller_name',seller_email='$seller_email',seller_image='$profile_photo',seller_country='$seller_country',seller_headline='$seller_headline',seller_about='$seller_about',seller_language='$seller_language' where seller_id='$login_seller_id'";

    $run_seller = mysqli_query($con, $update_seller);

    if ($run_seller) {

        echo "<script>alert('Your Profile Settings Has Been Updated.');</script>";

        echo "<script>window.open('settings.php?profile_settings','_self')</script>";
    }
}

?>