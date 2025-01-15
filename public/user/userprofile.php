<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "guest") {
    header("Location: /public/index.php");
    exit();
}

include_once "../API/user.php";
include_once "../../utils.php";

$db = create_new_database_connection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $faculty = $_POST['faculty'];
    $matric = $_POST['matric'];
    $phone = $_POST['phone'];
    $block = $_POST['block'];
    $bio = $_POST['bio'];
    $profile_pic = $_FILES['profile-pic']['name'];

    // Handle profile picture upload
    if ($profile_pic) {
        $target_dir = "../img/user/";
        $target_file = $target_dir . basename($profile_pic);
        move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_file);
    } else {
        $profile_pic = $user->getUserInfo($_SESSION["email"])["profile_pic"];
    }

    $user->updateUserProfile($_SESSION["email"], $name, $email, $faculty, $matric, $phone, $block, $bio, $profile_pic);
    header("Location: userprofile.php");
    exit();
}

$data = $user->getUserInfo($_SESSION["email"]);
$name = $data["name"];
$email = $data["email"];
$matric = $data["matric"] ?? "Not set";
$gender = $data["gender"];
$profile_picture = $data["profile_pic"];
$faculty = $data["faculty"] ?? "Not set";
$phone = $data["phone"] ?? "Not set";
$residential = $data["residential"] ?? "Not set";
$bio = $data["bio"] ?? "Not set";
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="/public/webicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
    <title>User Profile</title>
    <script src="/public/script.js" defer></script>
    <script src="/public/scripts/userprofilescript.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../modal.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <h1 data-aos="zoom-in">User Profile</h1>
        <div style="height: 650px">
            <div class="userprofile" data-aos="flip-right">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="/public/img/user/<?php echo $profile_picture; ?>" alt="User profile picture" class="profile-image">
                        <h2 class="profile-name"><?php echo $name?></h2>
                        <h4 class="profile-bio"><?php echo $bio; ?></h4>

                        <div class="profile-details">
                            <div class="box">
                                <div class="row">
                                    <span style="color: white"><strong>Email:</strong></span>
                                    <div class="input"><?php echo $email; ?></div>
                                </div>
                                <div class="row">
                                    <span style="color: white"><strong>Matric Num:</strong></span>
                                    <div class="input"><?php echo $matric; ?></div>
                                </div>
                                <div class="row">
                                    <span style="color: white"><strong>Phone Number:</strong></span>
                                    <div class="input"><?php echo $phone; ?></div>
                                </div>
                                <div class="row">
                                    <span style="color: white"><strong>Residential Block:</strong></span>
                                    <div class="input"><?php echo $residential; ?></div>
                                </div>
                                <div class="row">
                                    <span style="color: white"><strong>Faculty</strong></span>
                                    <div class="input"><?php echo $faculty ?></div>
                                </div>

                                <div class="button-wrap-edit"
                                    style="border-top: 1px solid #eee; justify-content: center; ">
                                    <span class="edit-profile-btn" id="edit-profile-btn"><img
                                            src="/public/img/edit_icon.png" style="height: 30px; width: 30x;">Edit
                                        Profile</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flip-box-container">
                        <div class="flip-box">
                            <div class="flip-box-inner">
                                <div class="flip-box-front">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="card-title">Student Lounge Booking Stats</h2>
                                            <p class="card-description">January-December</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <canvas id="barChart" style="height:500px;width: content-box;"></canvas>
                                    </div>
                                    <div class="card-footer">
                                        <div class="trend">
                                            <span>Total Hour Spent on Student Lounge</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flip-box-back">
                                    <div class="edit-profile">
                                        <h2>Edit Profile</h2>
                                        <form action="userprofile.php" method="post" enctype="multipart/form-data">
                                            <label for="name">Name:</label>
                                            <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo $name; ?>"><br>

                                            <label for="email">Email:</label>
                                            <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>"><br>

                                            <label for="faculty">Faculty:</label>
                                            <select id="faculty" name="faculty" placeholder="Enter faculty">
                                            <option value="FSKTM" <?php if ($faculty == "FSKTM") echo "selected"; ?>>FSKTM</option>
                                                <option value="FSTS" <?php if ($faculty == "FSTS") echo "selected"; ?>>FSTS</option>
                                                <option value="FENG" <?php if ($faculty == "FENG") echo "selected"; ?>>FENG</option>
                                                <option value="FMHS" <?php if ($faculty == "FMHS") echo "selected"; ?>>FMHS</option>
                                                <option value="FSKPM" <?php if ($faculty == "FSKPM") echo "selected"; ?>>FSKPM</option>
                                                <option value="FEB" <?php if ($faculty == "FEB") echo "selected"; ?>>FEB</option>
                                                <option value="FELC" <?php if ($faculty == "FELC") echo "selected"; ?>>FELC</option>
                                                <option value="FACA" <?php if ($faculty == "FACA") echo "selected"; ?>>FACA</option>
                                                <option value="FSSH" <?php if ($faculty == "FSSH") echo "selected"; ?>>FSSH</option>
                                                <option value="FBE" <?php if ($faculty == "FBE") echo "selected"; ?>>FBE</option>
                                            </select><br>
                                        
                                            <label for="matric">Matric Number:</label>
                                            <input type="text" id="matric" name="matric" placeholder="Enter matric number" value="<?php echo $matric; ?>"><br>

                                            <label for="phone">Phone Number:</label>
                                            <input type="text" id="phone" name="phone" placeholder="Enter phone number" value="<?php echo $phone; ?>"><br>

                                            <label for="block">Residential Block:</label>
                                            <select id="block" name="block" placeholder="Enter Residential Block">
                                                <option value="Block A" <?php if ($residential == "Block A") echo "selected"; ?>>Block A</option>
                                                <option value="Block B" <?php if ($residential == "Block B") echo "selected"; ?>>Block B</option>
                                                <option value="Block C" <?php if ($residential == "Block C") echo "selected"; ?>>Block C</option>
                                                <option value="Block D" <?php if ($residential == "Block D") echo "selected"; ?>>Block D</option>
                                                <option value="Block E" <?php if ($residential == "Block E") echo "selected"; ?>>Block E</option>
                                                <option value="Block F" <?php if ($residential == "Block F") echo "selected"; ?>>Block F</option>
                                                <option value="Block G" <?php if ($residential == "Block G") echo "selected"; ?>>Block G</option>
                                                <option value="Block H" <?php if ($residential == "Block H") echo "selected"; ?>>Block H</option>
                                                <option value="Block I" <?php if ($residential == "Block I") echo "selected"; ?>>Block I</option>
                                                <option value="Block J" <?php if ($residential == "Block J") echo "selected"; ?>>Block J</option>
                                                <option value="Block K" <?php if ($residential == "Block K") echo "selected"; ?>>Block K</option>
                                                <option value="Block L" <?php if ($residential == "Block L") echo "selected"; ?>>Block L</option>
                                                <option value="Block M" <?php if ($residential == "Block M") echo "selected"; ?>>Block M</option>
                                                <option value="Block N" <?php if ($residential == "Block N") echo "selected"; ?>>Block N</option>
                                                <option value="Block O" <?php if ($residential == "Block O") echo "selected"; ?>>Block O</option>
                                                <option value="Block Q" <?php if ($residential == "Block Q") echo "selected"; ?>>Block Q</option>
                                                <option value="Block R" <?php if ($residential == "Block R") echo "selected"; ?>>Block R</option>
                                                <option value="Block S" <?php if ($residential == "Block S") echo "selected"; ?>>Block S</option>
                                            </select><br>

                                            <label for="bio">Bio:</label>
                                            <input type="text" id="bio" name="bio" placeholder="Enter bio (Not more than 10 words)" value="<?php echo $bio; ?>"><br>

                                            <label for="profile-pic">Profile Picture:</label>
                                            <input type="file" id="profile-pic" name="profile-pic" accept="image/*">

                                            <div class="button-wrap">
                                                <button class="save-profile-btn" id="save-edit"><img src="/public/img/save_icon.png" style="height: 30px; width: 30x;">Save</button>
                                                <button class="cancel-profile-btn" id="cancel-edit"><img src="/public/img/cancel-icon.png" style="height: 30px; width: 30x;">Cancel</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>