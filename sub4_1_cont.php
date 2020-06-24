<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="/gjmu/css/reset.css?ver=1.0">
<link rel="stylesheet" href="/gjmu/css/main.css?ver=1.0">
<link rel="stylesheet" href="/gjmu/css/sub.css?ver=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500&family=Noto+Serif+KR:wght@400;500;700&display=swap">
<link rel="icon" href="/gjmu/favicon.png">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
  $(document).ready(function(){
     $("#header").load("/gjmu/include/header.html");
	 $("#subfooter").load("/gjmu/include/subfooter.html");
  });
</script>
<title>경주 박물관 리뉴얼</title>
</head>
<body>
<div id="wrap">
	<header id="header"></header><!-- inculde로 불러옴 -->
	<!-- container -->
	<div id="container">
		<!-- subvisual -->
		<div class="subvisual">
			<h2>이용</h2>
			<div class="lnb">
				<ul class="lnb_inner">
					<li class="home"><a href="/gjmu"></a></li>
					<li>
						<a href="#none">이용</a>
						<ol>
							<li><a href="#">언어</a></li>
							<li><a href="#">소개</a></li>
							<li><a href="#">전시</a></li>
							<li><a href="#">이용</a></li>
						</ol>
					</li>
					<li>
						<a href="#none">공지사항</a>
						<ol>
							<li><a href="/gjmu/sub4_1.php">공지사항</a></li>
							<li><a href="#">교육</a></li>
							<li><a href="#">예약</a></li>
							<li><a href="#">문의하기</a></li>
							<li><a href="#">전시물</a></li>
							<li><a href="#">전시관VR</a></li>
						</ol>
					</li>
					<li class="print"><a href="#"></a></li>
					<li class="share"><a href="#"></a></li>
				</ul>
			</div>
		</div>
		<!--// subvisual -->
		<!-- notice -->
		<?php 
			$user = 'hhj171258';
			$pass = 'callme!jin15';
			$db = mysqli_connect($host, $user, $pass);
			mysqli_select_db($db, 'hhj171258');
		 	
			$numb = $_REQUEST["numb"];
			$pageNow = $_REQUEST["pageNow"];

			if($numb <> "" )
			{	
				if($_COOKIE["cunt".$numb] <> "1")
				{	
					$sql = "update gjmu_board set cunt = cunt +1 where Numb = '$numb'";
					$result = mysqli_query($db, $sql);
				}
				setcookie('cunt'.$numb , '1', time() + (60 * 60 * 24) ,'/gjmu');
			}

			$sql = "select * from gjmu_board where numb ='$numb'";
			$result = mysqli_query($db, $sql);
			$data = mysqli_fetch_array($result);

			$file = substr($data[5], -3);
		?>
		<div class="notice">
			<h3>공지사항</h3>
			<div class="notice_detail">
				<div class="notice_detail_title">
					<h4><?=$data[1]?></h4>
					<ul>
						<li>작성자: <?=$data[2]?></li>
						<li>등록일: <?=$data[3]?></li>
						<li>조회수: <?=$data[4]?></li>
					</ul>
					<ol>
						<li>
							<a class="<?=$file?>" href="/gjmu/board/<?=$data[5]?>"><?=$data[5]?></a>
							<?php  if($file <> 'zip') echo "<a href='/gjmu/board/$data[5]' target='_blank'><i class='fas fa-search'></i> 바로보기</a>"; ?>
						</li>
					</ol>
				</div>
				<div class="notice_detail_content">
					<p><?=$data[6]?></p>
				</div>
				<?php

					$sql = "select max(numb), min(numb) from gjmu_board";
					$result = mysqli_query($db, $sql);
					$data = mysqli_fetch_array($result);
					
					$max = $data[0];
					$min = $data[1];
					$pre = $numb - 1;
					$next = $numb + 1;

					if($next > $max) $next = $max;
					if($pre < $min) $pre = $min;

					$sql = "select titl from gjmu_board where numb = '$pre'";
					$result = mysqli_query($db, $sql);
					$data = mysqli_fetch_array($result);
					$titlPre = $data[0];

					$sql = "select titl from gjmu_board where numb = '$next'";
					$result = mysqli_query($db, $sql);
					$data = mysqli_fetch_array($result);
					$titlNext = $data[0];

				?>
				<dl class="notice_detail_page">
					<dt class="fas fa-chevron-up">이전글</dt>	
					<dd><a href="/gjmu/sub4_1_cont.php?numb=<?=$pre?>"><?=$titlPre?></a></dd>
					<dt class="fas fa-chevron-down">다음글</dt>
					<dd><a href="/gjmu/sub4_1_cont.php?numb=<?=$next?>"><?=$titlNext?></a></dd>
				</dl>
				<a class="list" href="/gjmu/sub4_1.php?pageNow=<?=$pageNow?>">목록</a>
			</div>
		</div>
		<!--// notice -->
	</div>
	<!--// container -->
	<footer id="subfooter"></footer>
</div>
<script src="/gjmu/script/sub.js"></script>
</body>
</html>
