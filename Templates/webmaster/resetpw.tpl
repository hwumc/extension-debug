{extends file="base.tpl"}
{block name="body"}
<form class="form-horizontal" method="post">
	<fieldset>
		<legend>{message name="{$pageslug}-header-user"}</legend>

		<div class="control-group">
			<label class="control-label" for="username">{message name="{$pageslug}-username-label"}</label>
			<div class="controls">
				<input type="text" id="username" name="username" placeholder="{message name="{$pageslug}-username-placeholder"}" required="true" data-provide="typeahead" data-items="4" data-source='{$jsuserlist}' />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="password">{message name="{$pageslug}-password-label"}</label>
			<div class="controls">
				<input type="password" id="password" name="password" placeholder="{message name="{$pageslug}-password-placeholder"}" required="true" />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="confpassword">{message name="{$pageslug}-confpassword-label"}</label>
			<div class="controls">
				<input type="password" id="confpassword" name="confpassword" placeholder="{message name="{$pageslug}-confpassword-placeholder"}" required="true" />
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>{message name="{$pageslug}-header-you"}</legend>

		<div class="control-group">
			<label class="control-label" for="yourusername">{message name="{$pageslug}-yourusername-label"}</label>
			<div class="controls">
				<input type="text" id="yourusername" name="yourusername" placeholder="{message name="{$pageslug}-yourusername-placeholder"}" required="true" value="{User::getLoggedIn()->getUsername()}" disabled="disabled" />
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="yourpassword">{message name="{$pageslug}-yourpassword-label"}</label>
			<div class="controls">
				<input type="password" id="yourpassword" name="yourpassword" placeholder="{message name="{$pageslug}-yourpassword-placeholder"}" required="true" />
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
		<div class="controls">
			<div class="btn-group"><button type="submit" class="btn btn-danger">{message name="{$pageslug}-changepw"}</button></div>
		</div>
	</div>
</form>
{/block}