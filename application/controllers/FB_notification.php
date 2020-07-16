<?php

class FB_notification extends CI_Controller {
    function index() {
        // verification
        // if ($_GET['hub_verify_token'] === 'huynv') {
        // 			echo $_GET['hub_challenge'];
        // 		}
        //
  			if (file_get_contents('php://input')) {
            $comment = json_decode(file_get_contents('php://input'));
            $commentId = $comment->entry[0]->changes[0]->value->id;
            $pageId = explode('_', $commentId);
            $input = [];
            $input['where'] = array('comment_id' => $commentId);
            $this->load->model('facebook_comment_plugin_model');
            $commentExist = $this->facebook_comment_plugin_model->load_all($input);
            if (empty($commentExist)) {
                $this->facebook_comment_plugin_model->insert(['comment_id' => $commentId, 'time' => date(_DATE_FORMAT_)]);
                $url = [
                    '1732177853493516' => 'https://lakita.vnbao-hiem-xa-hoi-tien-luong-thue-thu-nhap-ca-nhan-2018.html',
                    '1298443350192736' => 'https://lakita.vnky-thuat-quyet-toan-thue.html',
                    '1242593289171565' => 'https://lakita.vnquyet-toan-thue-tu-a-den-z.html',
                    '1778639972164393' => 'https://lakita.vnlap-bao-cao-tai-chinh-2016.html',
                    '1062159213912728' => 'https://lakita.vnlap-bao-cao-tai-chinh-2017.html',
                    '1665697290129137' => 'https://lakita.vntron-bo-lap-bao-cao-tai-chinh-2017.html',
                    '1526592320757326' => 'https://lakita.vntron-bo-lap-bao-cao-tai-chinh-2017-trinhbtk2.html',
                    '1820232718010252' => 'https://lakita.vntron-bo-lap-bao-cao-tai-chinh-2017-345k.html',
                    '1270921559703857' => 'https://lakita.vncach-xac-dinh-chi-phi-hop-ly.html',
                    '1784191251590929' => 'https://lakita.vncach-xac-dinh-chi-phi-hop-ly-candh.html',
                    '1567273619971559' => 'https://lakita.vnquan-tri-ke-toan.html',
                    '1883385008373014' => 'https://lakita.vnquan-tri-ke-toan-candh.html',
                    '1281082322018331' => 'https://lakita.vnbao-cao-tai-chinh-nang-cao.html',
                    '2054579071235903' => 'https://lakita.vnbao-cao-tai-chinh-nang-cao-candh.html',
                    '1499953153417907' => 'https://lakita.vntron-bo-quyet-toan-thue-tu-a-den-z.html',
                    '1572938529454084' => 'https://lakita.vntron-bo-quyet-toan-thue-tu-a-den-z-dangph.html',
                    '1765719676802437' => 'https://lakita.vntron-bo-quyet-toan-thue-tu-a-den-z-candh1.html',
                    '1478323028949878' => 'https://lakita.vntron-bo-quyet-toan-thue-tu-a-den-z-candh2.html',
                    '1436597719799600' => 'https://lakita.vnke-toan-cho-nguoi-moi-bat-dau.html',
                    '1574470682649315' => 'https://lakita.vnke-toan-cho-nguoi-moi-bat-dau-hanhnm.html',
                    '1356504991125130' => 'https://lakita.vnke-toan-danh-cho-giam-doc.html',
                    '1441397425925456' => 'https://lakita.vnbi-quyet-lam-chu-excel-2017.html',
                    '1370473353071832' => 'https://lakita.vnexcel-tu-a-den-z.html',
                    '1331503243639074' => 'https://lakita.vncombo-ke-toan-excel-van-phong-2017.html',
                    '1530375550351116' => 'https://lakita.vncombo-qua-khung-dip-giang-sinh.html',
                    '1789918514418799' => 'https://lakita.vnquan-tri-tai-chinh-ke-toan.html',
                    '1341661405963380' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong.html',
                    '1542421495847416' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong-2.html',
                    '1455312594567068' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong-6.html',
                    '1622160844507152' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong-3.html',
                    '1628748463856832' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong-4.html',
                    '1625298554180109' => 'https://lakita.vnyoga-danh-cho-nguoi-lam-van-phong-5.html',
                    '1739851282726831' => 'https://lakita.vncombo-qua-khung-tet-nguyen-dan.html',
                    '1584950161542159' => 'https://lakita.vntron-bo-thuc-hanh-ke-toan-tong-hop-tren-phan-mem-excel.html',
                    '1594205084033500' => 'https://lakita.vnchia-se-tat-tan-tat-kinh-nghiem-bao-ve-giai-trinh-so-lieu-khi-thanh-tra-thue.html',
                    '2391237814250616' => 'https://lakita.vntron-bo-ky-thuat-lap-kiem-tra-phan-tich-bctc.html',
                    '1872401092812322' => 'https://lakita.vnchia-se-tat-tan-tat-kinh-nghiem-bao-ve-giai-trinh-so-lieu-khi-thanh-tra-thue-2.html',
                    '2170475322979155' => 'https://lakita.vnphat-hien-rui-do-tiem-an-khi-quyet-toan-3-luat-thue-2017.html',
                    '1930688790275091' => 'https://lakita.vncombo-qua-khung-chao-mung-30-04.html',
                    '1493559494083709' => 'https://lakita.vntron-bo-ky-thuat-huong-dan-quyet-toan-thue-tncn.html',
                    '1716745115079717' => 'https://lakita.vntron-bo-ky-thuat-huong-dan-quyet-toan-thue-tncn-2.html',
                    '1904310999621597' => 'https://lakita.vnthuc-hanh-ke-toan-tong-hop-tren-phan-mem-Fast-va-Misa.html',
                    '1816066965082975' => 'https://lakita.vnthanh-thao-xu-ly-chung-tu-ke-toan-trong-doanh-nghiep.html',
                    '2433309940019922' => 'https://lakita.vnthuc-hanh-ke-toan-thue-quyet-toan-va-toi-uu-thue-trong-doanh-nghiep.html',
                    '1929555897075109' => 'https://lakita.vnnghiep-vu-xuat-nhap-khau-va-khai-bao-hai-quan.html',
                    '1639856656137841' => 'https://lakita.vnnghiep-vu-xuat-nhap-khau-va-khai-bao-hai-quan-2.html',
                    '1738925839528753' => 'https://lakita.vnnghiep-vu-hanh-chinh-ky-nang-van-phong-va-quan-ly-nhan-su-thuc-te.html',
                    '1795839820470546' => 'https://lakita.vntao-ung-dung-va-lam-ke-toan-tong-hop-tren-phan-mem-excel.html',
                    '1956370551042759' => 'https://lakita.vnke-toan-thue-thuc-hanh.html',
                    '1574818002626968' => 'https://lakita.vnhoc-ke-toan-bat-dau-tu-con-so-0.html',
                    '1643160289146308' => 'https://lakita.vntuyen-dung-nhan-su-marketing.html',
                    '1704484796325483' => 'https://lakita.vnhoc-ke-toan-nha-hang-tu-a-den-z.html',
                    '1801368463315592' => 'https://lakita.vncam-nang-dao-tao-thu-ky-tro-ly-hanh-chinh-chuyen-nghiep.html',
                    '2234617613277308' => 'https://lakita.vnthuc-hanh-lam-ke-toan-tong-hop-thuc-te-tren-phan-mem-ke-toan-Misa.html',
                    '2574533979244883' => 'https://lakita.vnbi-quyet-kinh-nghiem-dau-tu-chung-khoan.html',
                    '2172669879452202' => 'https://lakita.vnkhoa-hoc-ke-toan-cho-nguoi-moi-bat-dau.html',
                    '1809534295835085' => 'https://lakita.vnthuc-hanh-nghiep-vu-ke-toan-tong-hop-tren-excel.html',
                    '2327540280620873' => 'https://lakita.vnnghiep-vu-BHXH-tien-luong-thue-tncn.html',
                    '2313619335332757' => 'https://lakita.vnkhoa-hoc-tieng-han-cho-nguoi-moi-bat-dau.html',
                    '2083433138366035' => 'https://lakita.vnbao-hiem-xa-hoi-tien-luong-thue-tncn-2018.html',
					'2413642248709073' => 'https://lakita.vnthuc-hanh-ke-toan-tong-hop-thuong-mai-dich-vu.html',
                    '2043011409093546' => 'https://lakita.vnkhoa-hoc-online-de-tro-thanh-kiem-toan-vien-doc-lap.html',
					'1972873759426617' => 'https://lakita.vncombo-5-khoa-hoc-tieng-nhat-cho-nguoi-moi-bat-dau.html',
					'1944636142319630' => 'https://lakita.vnbi-kip-lam-giau-tu-46-mon-an-vat.html',
					'1921096021342729' => 'https://lakita.vntron-bo-lap-bao-cao-tai-chinh-2019.html',
					'2225870520770445' => 'kinhdoanhanvat.lakita.vn',
					'1898177100230940' => 'https://lakita.vnthuc-hanh-ke-toan-chi-phi-gia-thanh-trong-doanh-nghiep.html',
					'1970151599740666' => 'https://lakita.vneating-clean-cho-nguoi-viet.html',
					'2267012346665385' => 'https://lakita.vntron-bo-quyet-toan-thue-tu-a-den-z-3.html',
					'2039562516082995' => 'combotonghop.lakita.com.vn',
					'2086662134726993' => 'massagegiadinh.lakita.com.vn',
					'2259124294158508' => 'thamsansiquantricamxuc.lakita.com.vn',
					'2139415499442153' => 'combo.lakita.com.vn',
					'2052392588188403' => 'taichinhgiathanh.lakita.com.vn',
					'2611974748820553' => 'tienghanchonguoimoihoc.lakita.com.vn',
					'1700131183425019' => 'comboketoanchonguoimoihocvaketoantonghop.lakita.com.vn',
					'2097031767079105' => 'tronbolotrinhketoanthue.lakita.com.vn',
					'2027050174048822' => 'ketoansanxuat.lakita.com.vn',
					'2364380746925301' => 'mebau.lakita.com.vn',
					'1923678594352526' => 'yogagiamcan.lakita.com.vn',
					'2022531151125815' => 'ketoantonghoptrenexel2.lakita.com.vn',
					'2822425541115766' => 'khoahocmassage.eduhealth.vn',
					'2368423473232386' => 'ketoantonghoptrenmisa.lakita.com.vn',
					'1994341917315032' => 'ketoansanxuat2.lakita.com.vn',
					'2157433107611484' => 'thanhtrathue.lakita.com.vn',
					'2129239333763317' => 'uudai2019.lakita.com.vn',
					'2250041115017898' => 'daotaoquyttoanthuetoiuuthuevathanhtrathue.lakita.com.vn',
					'1973311246039569' => 'kithuatquyettoantoiuuthue.lakita.com.vn',
					'1951638814957341' => 'bikipquyettoanthuetncn-tndn.lakita.com.vn',
					'2346866672009834' => 'combokt800_400.lakita.com.vn',
					'2632738136752615' => 'ketoannhahangonline.lakita.com.vn',
					'2150496741673422' => 'biquyetlamsotnuong.eduhealth.vn',
					'1947880848666412' => 'detox.eduhealth.vn',
					'2665592703458589' => 'combophache.eduhealth.vn',
					'2522463751115453' => 'comboanvat.eduhealth.vn',
					'2435183843222608' => 'massagechonguoithuong.eduhealth.vn',
					'1992781090841938' => 'comboyoga_detox.eduhealth.vn',
				//	'' => 'anvatnhahang.eduhealth.vn',
					'1970317526380083' => 'ketoanxaydung.lakita.com.vn',
					'2082273251831395' => 'eduhealth.vn21-mon-tra-trai-cay-sieu-thom-ngon-thon-dang-dep-da-2169.html',
					'2042657619183354' => 'thucdonchuanchonguoiviet.eduhealth.vn',
					'2156766041013573' => 'kinhdoanhanvat.eduhealth.vn',
					'1959589937469604' => 'launuonganvat.eduhealth.vn',
					'1986879441429072' => 'cbtrasua.eduhealth.vn',
					'1977933005652553' => '42congthucgiamcan.eduhealth.vn',
					'2011231022292906' => 'anvatphache.eduhealth.vn',
					'1696977970403421' => 'tulamtrasua.eduhealth.vn',
					'2200848909983402' => 'phathienruiroquyettoan3luatthue.lakita.com.vn',
					'1872740699521998' => 'lambanhngaytet.eduhealth.vn',
					'2054513011261784' => 'combophachevacafe.eduhealth.vn',
					'2087662901312590' => 'yogatreem.eduhealth.vn',
					'2490898004315259' => 'detoxgiamcan.eduhealth.vn',
					'1904607796335388' => 'ketoantienganh.lakita.com.vn',
					'2223917940985605' => 'lambanh.eduhealth.vn',
					'1878440465598623' => 'ketoantienganh2.lakita.com.vn',
					'2190066091045581' => '23monanvat.eduhealth.vn',
					'2204490602948409' => 'trasuaanvat.eduhealth.vn',
					'2068373699907503' => 'socapcuu.eduhealth.vn',
					'2081595861894244' => 'comboketoanmoibatdauvatienganhketoan.lakita.com.vn',
					'2251052218292835' => 'massagegiadinhoffline.eduhealth.vn',
					'2184838891577642' => 'comboanvat1.eduhealth.vn',
					'1743026555802671' => 'anvatlau.eduhealth.vn',
					'2244286032298743' => 'kinhdoanhphache.eduhealth.vn',
					'2244286032298743' => 'kinhdoanhphache.eduhealth.vn',
					'2192770407433241' => 'trasuacafe.eduhealth.vn',
					'2188083811249006' => 'massagegiadinhoff.eduhealth.vn',
					'2626863050719833' => 'khoinghiepcungtrasua-banhngot.eduhealth.vn',
					'2516977794998821' => 'cafephache.eduhealth.vn',
					'2655780834455956' => 'massagebamhuyet.eduhealth.vn',
					'2655780834455956' => 'ketoangioi.lakita.vn',
					'2277924142257912' => 'sotlaunuong-phachetonghop.eduhealth.vn',
					'1991971064264948' => 'combo3.eduhealth.vn',
					'2169328606489686' => 'combo-4khoahoc-hanhchinh-vanphong.lakita.com.vn',
					'2090944524329656' => 'combo5ketoan.lakita.com.vn',
					'1861326203993309' => 'comboQuanly.lakita.com.vn',
					'2378910285475131' => 'comboanvatmuahe_trasua.eduhealth.vn',
					'2277452925645426' => 'trasuache.eduhealth.vn',
					'2760039424013818' => 'combolamdep.eduhealth.vn',
					'2353652498013382' => 'Combophache1.eduhealth.vn',
					'2289544987796114' => 'bikiplamchuexcel2019.lakita.com.vn',
					'2145609455518846' => '150congthucphache.eduhealth.vn',
					'2496840303723649' => 'tonghop3trasua.eduhealth.vn',
					'2222412907821283' => 'quantritaichinh-ketoan-danhchogiamdoc.lakita.com.vn',
					'2054439888010849' => '2khoinghiepcungtrasua-banhngot.eduhealth.vn',
					'2233764593355499' => 'banhngot-tra.eduhealth.vn',
					'1949724738469833' => 'eatclean-detox.eduhealth.vn',
					'2271049319624882' => 'trasuaanvat2019.eduhealth.vn',
					'2148835378527311' => 'kinhdoanhquannhau.eduhealth.vn',
					'2134048743337535' => 'battrendtrasuacung40congthuchot.eduhealth.vn',
					'2550924951645655' => 'datgachketoansanxuattrenMisa.lakita.com.vn',
					'2681195961921453' => '80douongmuahevannguoime.eduhealth.vn',
					'2025955544184985' => 'trasuadailoananvatmuahe.eduhealth.vn',
					'1998614950236739' => 'combo10khoapc.eduhealth.vn',
					'2311057538932470' => 'trasuakem.eduhealth.vn',
					'1821596087945809' => 'nhau-lau-nuong-congthuccuathanhcong.eduhealth.vn',
					'2379946522016075' => 'trasuadailoancafedaxay.eduhealth.vn',
					'2065768470171754' => 'kinhdoanhnhaunuonglau.eduhealth.vn',
					'1966370133485537' => 'khoinghiepquanlaunuong.eduhealth.vn',
					'2086522964777477' => 'kinhdoanhtrasuaanvat.eduhealth.vn',
					'2133952939991101' => 'trasuatratraicaydailoan.eduhealth.vn',
					'2148985521876180' => 'trasuadailoananvatsinhvien.eduhealth.vn',
					'2084174711651668' => 'anvatkinhdoanhtrasua.eduhealth.vn',
					'2569537669784810' => 'ketoantonghopnangcao.lakita.com.vn',
					'2138896009551295' => 'kinhdoanhkemche.eduhealth.vn',
					'2799554693417943' => 'khoanhau-launuong.eduhealth.vn',
					'1979239092199234' => '55congthucphache-anvat.eduhealth.vn',
					'2531559926916314' => 'trasuaanvatkem.eduhealth.vn',
					'3068522369831037' => 'ketoandnsanxuat.lakita.com.vn',
					'2562518070485055' => 'ketoanmisanangcao.lakita.com.vn',
					'2176442422436838' => 'nhaulaunuonganvat2019.eduhealth.vn',
					'1970258543100357' => 'CBdanhriengchoketoansanxuat.lakita.com.vn',
					'2093668457369276' => 'combothue.lakita.vn',
					'2697767270296571' => 'anvatvaphache.eduhealth.vn',
					'2205930419486101' => 'anvat_che_trasuaDailoan.eduhealth.vn',
					'2102219603208426' => 'menuchuan-diemredenthanhcongkinhdoanhtrasua.lakita.com.vn',
					'2171442666268172' => 'garankfc.eduhealth.vn',
					'2163022470401548' => 'doanvatchemoi.eduhealth.vn',
					'2805629272795568' => 'combot4.eduhealth.vn',
					'2841706762507998' => 'thuchanhketoansanxuat-trenmisa.lakita.com.vn',
					'2809249199115428' => 'CBdetoxtratraicay.eduhealth.vn',
					'1919626421500001' => 'trasua-anvat-kinhdoanhthanhcong.eduhealth.vn',
					'2383244161720193' => 'tienganhketoan.lakita.com.vn',
					'2202498916529244' => 'trasuadailoanpctonghop.eduhealth.vn',
					'2103560543075819' => 'menutrasua.eduhealth.vn',
					'2889070694450673' => 'combo2trasuatanganvat.eduhealth.vn',
					'1743026555802671' => 'combocafevabanh.eduhealth.vn',
					'1937798536324830' => 'cafetangbanh.eduhealth.vn',
					'2315604915164874' => 'menucafesualacdaxaychongayhe.eduhealth.vn',
					'1743026555802671' => 'combotrasuaphachetonghop.eduhealth.vn',
					'2269802466432042' => 'Bartenderchuyennghiep.eduhealth.vn',
					'2177149802339503' => '120CONGTHUCPHACHEONLINE.EDUHEALTH.VN',
					'3191810687511930' => 'datcockhoahoclamkem.eduhealth.vn',
					'2292944664105788' => 'news-vo-oi-chong-muon-nung.eduhealth.vn',
					'2309122512483467' => 'detoxgiamcandepda.eduhealth.vn',
					'2443911558953912' => '46biquyetdetoxgiamcandepda.eduhealth.vn',
					'1390056501119515' => 'detoxsoda.eduhealth.vn',
					'1707433422693528' => 'kinhdoanhkemtrasua.eduhealth.vn',
					'2692490887432961' => 'massageyoga.eduhealth.vn',
					'2547756278591454' => 'datgachkhoaoc.eduhealth.vn',
					'2312507728838727' => 'trasuakemche.eduhealth.vn',
					'2150802608301610' => 'datgachkhoaoccotran.eduhealth.vn',
					'2273385736109122' => 'trasuakemy.eduhealth.vn',
					'1876529235780527' => 'muakemtangche.eduhealth.vn',
					'2296177510405682' => 'datgachanchay.eduhealth.vn',
					'1834941699939504' => 'datgachkemy.eduhealth.vn'
                ];

                $replyComment = '';
                if (!empty($comment->entry[0]->changes[0]->value->parent)) {
                    $replyComment .= '<br> Trả lời comment: ' . $comment->entry[0]->changes[0]->value->parent->message .
                            '<br> của ' . $comment->entry[0]->changes[0]->value->parent->message->from->name;
                }
                $page = json_decode(file_get_contents('https://graph.facebook.com/v2.11/' . $pageId[0] . '?access_token=' . ACCESS_TOKEN));
                $urlTitle = isset($url[$pageId[0]]) ? $url[$pageId[0]] : $pageId[0];

                $uid = $comment->entry[0]->changes[0]->value->from->id;
                $fullSizePicture = (('https://graph.facebook.com/v2.11/' . $uid . '/picture?width=500'));

                $this->load->library("email");
                $this->email->from('cskh@lakita.vn', "lakita.vn");
                $this->email->to('ngoccongtt1@gmail.com, haiyen2102197@gmail.com, thuhoa.meetc@gmail.com');
                //$this->email->to('thanhloc1302@gmail.com, kenshiner96@gmail.com');
                $this->email->subject('Có cmt fb mới ở landing page ' . $urlTitle . ' (' . date(_DATE_FORMAT_) . ')');

                $uMessage = $comment->entry[0]->changes[0]->value->message;
                $uName = $comment->entry[0]->changes[0]->value->from->name;
                
				$email = '';
                $phone = '';
                if (preg_match("/([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}/ix", $uMessage, $matches)) {
                    $email = $matches[0];
                }
                if (preg_match("/(\\+84|0)\\d{9,10}/", $uMessage, $matches)) {
                    $phone = $matches[0];
                }

                if (!empty($phone)) {
                    $this->load->model('landingpage_model');
                    $input = array();
                    $input['where']['url'] = $urlTitle;
                    $course = $this->landingpage_model->load_all($input);
                    if (!empty($course)) {
                        $param['name'] = $uName;
                        $param['email'] = $email;
                        $param['address'] = 'mh - '.$urlTitle;
                        $param['phone'] = $phone;
                        $param['course_code'] = $course[0]['course_code'];
                        $param['date_rgt'] = time();
                        $param['source_id'] = 5;
                        $param['channel_id'] = 2;
                        $param['landingpage_id'] = $course[0]['id'];
                        $param['payment_method_rgt'] = 0;
                        $param['price_purchase'] = $course[0]['price'];
                        $param['sale_staff_id'] = 0;
                        $param['date_handover'] = 0;
                        $param['duplicate_id'] = $this->_find_dupliacte_contact($email, $phone, $course[0]['course_code']);
                        $param['last_activity'] = time();
                        $param['source_sale_id'] = 1;
                        $param['is_consultant'] = 1;
                        $this->contacts_model->insert($param);
						$this->contacts_backup_model->insert($param);
                    }
                }

                $this->email->message('<table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:undefined"> <tbody> <tr> <td style="vertical-align:top; width:134.75pt"> <p style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Roboto"><img src="' . $fullSizePicture . '" style="height:271px; width:271px"/></span></span> </p></td><td style="vertical-align:top; width:600pt"> <p style="margin-left:1in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:Roboto">' . $uName . '</span></span> </p><p style="margin-left:1in; margin-right:0in"><span style="font-size:11pt"><span style="background-color:white"><span style="font-family:Roboto"><strong><span style="font-size:24.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:#222222">' . $uMessage . '</span></span></span></strong></span></span></span> </p><p style="margin-left:1in; margin-right:0in">&nbsp;</p><a style="margin-left:1in; margin-right:0in" href="' . $urlTitle . '"> Landing Page: ' . $urlTitle . '</a><p style="margin-left:1in; margin-right:0in">' . $replyComment . '</p></td></tr></tbody></table>');

                if ($this->email->send()) {
                    echo 'ok';
                }
                $this->email->clear(TRUE);

                require_once APPPATH . 'libraries/Pusher.php';
                $options = array(
                    'cluster' => 'ap1',
                    'encrypted' => true
                );
                $pusher = new Pusher(
                        'e37045ff133e03de137a', 'f3707885b7e9d7c2718a', '428500', $options
                );

                $data2 = [];
                $data2['title'] = 'Có comment FB mới ở landing page';
                $data2['message'] = $page->title;
                $data2['image'] = $fullSizePicture;
                $data2['url'] = $urlTitle;
                $pusher->trigger('my-channel', 'notice', $data2);
            }
        }
    }

    private function _find_dupliacte_contact($email = '', $phone = '', $course_code = '') {
        $dulicate = 0;
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array(
            'phone' => $phone,
            'course_code' => $course_code
        );
        $input['order'] = array('id', 'ASC');
        $rs = $this->contacts_model->load_all($input);
        if (count($rs) > 0) {
            $dulicate = $rs[0]['id'];
        }
        return $dulicate;
    }
}

?>
