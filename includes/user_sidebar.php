<!--- card user-sidebar rounded-0 starts -->
<div class="card user-sidebar rounded-0">

    <!-- card-body starts -->
    <div class="card-body">

        <h3>Description</h3>

        <p>
            <?php echo $seller_about; ?>
        </p>

        <hr class="card-hr">

        <h3>Languages</h3>

        <?php if (isset($_SESSION['seller_user_name'])) { ?>

            <?php if ($login_seller_user_name == $seller_user_name) { ?>

                <!-- list-unstyled starts -->
                <ul class="list-unstyled">

                    <li class="mb-4 clearfix">

                        <button data-toggle="collapse" data-target="#language" class="btn btn-success float-right">
                            Add New
                        </button>

                    </li>

                    <!-- language collapse form-style mb-2 starts -->
                    <div id="language" class="collapse form-style mb-2">

                        <!-- form starts -->
                        <form method="post">

                            <!-- form-group starts -->
                            <div class="form-group">

                                <select class="form-control" name="language_id">

                                    <option class="hidden"> Select Language </option>

                                    <?php

                                    $get_languages = "select * from seller_languages";

                                    $run_languages = mysqli_query($con, $get_languages);

                                    while ($row_languages = mysqli_fetch_array($run_languages)) {

                                        $language_id = $row_languages['language_id'];

                                        $language_title = $row_languages['language_title'];

                                        ?>

                                        <option value="<?php echo $language_id; ?>"> <?php echo $language_title; ?> </option>

                                    <?php
                                } ?>

                                </select>

                            </div>
                            <!-- form-group ends -->


                            <!-- form-group starts -->
                            <div class="form-group">

                                <select class="form-control" name="language_level">

                                    <option class="hidden"> Select Level </option>

                                    <option> Basic </option>

                                    <option> Fluent </option>

                                    <option> Conversational </option>

                                    <option> Native </option>

                                </select>

                            </div>
                            <!-- form-group ends -->

                            <!-- text-center starts -->
                            <div class="text-center">

                                <button type="button" data-toggle="collapse" data-target="#language" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" name="insert_language" class="btn btn-success">
                                    Add
                                </button>

                            </div>
                            <!-- text-center ends -->

                        </form>
                        <!-- form ends -->

                        <?php

                        if (isset($_POST['insert_language'])) {

                            $language_id = $_POST['language_id'];

                            $language_level = $_POST['language_level'];

                            $insert_language = "insert into languages_relation (seller_id,language_id,language_level) values ('$seller_id','$language_id','$language_level')";

                            $run_language = mysqli_query($con, $insert_language);
                        }

                        ?>

                    </div>
                    <!-- language collapse form-style mb-2 ends -->

                </ul>
                <!-- list-unstyled ends -->

            <?php
        } ?>

        <?php
    } ?>

        <!-- list-unstyled mt-3 starts -->
        <ul class="list-unstyled mt-3">

            <?php

            $select_languages_relation = "select * from languages_relation where seller_id='$seller_id'";

            $run_languages_relation = mysqli_query($con, $select_languages_relation);

            while ($row_languages_relation = mysqli_fetch_array($run_languages_relation)) {

                $relation_id = $row_languages_relation['relation_id'];

                $language_id = $row_languages_relation['language_id'];

                $language_level = $row_languages_relation['language_level'];

                $get_language = "select * from seller_languages where language_id='$language_id'";

                $run_language = mysqli_query($con, $get_language);

                $row_language = mysqli_fetch_array($run_language);

                $language_title = $row_language['language_title'];

                ?>

                <!--- card-li mb-1 Starts -->
                <li class="card-li mb-1">

                    <?php echo $language_title; ?> - <span class="text-muted"> <?php echo $language_level; ?> </span>

                    <?php if (isset($_SESSION['seller_user_name'])) { ?>

                        <?php if ($login_seller_user_name == $seller_user_name) { ?>

                            <a href="user.php?delete_language=<?php echo $relation_id; ?>">
                                <i class="fa fa-trash-o"></i>
                            </a>

                        <?php
                    } ?>

                    <?php
                } ?>

                </li>
                <!--- card-li mb-1 ends -->

            <?php
        } ?>

        </ul>
        <!-- list-unstyled mt-3 ends -->

        <hr class="card-hr">


        <h3> Skills </h3>

        <?php if (isset($_SESSION['seller_user_name'])) { ?>

            <?php if ($login_seller_user_name == $seller_user_name) { ?>

                <!-- list-unstyled starts -->
                <ul class="list-unstyled">

                    <li class="mb-4 clearfix">

                        <button data-toggle="collapse" data-target="#add_skill" class="btn btn-success float-right">
                            Add New
                        </button>

                    </li>

                    <!-- add_skill collapse form-style mb-2 starts -->
                    <div id="add_skill" class="collapse form-style mb-2">

                        <!-- form Starts -->
                        <form method="post">

                            <!-- form-group starts -->
                            <div class="form-group">


                                <select class="form-control" name="skill_id">

                                    <option class="hidden"> Select Skill </option>

                                    <?php

                                    $get_skills = "select * from seller_skills";

                                    $run_skills = mysqli_query($con, $get_skills);

                                    while ($row_skills = mysqli_fetch_array($run_skills)) {

                                        $skill_id = $row_skills['skill_id'];

                                        $skill_title = $row_skills['skill_title'];

                                        ?>

                                        <option value="<?php echo $skill_id; ?>"> <?php echo $skill_title; ?> </option>

                                    <?php
                                } ?>


                                </select>

                            </div>
                            <!-- form-group ends -->


                            <!-- form-group starts -->
                            <div class="form-group">

                                <select class="form-control" name="skill_level">

                                    <option class="hidden"> Select Level </option>

                                    <option> Beginner </option>

                                    <option> Intermediate </option>

                                    <option> Expert </option>

                                </select>

                            </div>
                            <!-- form-group ends -->

                            <!-- text-center starts -->
                            <div class="text-center">

                                <button type="button" data-toggle="collapse" data-target="#add_skill" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" name="insert_skill" class="btn btn-success">
                                    Add
                                </button>

                            </div>
                            <!-- text-center ends -->

                        </form>
                        <!-- form ends -->

                        <?php

                        if (isset($_POST['insert_skill'])) {

                            $skill_id = $_POST['skill_id'];

                            $skill_level = $_POST['skill_level'];

                            $insert_skill = "insert into skills_relation (seller_id,skill_id,skill_level) values ('$seller_id','$skill_id','$skill_level')";

                            $run_skill = mysqli_query($con, $insert_skill);
                        }


                        ?>

                    </div>
                    <!-- add_skill collapse form-style mb-2 ends -->

                </ul>
                <!-- list-unstyled ends -->

            <?php
        } ?>

        <?php
    } ?>

        <!-- list-unstyled mt-3 starts -->
        <ul class="list-unstyled mt-3">

            <?php

            $select_skills_relation = "select * from skills_relation where seller_id='$seller_id'";

            $run_skills_relation = mysqli_query($con, $select_skills_relation);

            while ($row_skills_relation = mysqli_fetch_array($run_skills_relation)) {

                $relation_id = $row_skills_relation['relation_id'];

                $skill_id = $row_skills_relation['skill_id'];

                $skill_level = $row_skills_relation['skill_level'];

                $get_skill = "select * from seller_skills where skill_id='$skill_id'";

                $run_skill = mysqli_query($con, $get_skill);

                $row_skill = mysqli_fetch_array($run_skill);

                $skill_title = $row_skill['skill_title'];

                ?>

                <!--- card-li mb-1 starts -->
                <li class="card-li mb-1">

                    <?php echo $skill_title; ?> - <span class="text-muted"> <?php echo $skill_level; ?> </span>

                    <?php if (isset($_SESSION['seller_user_name'])) { ?>

                        <?php if ($login_seller_user_name == $seller_user_name) { ?>

                            <a href="user.php?delete_skill=<?php echo $relation_id; ?>">
                                <i class="fa fa-trash-o"></i>
                            </a>

                        <?php
                    } ?>


                    <?php
                } ?>
                </li>
                <!--- card-li mb-1 ends -->

            <?php
        } ?>

        </ul>
        <!-- list-unstyled mt-3 Ends -->

    </div>
    <!-- card-body ends -->

</div>
<!--- card user-sidebar rounded-0 ends -->