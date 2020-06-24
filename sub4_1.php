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
	<header id="header"></header>
	<!-- container -->
	<div id="container">
		<!-- subvisual -->
		<div class="subvisual">
			<h2>이용</h2>
			<div class="lnb">
				<ul class="lnb_inner">
					<li class="home"><a href="/meuseum"></a></li>
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
							<li><a href="/gjmu/sub4_1.html">공지사항</a></li>
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
		<div class="notice">
			<h3>공지사항</h3>
			<?php
	 			$user = 'hhj171258';
				$pass = 'callme!jin15';
				$db = mysqli_connect($host, $user, $pass);
				mysqli_select_db($db, 'hhj171258');

				$sql = "select max(numb) from gjmu_board";
				$result = mysqli_query($db, $sql);
				$data = mysqli_fetch_array($result);
				$numbTotal = $data[0]; 

				$today = Date("y-m-d");
				$sql = "select count(*) from gjmu_board where date = '$today'";
				$result = mysqli_query($db, $sql);
				$data = mysqli_fetch_array($result);
				$numbToday = $data[0];

			?>
			<div class="notice_information">
				<span>총 게시물 <?=$numbTotal?>개</span>
				<u>오늘 <?=$numbToday?>건</u>
			</div>
			<form class="notice_search">
				<select>
					<option selected>전체</option>
					<option>제목</option>
					<option>내용</option>
					<option>작성자</option>
				</select>
				<input type="text" placeholder="검색어를 입력해주세요.">
				<button type="submit"><i class="fas fa-search"></i></button>
			</form>
			<table>
				<thead>
					<tr>
						<th>번호</th>
						<th>제목</th>
						<th>작성자</th>
						<th>작성일</th>
						<th>조회수</th>
						<th>첨부파일</th>
					</tr>
				</thead>
				<tbody>
					<?php
						/* 페이지 */
						$pageNow = $_REQUEST["pageNow"];
						if($pageNow == "") $pageNow = 1;

						$items = 10;

						//공지
						$sql = "select count(*) from gjmu_board where alrm = 'Y'";
						$result = mysqli_query($db, $sql);
						$data = mysqli_fetch_array($result);
						$alrm = $data[0];

						$items = $items - $alrm;
						
						$sql = "select * from gjmu_board where alrm = 'Y'";
						$result = mysqli_query($db, $sql);
						while ($data = mysqli_fetch_array($result))
						{
							$file = substr($data[4], -3);

							echo "<tr class='fixed'>";
							echo "<td>공지</td>";
							echo "<td><a href='/gjmu/sub4_1_cont.php?numb=$data[0]'>$data[1]</a></td>";
							echo "<td>$data[2]</td>";
							echo "<td>$data[3]</td>";
							echo "<td></td>";
							echo "<td class='$file'><a href='#'>$file</a></td>";
						}

						//공지를 제외한 나머지
						$sql = "select count(*) from gjmu_board";
						$result = mysqli_query($db, $sql);
						$data = mysqli_fetch_array($result);
						$pageTotal = ceil($data[0] / $items);
						$start = ($pageNow - 1) * $items;

						$sql = "select * from gjmu_board order by numb desc limit $start, $items";
						$result = mysqli_query($db, $sql);
						while ($data = mysqli_fetch_array($result))
						{
							$file = substr($data[4], -3);

							echo "<tr>";
							echo "<td>$data[0]</td>";
							echo "<td><a href='/gjmu/sub4_1_cont.php?numb=$data[0]'>$data[1]</a></td>";
							echo "<td>$data[2]</td>";
							echo "<td>$data[3]</td>";
							echo "<td></td>";
							echo "<td class='$file'><a href='#'>$file</a></td>";
						}
					 ?>
				</tbody>
			</table>		
			<ul class="page">
				<?php
					$blocks = 5;
					$blockTotal = ceil($pageTotal / $blocks);
					$blockNow = ceil($pageNow / $blocks);

					$pageStart = $blockNow * $blocks - $blocks + 1;
					$pageEnd = $blockNow * $blocks;
					if($pageEnd > $pageTotal) $pageEnd = $pageTotal; 

					$blockPre = $pageStart - 1;
					$blockNext = $pageEnd + 1;

					if($blockNow == 1)
					{
						echo "<li class='disable'><a href='/gjmu/sub4_1.php?pageNow=1'><i class='fas fa-angle-double-left'></i></a></li>";
						echo "<li class='disable'><a href='/gjmu/sub4_1.php?pageNow=$blockPre'><i class='fas fa-angle-left'></i></a></li>";
					}		
					else
					{
						echo "<li><a href='/gjmu/sub4_1.php?pageNow=1'><i class='fas fa-angle-double-left'></i></a></li>";
						echo "<li><a href='/gjmu/sub4_1.php?pageNow=$blockPre'><i class='fas fa-angle-left'></i></a></li>";
					}
				 	for($i = $pageStart; $i <= $pageEnd; $i++)
				 	{
				 		if($i == $pageNow) echo "<li class='on'><a href='/gjmu/sub4_1.php?pageNow=$i'>$i</a></li>";
				 		else echo "<li><a href='/gjmu/sub4_1.php?pageNow=$i'>$i</a></li>";
				 	}
				 	if($blockNow < $blockTotal)
					{
						echo "<li><a href='/gjmu/sub4_1.php?pageNow=$blockNext'><i class='fas fa-angle-right'></i></a></li>
							<li><a href='/gjmu/sub4_1.php?pageNow=$pageTotal'><i class='fas fa-angle-double-right'></i></a></li>";
					}
					else
					{
						echo "<li class='disable'><a href='/gjmu/sub4_1.php?pageNow=$blockNext'><i class='fas fa-angle-right'></i></a></li>
							<li class='disable'><a href='/gjmu/sub4_1.php?pageNow=$pageTotal'><i class='fas fa-angle-double-right'></i></a></li>";
					}
				 ?>
			</ul>
			<a class="list" href="#">글쓰기</a>
		</div>
		<!--// notice -->
	</div>
	<footer id="subfooter"></footer>
</div>
<script src="/gjmu/script/sub.js"></script>
</body>
</html>
