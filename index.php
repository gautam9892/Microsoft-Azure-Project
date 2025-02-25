<?php
session_start();
//error_reporting(0);
include('doctor/includes/dbconnection.php');
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobnum = $_POST['phone'];
    $email = $_POST['email'];
    $appdate = $_POST['date'];
    $aaptime = $_POST['time'];
    $specialization = $_POST['specialization'];
    $doctorlist = $_POST['doctorlist'];
    $message = $_POST['message'];
    $aptnumber = mt_rand(100000000, 999999999);
    $cdate = date('Y-m-d');

    if ($appdate <= $cdate) {
        echo '<script>alert("Appointment date must be greater than todays date")</script>';
    } else {
        $sql = "insert into tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Specialization,Doctor,Message)values(:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:specialization,:doctorlist,:message)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':aptnumber', $aptnumber, PDO::PARAM_STR);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobnum', $mobnum, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':appdate', $appdate, PDO::PARAM_STR);
        $query->bindParam(':aaptime', $aaptime, PDO::PARAM_STR);
        $query->bindParam(':specialization', $specialization, PDO::PARAM_STR);
        $query->bindParam(':doctorlist', $doctorlist, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);

        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Your Appointment Request Has Been Send. We Will Contact You Soon")</script>';
            echo "<script>window.location.href ='index.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Doctor Appointment Management System || Home Page</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/owl.carousel.min.css" rel="stylesheet">

    <link href="css/owl.theme.default.min.css" rel="stylesheet">

    <link href="css/templatemo-medic-care.css" rel="stylesheet">
    <script>
        function getdoctors(val) {
            //  alert(val);
            $.ajax({

                type: "POST",
                url: "get_doctors.php",
                data: 'sp_id=' + val,
                success: function(data) {
                    $("#doctorlist").html(data);
                }
            });
        }
    </script>
    <style>
    .chat-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .chat-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .chat-button:hover {
        background-color: #0056b3;
    }

    .chat-card {
        position: fixed;
        bottom: 80px;
        right: 20px;
        min-width: 300px;
        width: 100%;
        max-width: 400px;
        min-height: 500px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background-color: #007bff;
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        position: relative;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: transparent;
        border: none;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .chat-card iframe {
        flex: 1;
        width: 100%;
        border: none;
        min-height: 500px;
    }

    /* Responsiveness for mobile */
    @media (max-width: 600px) {
        .chat-card {
            min-width: 100%;
            min-height: 400px;
            bottom: 0;
            right: 0;
            border-radius: 0;
        }
    }
</style>

</head>

<body id="top">

    <main>

        <?php include_once('includes/header.php'); ?>

        <section class="hero" id="hero">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="images/slider/portrait-successful-mid-adult-doctor-with-crossed-arms.jpg" class="img-fluid" alt="">
                                </div>

                                <div class="carousel-item">
                                    <img src="images/slider/young-asian-female-dentist-white-coat-posing-clinic-equipment.jpg" class="img-fluid" alt="">
                                </div>

                                <div class="carousel-item">
                                    <img src="images/slider/doctor-s-hand-holding-stethoscope-closeup.jpg" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <section class="section-padding" id="about">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-md-6 col-12">
                        <?php
                        $sql = "SELECT * from tblpage where PageType='aboutus'";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $row) {               ?>
                                <h2 class="mb-lg-3 mb-3"><?php echo htmlentities($row->PageTitle); ?></h2>

                                <p><?php echo ($row->PageDescription); ?>.</p>

                        <?php $cnt = $cnt + 1;
                            }
                        } ?>
                    </div>

                    <div class="col-lg-4 col-md-5 col-12 mx-auto">
                        <div class="featured-circle bg-white shadow-lg d-flex justify-content-center align-items-center">
                            <p class="featured-text"><span class="featured-number">12</span> Years<br> of Experiences</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="gallery">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-6 ps-0">
                        <img src="images/gallery/medium-shot-man-getting-vaccine.jpg" class="img-fluid galleryImage" alt="get a vaccine" title="get a vaccine for yourself">
                    </div>

                    <div class="col-lg-6 col-6 pe-0">
                        <img src="images/gallery/female-doctor-with-presenting-hand-gesture.jpg" class="img-fluid galleryImage" alt="wear a mask" title="wear a mask to protect yourself">
                    </div>

                </div>
            </div>
        </section>





        <section class="section-padding" id="booking">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-12 mx-auto">
                        <div class="booking-form">

                            <h2 class="text-center mb-lg-3 mb-2">Book an appointment</h2>

                            <form role="form" method="post">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Full name" required='true'>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required='true'>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <input type="telephone" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" maxlength="10">
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <input type="date" name="date" id="date" value="" class="form-control">

                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <input type="time" name="time" id="time" value="" class="form-control">

                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <select onChange="getdoctors(this.value);" name="specialization" id="specialization" class="form-control" required>
                                            <option value="">Select specialization</option>
                                            <!--- Fetching States--->
                                            <?php
                                            $sql = "SELECT * FROM tblspecialization";
                                            $stmt = $dbh->query($sql);
                                            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            while ($row = $stmt->fetch()) {
                                            ?>
                                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['Specialization']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="col-lg-6 col-12">
                                        <select name="doctorlist" id="doctorlist" class="form-control">
                                            <option value="">Select Doctor</option>
                                        </select>
                                    </div>



                                    <div class="col-12">
                                        <textarea class="form-control" rows="5" id="message" name="message" placeholder="Additional Message"></textarea>
                                    </div>

                                    <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                        <button type="submit" class="form-control" name="submit" id="submit-button">Book Now</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <?php include_once('includes/footer.php'); ?>
<div class="chat-container">
    <button id="hubspot-chat-widget" class="chat-button" onclick="toggleChat()">
        💬 Chat with us
    </button>
    <div id="chat-card" class="chat-card" style="display: none;">
        <div class="chat-header">
            Chat Support
            <button class="close-button" onclick="toggleChat()">✖</button>
        </div>
        <iframe src='https://webchat.botframework.com/embed/doctor125369-bot?s=lbDSzzVBKxs.r1VHKd5lkwdhA_61h2rc60NvdBJ2758sFQGZ94fetzs'  style='min-width: 400px; width: 100%; min-height: 500px;'></iframe>
    </div>
</div>

<script>
    function toggleChat() {
        const chatCard = document.getElementById("chat-card");
        chatCard.style.display = chatCard.style.display === "none" ? "block" : "none";
    }
</script>
    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/scrollspy.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>