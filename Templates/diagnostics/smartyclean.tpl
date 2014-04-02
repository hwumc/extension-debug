{extends file="base.tpl"}
{block name="pagedescription"}
{/block}
{block name="body"}
<form class="form-horizontal" method="post">
	<legend>Clean the Smarty compile cache?</legend>
	
	<p>This will clean the compiled template cache, requiring that every template be recompiled from scratch the next time it is used. This will negatively affect site performance on first use of all templates.</p>

	<ul>
		{foreach from="$files" item="f"}
			<li>{$f}</li>
		{/foreach}
	</ul>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="confirm" value="confirmed" required="true" />
				Yes, clear the template cache.
			</label>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<div class="btn-group">
				<button type="submit" class="btn btn-danger">{message name="delete"}</button><a href="{$cScriptPath}/{$pageslug}" class="btn">{message name="getmeoutofhere"}</a>
			</div>
		</div>
	</div>

</form>
{/block}