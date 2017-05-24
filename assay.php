<?php include "includes/header.php"; ?>
<?php include "LogicLayer/UserManager.php"; ?>
        <?php include "includes/navigation.php"; ?>
        <!-- banner -->
        <link href="css/button.css" rel="stylesheet" type="text/css" media="all" />
        <div class="banner page-head">
            <div class="logo">
                <h1><a href="index.php">DEU CURE</a></h1>
            </div>
            <div class="search">
            <?php 
            if(!isset($_SESSION['user_role']))
                echo "<a href='login.php'><i class='glyphicon glyphicon-user'></i></a>";
            else{
                //Emergency Module web service.
                //echo "<a target='_blank' href='emergency.php?tc={$_SESSION['tc']}&firstName={$_SESSION['firstName']}&surName={$_SESSION['surName']}&address={$_SESSION['address']}' id='' title='Call An Ambulance'><i class='glyphicon glyphicon-plus'></i></a>";
                //Emergency Module web service.
                $userTc = $_SESSION['tc'];
                $userFirstName = $_SESSION['firstName'];
                $userSurname = $_SESSION['surName'];
                $userAddress = $_SESSION['address'];
                $emergencyInfoArray = array();
                array_push($emergencyInfoArray, array("tc"=>$userTc, "firstName"=>$userFirstName, "surname"=>$userSurname, "address"=>$userAddress));
                $allInfoToEmergency = json_encode(array('Emergency'=>$emergencyInfoArray));
                //echo $allInfoToEmergency;
                echo "<a target='_blank'  href='emergency.php?Emergency={$allInfoToEmergency}' id='' title='Call An Ambulance'><i class='glyphicon glyphicon-plus'></i></a>";
            }
            ?>
            </div>  
            <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
            <div id="small-dialog" class="mfp-hide">
                <div class="search-top">
                    <div class="login">
                        <input type="submit" value="">
                        <input type="text" value="Type something..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">		
                    </div>			
                </div>
                <script>
                    $(document).ready(function() {
                    $('.popup-with-zoom-anim').magnificPopup({
                        type: 'inline',
                        fixedContentPos: false,
                        fixedBgPos: true,
                        overflowY: 'auto',
                        closeBtnInside: true,
                        preloader: false,
                        midClick: true,
                        removalDelay: 300,
                        mainClass: 'my-mfp-zoom-in'
                    });

                    });
                </script>				
            </div>
        </div>
        <!-- //banner -->
        <br>
        <br>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="form-style-6" style=" background: white;">
                        <form action="assay.php" method="get">
                            <input type="hidden" name="assayNum" value="true"/>
                            <input type="submit"value="Display My Assay Number">
                        </form>
                    </div>
                    <br/>
                    <div class="form-style-6">
                    <h1>Show Assay Result</h1>
                    <form  action="assay2.php" method="post">
                    <input type="text" name="assayNumber" placeholder="Assay Number" />
                    <input type="submit" value="Show" />
                    </form>
                    </div>
                    <!--<form action="assay2.php" method="post">
                        <table>
                            <tr>
                                <td>
                                    Assay Number : 
                                </td>
                                <td>
                                    <input type="text" name="assayNumber" required/>
                                </td>
                                <td>
                                    <input type="submit" value="Get Assay Result" />
                                </td>
                            </tr>
                        </table>
                    </form>-->
                </div>
                
            </div>
        </div>
        <?php
                if(isset($_POST['allResult'])){
                    $results = json_decode($_POST['allResult'], true);
                    $assayType = $results['Assays'][0]['AssayType'];
                    $assayDate = $results['Assays'][0]['AssayDate'];
                    $assayResult = $results['Assays'][0]['AssayResult'];
                    ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>TC</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Assay Type</th>
                                        <th>Assay Date</th>
                                        <th>Assay Reslut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $_SESSION['tc'];?>
                                        </td>
                                        <td>
                                            <?php echo $_SESSION['firstName'];?>
                                        </td>
                                        <td>
                                            <?php echo $_SESSION['surName'];?>
                                        </td>
                                        <td>
                                            <?php echo $assayType;?>
                                        </td>
                                        <td>
                                            <?php echo $assayDate;?>
                                        </td>
                                        <td>
                                            <?php echo $assayResult;?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <?php
                     if(isset($_GET['assayNum'])){
                         ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>TC</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Assay Numbers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $assays = UserManager::getAssayNumbers($_SESSION['tc']);
                                for($i = 0; $i < count($assays); $i++) { 
                                    echo "<tr>";
                                        echo "<td>{$_SESSION['tc']}</td>";
                                        echo "<td>{$_SESSION['firstName']}</td>";
                                        echo "<td>{$_SESSION['surName']}</td>";
                                        echo "<td>{$assays[i]->tc}</td>";
                                    echo "</tr>";
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                         
                     }
                ?>     
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php include "includes/footer.php"; ?>