<?php
$is_mobile = false;
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)) || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')
) {
    $is_mobile = true;
}
$mobile = ($is_mobile == true) ? 'yes' : 'no';
//get data
$ref = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
$domain = isset($_SERVER["HTTP_HOST"]) ? 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] : '';
session_start();

@$_SESSION['id']=isset($_GET["id"])?$_GET["id"] : 837;
$id = $_SESSION['id'];
@$_SESSION['id_campaign']=isset($_GET["id_campaign"])?$_GET["id_campaign"] : $_SESSION['id_campaign'];
$id_campaign =$_SESSION['id_campaign']; 

@$_SESSION['id_landingpage']=isset($_GET["id_landingpage"])?$_GET["id_landingpage"] : $_SESSION['id_landingpage'];
$id_landingpage = $_SESSION['id_landingpage'];
$preview = isset($_GET["preview"]) ? $_GET["preview"] : "-100";
@$_SESSION['code_chanel']=isset($_GET["code_chanel"])?$_GET["code_chanel"] : $_SESSION['code_chanel'];
$code_chanel =$_SESSION['code_chanel']; 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TR???N B??? H?????NG D???N L???P B??O C??O T??I CH??NH N??M 2016 - lakita.vn</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta property="og:url"           content="http://lapbctc2016.lakita.vn" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="TR???N B??? H?????NG D???N L???P B??O C??O T??I CH??NH N??M 2016 - lakita.vn" />
        <meta property="og:description"   content="H??? th???ng ????o t???o tr???c tuy???n lakita ??? C??ng b???n v????n xa H???c Online qua Video b??i gi???ng - H???c Online th???a th??ch m???i l??c, m???i n??i - H???c tr??n m???i thi???t b??? - H???c v???i gi???ng vi??n, chuy??n gia h??ng ?????u trong l??nh v???c - H??a ????n ch???ng t??? - L??m ch??? h??a ????n ch???ng t???" />
        <meta property="og:image"         content="http://lakita.vn/data/source/courses/268x150/tron-bo-huong-dan-lap-bao-cao-tai-chinh-nam-2016.png" />
        <meta name="description" content="H??? th???ng ????o t???o tr???c tuy???n lakita ??? C??ng b???n v????n xa H???c Online qua Video b??i gi???ng - H???c Online th???a th??ch m???i l??c, m???i n??i - H???c tr??n m???i thi???t b??? - H???c v???i gi???ng vi??n, chuy??n gia h??ng ?????u trong l??nh v???c - H??a ????n ch???ng t??? - L??m ch??? h??a ????n ch???ng t???" />
        <link rel="icon" href="favicon.ico" />

        <script src="lakita/js/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"/>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="lakita/js/0b216c5f11.js"></script>
        <script src="lakita/js/lktclock.js" type="text/javascript"></script>
        <script src="lakita/js/jquery.form.js"></script>
        <link href="lakita/css/gg-font.css" rel="stylesheet" type="text/css" />
        <link rel ="stylesheet" type="text/css" href="style.index2.lakita.css" />
        <link rel ="stylesheet" type="text/css" href="styles.css" />
        <link rel ="stylesheet" type="text/css" href="media.css" />
        <link rel ="stylesheet" type="text/css" href="define.css" />
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=315347858825221";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>
    <body style="overflow-x: hidden">
        <header>
            <form role="form" id="fr_save_c2" style="display: none;"  method="post" name="fr_save_c2" action="lakita/save_c2.php">
                <?php
                echo "<INPUT TYPE='hidden' class='e_domain_ref' NAME='http_referer' VALUE='" . $ref . "'>";
                echo "<INPUT TYPE='hidden' NAME='domain' VALUE='" . $domain . "'>";
                echo "<INPUT TYPE='hidden' NAME='id_camp_landingpage' VALUE='" . $id . "'>";
                echo "<INPUT TYPE='hidden' NAME='preview' VALUE='" . $preview . "'>";
                echo "<INPUT TYPE='hidden' NAME='code_chanel' VALUE='" . $code_chanel . "'>";
                echo "<INPUT TYPE='hidden' NAME='id_campaign' VALUE='" . $id_campaign . "'>";
                echo "<INPUT TYPE='hidden' NAME='id_landingpage' VALUE='" . $id_landingpage . "'>";
                ?>
                <button  type="submit" id="bt_submit_c2" class=" e_btn_submit reg_bt btn btn-ows btn-large"></button>
            </form>
            <nav class="navbar">
                <div class="container-fluid nav-menu">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="http://lamchuhoadonchungtu1.lakita.vn/" id="a-img"><img src="img/index/logo.png"></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="#link_bondiemkhacbiet">B???n ??i???m kh??c bi???t</a></li>
                            <li><a href="#link_loiich">L???i ??ch</a></li>
                            <li><a href="#link_giangvien">Gi???ng vi??n</a></li>
                            <li><a href="#link_decuong">????? c????ng kh??a h???c</a></li>
                            <li><a href="#register_now">????ng k?? ngay</a></li>
                            <li><a href="#link_vechungtoi">V??? lakita</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li> <a href="#register_now"><button class="btn btn-success" type="button">????ng k?? ngay</button></a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <div class="gr1">
                <h3 style="    color: #fff;"><strong>TR???N B??? H?????NG D???N L???P B??O C??O T??I CH??NH N??M 2016</strong>
                </h3>
                <p>Kh??a h???c d??nh cho nh??n vi??n h??nh ch??nh v??n ph??ng ki??m k??? to??n trong doanh nghi???p v???a, nh???</p>
            </div>
            <!--        <div class="trans"></div>-->
            <div class="play_hidden hidden-sm hidden-xs">
                <div id="play_demo_1" style="display: none;">
                    <video height="100%"  src="http://lapbctc2016.lakita.vn/trailer.mp4" type="video/mp4"
                           id="player0"
                           controls="controls"
                           >
                    </video>
                </div>

            </div>
            <img src="demo.png" class="play-btn hidden-sm hidden-xs"/>
        </header>
        <div class="container" id="link_bondiemkhacbiet">
            <div class="group2 row">
                <div class="col-md-3 gr2-col-1 col-sm-6 col-xs-12">
                    <img src="img/index2/Layer-2.png">
                    <h4><strong>C???m tay ch??? vi???c
                        </strong></h4>
                    <div id="gr2-text">
                        <p>C??c b??i gi???ng ???????c thi???t k??? theo d???ng c???m tay ch??? vi???c, h???c vi??n c?? th??? th???c h??nh, ??p d???ng ???????c ngay v??o trong c??ng vi???c</p>
                    </div>
                </div>
                <div class="col-md-3 gr2-col-1 col-sm-6 col-xs-12">
                    <img src="img/index2/Layer-3.png">
                    <h4><strong>D??? xem l???i v?? s??? d???ng</strong></h4>
                    <div id="gr2-text">
                        <p>46 video b??i gi???ng, thao t??c v???i 9h h???c online. Gi???i ????p trong 68 gi???</p>
                    </div>
                </div>
                <div class="col-md-3 gr2-col-1 col-sm-6 col-xs-12">
                    <img src="img/index2/Layer-4.png">
                    <h4><strong>H???c Online</strong></h4>
                    <div id="gr2-text">
                        <p>M???i th???i ??i???m, m?? h??nh h???c ti??n ti???n, t????ng t??c li??n t???c: c??ng th???y v?? h??ng tr??m h???c vi??n</p>
                    </div>
                </div>
                <div class="col-md-3 gr2-col-1 col-sm-6 col-xs-12">
                    <img src="img/index2/Layer-5.png">
                    <h4><strong>Kinh nghi???m th???c ti???n</strong></h4>
                    <div id="gr2-text">
                        <p>Th???c ti???n t??? kinh nghi???m t???i Doanh Nghi???p</p>
                    </div>
                </div>
                </section>
            </div>
        </div>
        <div class="container-fluid" id="link_loiich">
            <div class="group3 row">
                <div class="gr3-row-1">
                    <h2><strong>B???N S??? B??? L??? ??I???U G?? N???U KH??NG THAM GIA KH??A H???C N??Y?</strong></h2>
                    <img src="img/index2/gr3-img1.png">
                </div>
                <div class="row gr3-row-2">
                    <div class="col-xs-12 col-sm-5 col-sm-offset-1">
                        <video height="100%"  src="http://lapbctc2016.lakita.vn/kt400-bai2.mp4" type="video/mp4"
                               id="player1"
                               controls="controls">
                        </video>
                    </div>
                    <div class="col-xs-12 col-sm-5 gr3-row2-2">
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> T??ng k??? n??ng trong c??ng vi???c, h???c t???p</strong></p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> C?? h???i th??ng ti???n v?? ph??t tri???n ngh??? nghi???p k??? to??n</strong></p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> 46 video b??i gi???ng h?????ng d???n chi ti???t v???i 9h h???c online</strong> </p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> 100 t??nh hu???ng th???c t??? t???i doanh nghi???p </strong></p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> Th???y C?? tr???c ti???p tr??? l???i th???c m???c c???a h???c vi??n</strong></p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> ???????c h??? tr??? th?????ng xuy??n v???i ?????i ng?? tr??? gi???ng chuy??n nghi???p</strong></p>
                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> H?????ng d???n l???p ????ng v?? 08 b?????c ki???m tra B???ng c??n ?????i ph??t sinh</strong></p>
<!--                        <p><i class="fa fa-check" aria-hidden="true"></i><strong> Qu?? t???ng gi?? tr??? : 01 File Excel ki???m tra b??o c??o t??i ch??nh cho Doanh nghi???p, 14 file excel ph???c v??? quy???t to??n thu??? 2016 </strong></p>-->
                        <a href="#register_now"><button id="gr3-dangki" type="button">????ng k?? ngay</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="group4 container" id="link_giangvien">
            <h1 id="gr4-gv">GI???NG VI??N</h1>
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center" id="GV">
                    <img src="img/index2/ChiNhung.png" class="img-responsive">
                    <p class="name_teacher"><strong>Gi???ng vi??n Ph???m Th??? Nhung</strong></p>
                </div>
                <div class="col-xs-12 col-sm-6" id="kinhnghiem">
                    <ul>
                        <li> <img src="http://biquyetlamchuexcel5.lakita.vn/img/bul-list.png"> <span> Ch???ng ch??? k??? to??n qu???c t??? CAT</span></li>
                        <li> <img src="http://biquyetlamchuexcel5.lakita.vn/img/bul-list.png">
                            <span>
                                K??? to??n t???ng h???p t???i chi nh??nh c??ng ty TNHH D???ch v??? Th???c ph???m v?? Gi???i kh??t C??nh Di???u Xanh, thu???c t???p ??o??n T???p ??o??n Li??n Th??i B??nh D????ng (Imex Pan Pacific Group).
                            </span>
                        </li>
                        <li> <img src="http://biquyetlamchuexcel5.lakita.vn/img/bul-list.png"><span> 4 n??m kinh nghi???m ??? v??? tr?? k??? to??n t???ng h???p ki??m ph??? tr??ch to??n b??? m???ng thu??? </span></li>
                    </ul>
                </div>
            </div>
        </div>
          <div class="container-fluid group5" id="link_decuong">
            <div class="container">
                <h2 class="span-text">N???I DUNG KH??A H???C</h2>
            </div>
           <div class="row my-row-5">
                <div class="col-sm-5 col-sm-offset-1 col-xs-12">
                    <div class="chapter-title">
                        <div> Ph???n 1: 08 nhi???m v??? k??? to??n c???n th???c hi???n t???i th???i ??i???m cu???i k??? </div>
                    </div>
                    <ul>
                        <li>  <span class="bold">B??i 1:</span> Gi???i thi???u kh??a h???c</li>
                        <li>  <span class="bold">B??i 2:</span> 08 nhi???m v??? c???n th???c hi???n cu???i k???</li>
                        <li>  <span class="bold">B??i 3:</span> Th???c h??nh h???ch to??n ti???n l????ng v?? c??c kho???n tr??ch theo l????ng (ph???n 1)</li>
                        <li>  <span class="bold">B??i 4:</span> Th???c h??nh h???ch to??n ti???n l????ng v?? c??c kho???n tr??ch theo l????ng (ph???n 2)</li>
                        <li>  <span class="bold">B??i 5:</span> Nhi???m v??? s??? 2: L???p b???ng t??nh kh???u hao TSC?? v?? b??t to??n tr??ch kh???u hao</li>
                        <li>  <span class="bold">B??i 6:</span> Nhi???m v??? s??? 3: Ph??n b??? C??ng c??? d???ng c???, chi ph?? tr??? tr?????c</li>
                        <li>  <span class="bold">B??i 7:</span> Th???c h??nh l???p b???ng ph??n b??? v?? b??t to??n ph??n b??? CCDC v?? Chi ph?? tr??? tr?????c (b???ng excel)</li>
                        <li>  <span class="bold">B??i 8:</span> Nhi???m v??? s??? 4: Tr??ch tr?????c chi ph??</li>
                        <li>  <span class="bold">B??i 9:</span> Nhi???m v??? s??? 5: K???t chuy???n thu??? GTGT ???????c kh???u tr??? (1331 - 3331) </li>
                        <li>  <span class="bold">B??i 10:</span> Nhi???m v??? 6: T???p h???p chi ph?? gi?? v???n h??ng b??n </li>
                        <li>  <span class="bold">B??i 11:</span> Nhi???m v??? 7: T???m t??nh v?? h???ch to??n thu??? TNDN ph???i n???p </li>
                        <li>  <span class="bold">B??i 12:</span> Nhi???m v??? 8: C??c b??t to??n k???t chuy???n cu???i k??? sang t??i kho???n 911 </li>
                    </ul>
                    <div class="chapter-title">
                        <div> Ph???n 2: H?????ng d???n l???p v?? 09 b?????c ki???m tra b???ng C??n ?????i ph??t sinh t??i kho???n</div>
                    </div>
                    <ul>

                        <li>  <span class="bold">B??i 13:</span> H?????ng d???n l???p b???ng c??n ?????i ph??t sinh t??i kho???n (Ph???n 1)</li>
                        <li>  <span class="bold">B??i 14:</span>  H?????ng d???n l???p b???ng c??n ?????i ph??t sinh t??i kho???n (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 15:</span>  Ki???m tra b???ng C??PS (KT1, KT2) </li>
                        <li>  <span class="bold">B??i 16:</span> Ki???m tra b???ng C??PS - Ki???m tra nh??m t??i kho???n kho 152,153,154,155,156 </li>
                        <li>  <span class="bold">B??i 17:</span> Ki???m tra b???ng C??PS - Ki???m tra nh??m t??i kho???n t??i s???n v?? kh???u hao (211,214)</li>
                        <li>  <span class="bold">B??i 18:</span> Ki???m tra s??? 6: T??i kho???n ti???n m???t (TK 111 ), ti???n g???i ng??n h??ng (TK 112) </li>
                        <li>  <span class="bold">B??i 19:</span> Ki???m tra s??? 7: Nh??m c??c t??i kho???n c??ng n??? (Ph???i thu, ph???i tr???) </li>
                        <li>  <span class="bold">B??i 20:</span> Ki???m tra s??? 8: Ki???m tra t??i kho???n Doanh thu TK 511,521 </li>
                        <li>  <span class="bold">B??i 21:</span> Ki???m tra t??i kho???n Thu??? GTGT 1331,3331 </li>
                    </ul>
                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="chapter-title" style="height: 57px;">
                        <div> Ph???n 3: H?????ng d???n l???p b???ng c??n ?????i k??? to??n</div>
                    </div>
                    <ul>

                        <li>  <span class="bold">B??i 22:</span> T??m hi???u v??? B??o c??o t??i ch??nh </li>
                        <li>  <span class="bold">B??i 23:</span> ?? ngh??a, m???c ????ch c???a B???ng C??n ?????i k??? to??n </li>
                        <li>  <span class="bold">B??i 24:</span> C??n c??? l???p v?? l??u ?? khi L???p b???ng c??n ?????i k??? to??n </li>
                        <li>  <span class="bold">B??i 25:</span> K???t c???u v?? ?? ngh??a t???ng ch??? ti??u tr??n C??KT</li>
                        <li>  <span class="bold">B??i 26:</span> C??ch l???p b???ng C??KT (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 27:</span> C??ch l???p b???ng C??KT (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 28:</span> Th???c h??nh l???p b???ng C??KT tr??n excel (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 29:</span> Th???c h??nh l???p b???ng C??KT tr??n excel (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 30:</span> Th???c h??nh l???p b???ng C??KT tr??n excel (Ph???n 3) </li>
                    </ul>
                    <div class="chapter-title" style="height: 57px;">
                        <div> Ph???n 4:  H?????ng d???n l???p b??o c??o k???t qu??? kinh doanh</div>
                    </div>
                    <ul>
                        <li>  <span class="bold">B??i 31:</span> ?? ngh??a v?? k???t c???u c???a B??o c??o k???t qu??? Kinh Doanh </li>
                        <li>  <span class="bold">B??i 32:</span> H?????ng d???n t??nh thu??? TNDN (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 33:</span> H?????ng d???n t??nh thu??? TNDN (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 34:</span> C??ch l???p b??o c??o k???t qu??? Kinh Doanh (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 35:</span> C??ch l???p b??o c??o k???t qu??? Kinh Doanh (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 36:</span> Th???c h??nh l???p B??o C??o KQKD (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 37:</span> Th???c h??nh l???p B??o C??o KQKD (Ph???n 2) </li>
                    </ul>
                    <div class="chapter-title" style="height: 57px;">
                        <div> Ph???n 5:  H?????ng d???n l???p b??o c??o l??u chuy???n ti???n t???</div>
                    </div>
                    <ul>
                        <li>  <span class="bold">B??i 38:</span> ?? ngh??a B??o c??o l??u chuy???n ti???n t??? </li>
                        <li>  <span class="bold">B??i 39:</span> C??ch l???p B??o C??o l??u chuy???n ti???n t??? (Ph???n 1)</li>
                        <li>  <span class="bold">B??i 40:</span> C??ch l???p B??o C??o l??u chuy???n ti???n t??? (Ph???n 2) </li>
                        <li>  <span class="bold">B??i 41:</span> Th???c h??nh B??o C??o l??u chuy???n ti???n t??? (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 42:</span> Th???c h??nh B??o C??o l??u chuy???n ti???n t??? (Ph???n 2) </li>
                    </ul>
                    <div class="chapter-title" style="height: 57px;">
                        <div> Ph???n 6: H?????ng d???n l???p thuy???t minh b??o c??o t??i ch??nh</div>
                    </div>
                    <ul>
                        <li>  <span class="bold">B??i 43:</span> M???i quan h??? gi???a 3 B??o c??o: C??KT, KQKD v?? L??u chuy???n ti???n t??? </li>
                        <li>  <span class="bold">B??i 44:</span> ?? ngh??a, c??ch l???p Thuy???t minh BCTC </li>
                        <li>  <span class="bold">B??i 45:</span> Th???c h??nh l???p thuy???t minh b??o c??o t??i ch??nh (Ph???n 1) </li>
                        <li>  <span class="bold">B??i 46:</span> Th???c h??nh l???p thuy???t minh b??o c??o t??i ch??nh (Ph???n 2) </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="carousel slide" id="carousel-example-generic" data-ride="carousel" style=" margin-bottom:30px">
            <h1 class="text-center"><strong>C???M NH???N H???C VI??N</strong></h1>
            <div class="carousel-inner" role="listbox">
                <div class="item" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/nguyenthihang1.png">
                    <p>Nguy???n Th??? H???ng</p>
                    <p>Chuy??n vi??n k??? to??n t???i C??ng ty c??? ph???n th????ng m???i v?? v???n t???i ????ng H???i</p>
                    <p id="cmt">"T??i c???m th???y t???t v?? t??i nh???n ???????c nh???ng th??ng tin h???u ??ch m?? m??nh mong mu???n"</p>
                </div>
                <div class="item active" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/nguyenthihuyen1.png">
                    <p>Nguy???n Th??? Huy???n</p>
                    <p>C??ng ty TNHH TM xu???t nh???p kh???u qu???c t??? Nam Trung</p>
                    <p id="cmt">"Kh??a h???c th???t s??? c?? ?? ngh??a. N?? gi??p t??i c???ng c??? th??m ki???n th???c v??? k??? to??n"</p>
                </div>
                <div class="item" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/le-thi-nhan.jpg">
                    <p>L?? Th??? Nh??n</p>
                    <p>C??ng ty C??? ph???n ?????u t?? v?? X??y d???ng L???c H???ng</p>
                    <p id="cmt">"?????u ti??n t??i xin g???i l???i c???m ??n t???i gi???ng vi??n Ph???m Th??? Nhung trong th???i gian qua ???? quan t??m,
                        nhi???t t??nh h?????ng d???n v?? gi???ng d???y cho t??i. T??i ???? ti???p thu ???????c nhi???u ki???n th???c b??? ??ch ph???c vu cho vi???c
                        l??m hi???n t???i ??? doanh nghi???p c???a m??nh. B??i gi???ng r?? r??ng, gi???ng vi??n th??n thi???n gi???ng d???y d??? hi???u , ti???p
                        thu ki???n th???c nhanh. Hy v???ng trung t??m s??? m??? r???ng ????? c?? nhi???u h???c vi??n m???i ra tr?????ng s??? ti???p c???n th???c t???
                        nhanh v?? d??? d??ng ki???m vi???c."</p>
                </div>
                <div class="item" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/luu-tuan-anh.jpg">
                    <p>L??u Tu???n Anh</p>
                    <p>Nh??n vi??n v??n ph??ng - Ng??n h??ng TMCP ?????i Ch??ng Vi???t Nam</p>
                    <p id="cmt">"Gi???ng vi??n h??? tr??? nhi???t t??nh, gi???ng d???y d??? hi???u, ki???n th???c mang t??nh th???c t???, ???ng d???ng cao trong
                        to??n/t??i ch??nh c???a ng??n h??ng."</p>
                </div>
                <div class="item" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/vuthikimnga.jpg">
                    <p>V?? Th??? Kim Nga</p>
                    <p></p>
                    <p id="cmt">"Bu???i h???c th???t b??? ??ch, qua bu???i h???c n??y t??i ???? h???c ???????c r???t nhi???u kinh nghi???m trong l??nh v???c k??? to??n"</p>
                </div>

                <div class="item" align="center">
                    <img class="img-responsive" alt="H?????NG D???N L???P B??O C??O T??I CH??NH lakita" src="img/index2/phamthihai2.png">
                    <p>Ph???m Th??? H???i</p>
                    <p>"K??? to??n t???i C??ng ty TNHH s???n xu???t, th????ng m???i, d???ch v??? V??nh Xuy??n"</p>
                    <p id="cmt">Bu???i h???c nhi???u ?? ngh??a, gi??p em h???c h???i ???????c nhi???u kinh nghi???m th???c t??? gi??p ??ch cho doanh nghi???p c???a m??nh</p>
                </div>
            </div>
            <a href="#carousel-example-generic" class="left carousel-control" role="button" data-slide="prev">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a href="#carousel-example-generic" class="right carousel-control" role="button" data-slide="next">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <div class="container register" id="register_now">
            <h1 class="text-center"> <strong> ????NG K?? MUA KHO?? H???C NGAY </strong></h1>
            <div class="row">
                <div class="col-md-2 col-md-offset-5 hr"></div>
            </div>
            <!--    <div class="row">
                    <div class="col-md-10 col-md-offset-1 register-notice">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    </div>
                </div>-->
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <h1 class="text-center">
                        ????? nh???n ???????c ??u ????i l??n ?????n <span class="red promotion"> 44.69% </span>
                    </h1>
                    <div class="text-center margin-top-45">
                        <span class="price_root"> 895.000</span>
                        <span class="price_sale"> 495.000 vnd</span>
                    </div>
                    <div class="register-notice-2">
                        <p class="text-center font-size-26"> <strong>??p d???ng ?????n h???t <span class="fullyear">28/11/2016</span> </strong> </p>
                        <p class="text-center font-size-30">  <strong>NHANH TAY L??N !</strong> </p>
                        <p class="text-center font-size-30">  <strong>Th???i gian ??u ????i c??n</strong> </p>
                    </div>
                    <div class="count-down row text-center">
                        <div class="col-sm-3 hidden-xs">
                            <div class="num-wrap">
                                <p class="num-day"> 00 </p>
                                <p class="txt-time"> Ng??y </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-4">
                            <div class="num-wrap">
                                <p class="num-hour"> 00 </p>
                                <p class="txt-time"> Gi??? </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-4">
                            <div class="num-wrap">
                                <p class="num-minute"> 00 </p>
                                <p class="txt-time"> Ph??t </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-4">
                            <div class="num-wrap">
                                <p class="num-second"> 00 </p>
                                <p class="txt-time"> Gi??y </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-7 margin-top-50 padding-left-50" id="register">
                    <form class="LeadPanel_form promo-panel_action e_submit e_form_submit" action="lakita/save_c3.php" method="post" name="fr_register">
                        <!--                        <div class="my-form">
                                                    <input type="text" class="form-input" name="name" placeholder="H??? t??n" value=""/>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="my-form">
                                                    <input  class="form-input" type="email" name="email" placeholder="Email" value=""/>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="my-form">
                                                    <input  class="form-input" type="tel" name="phone" placeholder="S??? ??i???n tho???i" value=""/>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="my-form">
                                                    <input  class="form-input" name="tinh" placeholder="T???nh th??nh"/>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="my-form">
                                                    <input  class="form-input" name="quan" placeholder="Qu???n huy???n"/>
                                                </div>
                                                <div class="hr"></div>
                                                <div class="my-form">
                                                    <input  class="form-input" name="dia_chi" placeholder="?????a ch???" value=""/>
                                                </div>
                                                <div class="hr"></div>
                        
                                                <div class="row margin-top-10">
                                                    <div class="col-sm-4 col-md-offset-8 col-xs-12">
                                                        <button id="form-submit" class="LeadPanel_action button radius e_btn_submit reg_bt btn btn-success btn-lg my-btn btn-block">????NG K?? NGAY</button>
                                                    </div>
                        
                                                </div>-->
                        <div class="span7 curse-form-box  animated delay1 flipInX">
                            
                            <div class="cont">
                               
                                <form id="dang-ky" class="LeadPanel_form promo-panel_action e_submit e_form_submit" action="lakita/save_c3.php" method="post" name="fr_register">
                                   
                                    <div class="row-fluid">
                                        <div class="span12 wrap-icon-fullname1">
                                            <input class="input-large LeadPanel_form_name" type="text" required="" placeholder="H??? t??n" name="name" id="name">
                                        </div>

                                    </div>	
                                    <div class="row-fluid hidden">
                                        <div class="span12 wrap-icon-email1">
                                            <input type="email" name="email" id="email" class="input-large LeadPanel_form_name" required="" placeholder="Email" value="NO_PARAM@gmail.com">
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12 wrap-icon-phone1">
                                            <input class="input-large LeadPanel_form_name" required="" placeholder="S??? ??i???n tho???i" type="tel" name="phone" id="phone">
                                        </div>
                                    </div>			  

                                    <div class="row-fluid hidden">
                                        <div class="span6 wrap-icon-province1">
                                            <input class="input-large LeadPanel_form_company" id="tinh" type="text" name="tinh" required="" placeholder="T???nh th??nh" value="NO_PARAM">
                                        </div>
                                        <div class="span6 wrap-icon-district1">
                                            <input class="input-large LeadPanel_form_company" id="quan" type="text" name="quan" required="" placeholder="Qu???n huy???n" value="NO_PARAM">
                                        </div>

                                    </div>				  
                                    <div class="row-fluid">
                                        <div class="span12 wrap-icon-address1">
                                            <input class="input-large LeadPanel_form_company" id="dia_chi" type="text" name="dia_chi" required="" placeholder="?????a ch??? nh???n kh??a h???c">
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12 text-center">
                                            <input class="btn btn-large btn-primary LeadPanel_action button radius e_btn_submit reg_bt" type="submit" name="some_name" value="????ng k?? ngay" id="form-submit">
                                        </div>
                                    </div>  
                                    <input type="hidden" name="content" value="1">
                                    <?php
                                    echo "<INPUT TYPE='hidden' class='e_domain_ref' NAME='http_referer' VALUE='" . $ref . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='domain' VALUE='" . $domain . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='id_camp_landingpage' VALUE='" . $id . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='pview' VALUE='" . $preview . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='code_chanel' VALUE='" . $code_chanel . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='id_campaign' VALUE='" . $id_campaign . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='id_landingpage' VALUE='" . $id_landingpage . "'>";
                                    echo "<INPUT TYPE='hidden' NAME='is_mobile' VALUE='" . $mobile . "'>";
                                    ?> 
                                </form>
                            </div>
                        </div>
                        <input  type="hidden" name="content" value="1" />
                        <?php
                        echo "<INPUT TYPE='hidden' class='e_domain_ref' NAME='http_referer' VALUE='" . $ref . "'>";
                        echo "<INPUT TYPE='hidden' NAME='domain' VALUE='" . $domain . "'>";
                        echo "<INPUT TYPE='hidden' NAME='id_camp_landingpage' VALUE='" . $id . "'>";
                        echo "<INPUT TYPE='hidden' NAME='preview' VALUE='" . $preview . "'>";
                        echo "<INPUT TYPE='hidden' NAME='code_chanel' VALUE='" . $code_chanel . "'>";
                        echo "<INPUT TYPE='hidden' NAME='id_campaign' VALUE='" . $id_campaign . "'>";
                        echo "<INPUT TYPE='hidden' NAME='id_landingpage' VALUE='" . $id_landingpage . "'>";
                        echo "<INPUT TYPE='hidden' NAME='is_mobile' VALUE='" . $mobile . "'>";
                        ?>
                    </form>
                </div>
            </div>
        </div>


        <!------------------------ nav-down ----------------------------------------->
        <section class="nav-down hidden-xs hidden-sm">
            <!-- Top Bar -->
            <div class="top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="logo" href="#"><img src="img/index2/logooo.png" alt="logo"></a>
                        </div>
                        <div class="col-md-6">
                            <ul class="btns-top">
                                <li><a href="#" class="" style="    color: #E50000;    font-size: 11pt;    font-weight: 600;">HOTLINE: 1900 6361 95 - 04 7306 2468</a></li>
                                <li><a href="#register_now" class="btn btn-large btn-primary">????NG K?? NGAY</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Bar -->
        </section>

        <!--------------------- wrap-fixed --------------------------------->
        <div class="wrap_fixed_bottom hidden-xs">
            <div class="tag_hotline"><span>Hotline</span><span class="arrow_hotline"> &nbsp;</span></div>

            <div class="main_nav_hotline site">
                <ul style="display: inline-flex;  ">
                    <li><img alt="" src="http://media.bizwebmedia.net/Sites/105084/data/banners/call.png?0" style="width: 16px; height: 16px;    vertical-align: text-top;">&nbsp;1900 6361 95 - 04 7306 2468</li>
                    <li><img alt="" src="http://media.bizwebmedia.net/Sites/105084/data/banners/fb.jpg?0" style="width: 16px; height: 16px;    vertical-align: text-top;">&nbsp;<a style="    color: #232323;" href="https://www.facebook.com/H%E1%BB%8Dc-K%E1%BA%BF-To%C3%A1n-Online-228989934154215/" target="_blank">FANPAGE H???C K??? TO??N ONLINE</a></li>
                </ul>
                <ul style="display: inline-flex;     width: 300px; ">
                    <div class="fb-like fb_iframe_widget" data-href="https://www.facebook.com/H%E1%BB%8Dc-K%E1%BA%BF-To%C3%A1n-Online-228989934154215/" data-layout="standard" data-action="like" data-show-faces="false" data-share="true" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=&amp;container_width=0&amp;href=https%3A%2F%2Fwww.facebook.com%2FExcelThucTien&amp;layout=standard&amp;locale=en_US&amp;sdk=joey&amp;share=true&amp;show_faces=false"><span style="vertical-align: bottom; width: 0px; height: 0px;"><iframe name="f24bf2f6a211d74" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" title="fb:like Facebook Social Plugin" src="https://www.facebook.com/plugins/like.php?action=like&amp;app_id=&amp;channel=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2FfTmIQU3LxvB.js%3Fversion%3D42%23cb%3Df2700d1fb6e263%26domain%3Dbiquyetlamchuexcel5.lakita.vn%26origin%3Dhttp%253A%252F%252Fbiquyetlamchuexcel5.lakita.vn%252Ff8184300c67324%26relation%3Dparent.parent&amp;container_width=0&amp;href=https%3A%2F%2Fwww.facebook.com%2FExcelThucTien&amp;layout=standard&amp;locale=en_US&amp;sdk=joey&amp;share=true&amp;show_faces=false" style="border: none; visibility: visible; width: 0px; height: 0px;" class=""></iframe></span></div>
                </ul>
            </div>
            <div class="nttkm hidden-xs" style="width:250px;float:right;">
                <div class="nttkm-title">
                    <span class="show_dkntt" style="padding-right:0px; color: #fff;font-weight: bold;font-size: 14px;">
                        <img alt="" src="http://media.bizwebmedia.net/Sites/105084/data/banners/gift_mocskin.png" style="width: 16px; height: 16px;    vertical-align: text-top;">
                        <a style="    color: #fff;" href="#register_now">
                            ????NG K?? NGAY
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="fb-comments" data-href="http://lapbctc2016499.lakita.vn" data-width="100%" data-numposts="10" data-order-by="reverse_time"></div>
        </div>
  <!-- *************************************************************Popup*************************************************************************-->
    <div id="Popup" class="popup-wrapper" style="display: none;">
        <div class="popup-loading">
            <div class="loading-container">
                <span>
                    H??? th???ng ??ang x??? l??, vui l??ng ?????i trong gi??y l??t...
                </span>
            </div>
        </div>
    </div>
    <style>
        .popup-wrapper {
            position: fixed;
            bottom: 0;
            right: 0;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 8010;
            background: url(http://lakita.vn/styles/v2.0/img/modal_overlay.png);
        }
        .popup-wrapper .popup-loading{
            background-color: white;
            opacity: 0.7;
            filter:alpha(opacity=70);
            height: 100%;
            width: 100%;
            z-index: 21;
            position: absolute;
            top: 0px;
            left: 0px;

        }
        .popup-wrapper .popup-loading .loading-container{
            position: relative;
            height: 100%;
            background: url(http://www.shopdowntowneaston.com/images/loading.gif) center center no-repeat;
        }
        .popup-wrapper .popup-loading .loading-container span{
            position: absolute;
            top: 58%;
            left: 30%;
            opacity: 1;
            z-index: 1000000000000;
            font-size: 28px;
            font-weight: bold;
        }
    </style>
<!-- *************************************************************Popup (end)**********************************************************************-->
    <script src="lakita/js/save_contact.js" type="text/javascript"></script>
    <!-- html5 player (start) -->
    <script src="http://lakita.vn/styles/html5/build/mediaelement-and-player.min.js"></script>
    <link rel="stylesheet" href="http://lakita.vn/styles/html5/build/mediaelementplayer.min.css" />
    <script>
            $('audio,video').mediaelementplayer({
                //mode: 'shim',
                success: function (player, node) {
                    $('#' + node.id + '-mode').html('mode: ' + player.pluginType);
                }
            });
    </script>

    <!-- html5 player (end) -->
    <script>
        var lastScrollTop = 0;
        $(window).scroll(function (event) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                $(".nav-down").hide();
            } else {
                $(".nav-down").show(200);
            }
            lastScrollTop = st;
        });
    </script>
</body>
</html>
