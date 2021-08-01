<?php 
    require_once __DIR__ . '/classes/Db.php';
    require_once __DIR__ . '/content/header.php';
?>
	<body class="bg-light">
        <?php
			require_once __DIR__ . '/content/nav_bar.php';

            $connect = new Db();
            $page = isset($_GET['page']) ? $_GET['page']: 1;
            $limit = 3;
            $offset = $limit * ($page-1);
            $result = $connect->query('SELECT COUNT(*) as count FROM `application` ');
            foreach( $result as $id => $val_array)
            {        
                $count = $result[$id]->count;
            }
            $pagesCount = ceil($count/$limit);
            
            $list = $connect->query("
                SELECT  application.application_id, application.name, application.surname, application.email, application.gender,
                application.agreement,  application.application_date, about_myself.developer, about_myself.skills, about_myself.about_me, file.file__name
                FROM application INNER JOIN about_myself ON application.application_id = about_myself.application_id_fk  INNER JOIN file ON application.application_id = file.application_id  ORDER BY application_id DESC LIMIT $limit OFFSET $offset
            ");
		?>
		<div class="container">	
            <div class="container pt-3" style="text-align: center;"><h1>Страница результатов</h1></div>	  
			<div class="container row pt-3 pb-3 mt-4 justify-content-center" style="border: 1px solid black">
                <?php 
                $data_list = [];
                foreach($list as $id => $val_list)
                {        
                    $data_list[$id] = $val_list;  
                ?>
                <div class="container col-4 p-2 no-gutters " style="border: 1px solid green">
                    <div style="word-wrap: break-word;">#ID: <?php  echo $data_list[$id]->application_id; ?></div>
                    <div style="word-wrap: break-word;">Имя: <?php echo  $data_list[$id]->name; ?></div>
                    <div style="word-wrap: break-word;">Фамилия: <?php echo  $data_list[$id]->surname; ?></div>
                    <div style="word-wrap: break-word;">Email: <?php echo  $data_list[$id]->email; ?></div> 
                    <div style="word-wrap: break-word;">Пол: <?php echo  $data_list[$id]->gender; ?></div>
                    <div style="word-wrap: break-word;">Предполагаемая должность: <?php  echo $data_list[$id]->developer; ?></div>
                    <div style="word-wrap: break-word;" class="outer-container2">Навыки:<?php echo $data_list[$id]->skills; ?></div>
                    <div style="word-wrap: break-word;" class="outer-container">О себе:<div class="inner-container"><div class="element"><?php echo nl2br($data_list[$id]->about_me) ; ?></div></div></div> 
                    <div style="word-wrap: break-word;">Согласие: <?php echo  $data_list[$id]->agreement; ?></div>
                    <div style="word-wrap: break-word;">Дата отправки: <?php echo  $data_list[$id]->application_date; ?></div> 
                    <img class = "col-12 pt-1 pixelated " width="300" height="300" style="word-wrap: break-word;"  src="/files/<?php echo $data_list[$id]->file__name; ?>" alt="Фото"> 
                </div>
                <?php } ?>
			</div>
            <div  class="container pt-2">
                    <nav class="nav justify-content-center" >
                        <ul class="pagination">
                            <?php if($page !=1){
                                $prev = $page -1;
                                ?>  <li class="page-item "><a class="page-link" href="result.php?undefined&page=<?=$prev?>">Предыдущая</a></li> <?php
                            }else{
                                ?>   <li class="page-item disabled"><a class="page-link" href="#">Предыдущая</a></li> <?php
                            }?>
                            <?php
                                $startPage = max(1, $page - 2);
                                $endPage = min( $pagesCount, $page +1);
                                for($i = $startPage; $i <= $endPage; $i++){ if($page==$i){ ?>
                                <li class="page-item active"><a class="page-link" href="result.php?undefined&page=<?= $i ?>"><?=$i ?></a></li>

                            <?php  } else {?>
                                <li class="page-item"><a class="page-link" href="result.php?undefined&page=<?= $i ?>"><?=$i?></a></li>
                            <?php } } ?>
                            <?php if($page !=$pagesCount){
                                $next = $page + 1;
                                ?>  <li class="page-item "><a class="page-link" href="result.php?undefined&page=<?=$next?>">Следущая</a></li> <?php
                            }else{
                                ?>   <li class="page-item disabled"><a class="page-link" href="#">Следущая</a></li> <?php
                            }?>
                        </ul>
                    </nav>
            </div>
		</div>
<?php require_once __DIR__ . '/content/footer.php'; ?>