<?php 
	require_once __DIR__ . '/data.php';
	require_once __DIR__ . '/content/header.php';
?>
	<body class="bg-light">
        <?php
			require_once __DIR__ . '/content/nav_bar.php';
		?>
		<div class="container ">		  
			<div class="row" >
				<div class="col col-sm col-lg "></div>
				<div class="form col col-sm-8 col-lg-6 " >	
					<form onsubmit="alert('Форма успешно отправлена!');return 1" action="/datasendler.php" method="post" id="form" class="form__body" enctype="multipart/form-data">
						<h2 class="pt-3" style="text-align: center;">Форма обратной связи</h1>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="formName" class="col-form-label">Имя*:</label>
								<input  id="formName" type="text" name="name" class="form-control" placeholder="First name" required>
							</div>
							<div class="col-md-6">
								<label for="formSurname" class="col-form-label ">Фамилия*:</label>
								<input  id="formSurname" type="text" name="surname"  class="form-control" placeholder="Last name" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="input-group  col-md">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroupPrepend2">@*</span>
								</div>	
								<label for="formEmail" class="col-form-label"></label>			
								<input pattern="|^[-0-9A-Za-z_\.]+@[-0-9A-Za-z^\.]+\.[a-z]{2,6}$|i'" title="Invalid email address" id="formEmail" type="text" name="email" class="form-control" placeholder="Enter email" required>
							</div>
						</div>	
						<div class="form-group row col-md  ">
							<div class=" ">Пол:</div>
							<div class="form-check form-check-inline options ">
								<div class="custom-control custom-radio">
									<input id="formRightHanded" checked type="radio" value="male" name="gender" class="form-check-input cursor_pointer">
									<label for="formRightHanded" class="form-check-label cursor_pointer" checked><span>Мужской</span></label>
								</div>
								<div class="custom-control custom-radio">
									<input id="formLeftHanded" type="radio" value="female" name="gender" class="form-check-input cursor_pointer">
									<label for="formLeftHanded" class="form-check-label cursor_pointer"><span>Женский</span></label>
								</div>
							</div>
						</div>	
						<div class="form-group">
							<select name="developer" class="custom-select cursor_pointer">
								<option  disabled selected> Выберите желаймую должность </option>
								<?php foreach ($position as $key => $value) { ?>
								<option value="<?php echo $key ?>"><?php echo $value ?></option>
								<?php } ?>
							</select>
						</div>	   
						<div class="form-group row col-md">
							<div class="container form-group row" > Отметьте какими навыками вы владеете:</div>
							<?php foreach ($skills as $key => $value) { ?>
							<div class="col col-sm-4" >					
								<div class="form-check mt-2 ml-1 pl-4"  >
									<input class="form-check-input cursor_pointer" type="checkbox" name='chb[]' value="<?php echo $value ?>" id="defaultCheck<?php echo $key?>" >
									<label class="form-check-label cursor_pointer" for="defaultCheck<?php echo $key?>" >
										<?php echo $value ?>
									</label>
								</div>																
							</div>
							<?php } ?>
						</div>
						<div class="form-group">
							<label for="formMessage" class="col-form-label  ">Расскажите о себе:</label>
							<textarea name="message" id="formMessage" class="form-control  " rows="4" placeholder="Enter about yourself"></textarea></textarea>
						</div>
						<div class="form-group">
							<div class="col-form-label">Прикрепить своё фото:</div>
							<div class="custom-file file">
								<div>
									<input for="image" type="file" name="image" accept=".jpg, .png .jpeg"  class="custom-file-input" style="cursor: pointer;" id="file">
									<label class="custom-file-label" for="customFile">Choose in .jpg or .png or .jpeg format</label>
								</div>
							</div>
						</div>
						<div class="form-group row col-md  ">
							<div class="form-check checkbox">
								<input id="formAgreement" checked type="checkbox" name="agreement" class="form-check-input" required>
								<label for="formAgreement" class="form-check-label" style="cursor: pointer;"><span>Я даю свое согласие на обработку персональных данных в соответствии с <a href="">Условиями</a>*</span></label>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-6 pt-2">
								<button type="submit"  name="submit" class="btn  btn-danger raised form-control " id="submit"> Отправить форму</button>
							</div>
							<div class="col-md-6 pt-2">
                           		 <input id="reset"  type="reset" value="Очистить форму" class="btn btn-outline-secondary form-control">
							</div>
						</div>
					</form>
				</div>
				<div class="col col-sm col-lg "></div>
			</div>
		</div>
<?php require_once __DIR__ . '/content/footer.php'; ?>