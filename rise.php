<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
{   
    header("Location: index.php"); 
}else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RISE | Focus on Failures</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
    <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
    <link rel="stylesheet" href="css/main.css" media="screen" >
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        .fail-row { background-color: #ffe6e6; }
        .fail-row:hover { background-color: #ffcccc; }
        .slider-container { margin: 20px auto; text-align:center; max-width:700px; }
        .slider-value { font-weight:bold; font-size:18px; margin-top:10px; }
        input[type="range"] { width:100%; }
    </style>
</head>
<body class="top-navbar-fixed">
<div class="main-wrapper">

    <!-- Top Navbar -->
    <?php include('includes/topbar.php');?> 

    <div class="content-wrapper">
        <div class="content-container">

            <!-- Sidebar -->
            <?php include('includes/leftbar.php');?>  

            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-6">
                            <h2 class="title">RISE - Students Needing Attention</h2>
                            <p class="sub-title">Slide to select marks and focus on students scoring below that mark.</p>
                        </div>
                    </div>
                </div>

                <!-- Slider OUTSIDE the panel -->
                <div class="slider-container">
                    <label for="marksRange">Marks Range (0-100)</label>
                    <input type="range" id="marksRange" min="0" max="100" value="35" step="1">
                    <div class="slider-value">
                        Showing students with marks ≤ <span id="selectedMarks">35</span>
                    </div>
                </div>

                <section class="section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Focus on Students</h5>
                                        </div>
                                    </div>

                                    <div class="panel-body p-20">

                                        <!-- Table inside the panel -->
                                        <div class="table-responsive">
                                            <table id="riseTable" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th>Roll No</th>
                                                        <th>Class</th>
                                                        <th>Subject</th>
                                                        <th>Marks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td colspan="6" style="text-align:center;color:gray;">Move the slider to load students</td></tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/DataTables/datatables.min.js"></script>
<script src="js/main.js"></script>

<script>
    function fetchStudents(marks) {
        $.ajax({
            url: "fetch_students.php",
            type: "GET",
            data: { marks: marks },
            success: function(response) {
                $("#riseTable tbody").html(response);
            }
        });
    }

    $(document).ready(function(){
        let initialMarks = $("#marksRange").val();
        fetchStudents(initialMarks);

        $("#marksRange").on("input", function(){
            let selectedMarks = $(this).val();
            $("#selectedMarks").text(selectedMarks);
            fetchStudents(selectedMarks);
        });

        $('#riseTable').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false
        });
    });
</script>
</body>
</html>
<?php } ?>
