<?php if (isset($error)):?>
	<div class="errors"><?=$error;?></div>
<?php endif; ?>
<form method="post" action="">
	<label for="email">이메일</label>
	<input type="text" id="email" name="email">

	<label for="password">비밀번호</label>
	<input type="password" id="password" name="password">

	<input type="submit" name="login" value="로그인">
</form>