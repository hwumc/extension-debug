{extends file="base.tpl"}
{block name="pagedescription"}
	<div class="alert alert-block alert-danger">
		<h4>{message name="{$pageslug}-alert-title"}</h4>
		{message name="{$pageslug}-alert-body"}
	</div>
{/block}
{block name="body"}
<form class="form-horizontal" method="post">
	<legend>{message name="{$pageslug}-create-header"}</legend>

	<div class="control-group">
		<label class="control-label" for="reporttitle">{message name="{$pageslug}-create-reporttitle"}</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" id="reporttitle" name="reporttitle" placeholder="{message name="{$pageslug}-create-reporttitle-placeholder"}" required="true" value="{$reporttitle}"/>
			<span class="help-inline">{message name="{$pageslug}-create-reporttitle-help"}</span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="accessright">{message name="{$pageslug}-create-accessright"}</label>
		<div class="controls">
			<input type="text" id="accessright" name="accessright" placeholder="{message name="{$pageslug}-create-accessright-placeholder"}" value="{$accessright}" data-provide="typeahead" data-items="4" data-source='{$jsrightslist}'  />
			<span class="help-inline">{message name="{$pageslug}-create-accessright-help"}</span>
		</div>
	</div>

	<textarea id="query" name="query" class="span12" rows="20">{$query}</textarea>
	
	<div class="control-group">
		<div class="controls">
			<div class="btn-group"><button type="submit" class="btn btn-primary">{message name="save"}</button><a href="{$cScriptPath}/{$pageslug}" class="btn">{message name="getmeoutofhere"}</a></div>
		</div>
	</div>
</form>
{/block}