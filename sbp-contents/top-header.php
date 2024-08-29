<?php include 'globalVar.php'; ?>
<div class="header-area">
            <div class="main-header ">

            <!--Top header starts -->
                <div class="header-top black-bg d-none d-md-block">
                   <div class="container">
                       <div class="col-xl-12">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="header-info-left">
                                    <ul>     
                                    <li><a href="<?= $website ?>/sbp-admin/dashboard/"><i class="fas fa-user"></i> Login</a></li>
                                        <li><img src="<?= $website ?>/assets/img/icon/header_icon1.png" alt=""><span id="displayDate"></span></li>
                                    </ul>
                                </div>
                                <div class="header-info-right">
                                    <ul class="header-social">    
                                        <li><a href="<?php echo $xLink; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="<?php echo $igLink; ?>" target="_blank" ><i class="fab fa-instagram"></i></a></li>
                                       <li> <a href="<?php echo $ldLink; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                                       <li> <a href="<?php echo $fbLink; ?>" target="_blank" ><i class="fab fa-facebook"></i></a></li>
                                       <li> <a href="<?php echo $gitLink; ?>" target="_blank" ><i class="fab fa-github"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                       </div>
                   </div>
                </div>
            <!--Top header ends -->

                <!--Mid header starts -->
                <div class="header-mid d-none d-md-block">
                   <div class="container">
                        <div class="row d-flex align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="logo">
                                    <a href="<?= $website ?>"><img src="<?= $website ?>/assets/img/logo/sb-logo.png" alt="Satyam Blog Logo"></a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <div class="header-banner f-right ">
    <!--
                                 <div class='MainSponsorDiv' data-publisher="eyJpdiI6Ikd3QUUwcVY2Yk13RGp2ZTlLQ1RMMlE9PSIsInZhbHVlIjoiVFkyRXdBZmY0cTNVdHlKS1N1Qnpmdz09IiwibWFjIjoiMmE4NTlmMWU4MDBmNzEyZjdkNjI3NTg1ODQ5ZWRiNmZmODgyMmM0YWE0YzMwMTRhNTJhZjRhMmJhNGRmMDhhMiJ9" data-adsize="728x90"></div> <script class="sponsorScriptClass" src="https://adsdurbar.com/assets/sponsor/sponsor.js"></script>
    -->
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <!--Mid header ends -->

                <!--Bottom header starts -->
               <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                                <!-- sticky -->
                                    <div class="sticky-logo">
                                        <a href="<?= $website ?>"><img src="<?= $website ?>/assets/img/logo/sb-logo.png" alt="Satyam Blog Logo"></a>
                                    </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                   <?php include 'nav-contents.php'; ?>

                                </div>
                            </div>             
                            <div class="col-xl-2 col-lg-2 col-md-4">
                                <div class="header-right-btn f-right d-none d-lg-block">
                                    <i class="fas fa-search special-tag"></i>
                                    <div class="search-box">
                                        <form action="#">
                                            <input type="text" placeholder="Search">
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-md-none"></div>
                            </div>
                        </div>
                    </div>
               </div>
               <!--Bottom header ends -->
            </div>
       </div>