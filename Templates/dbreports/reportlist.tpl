{extends file="base.tpl"}
{block name="pagedescription"}
	{if $allowEdit == "true" || $allowCreate == "true" }
		<div class="alert alert-block alert-danger"><h4>{message name="{$pageslug}-alert-title"}</h4>{message name="{$pageslug}-alert-body"}</div>
	{/if}
{/block}
{block name="body"}
{if $allowCreate == "true"}
	<p><a href="{$cScriptPath}/{$pageslug}/create" class="btn btn-success">{message name="{$pageslug}-button-create"}</a></p>
{/if}
	<p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>{message name="{$pageslug}-text-title"}</th>
					<th>{message name="{$pageslug}-text-accessright"}</th>
					<th>{message name="{$pageslug}-text-execute"}</th>
					{if $allowEdit == "true"}<th>{message name="{$pageslug}-text-edit"}</th>{/if}
					{if $allowDelete == "true"}<th>{message name="{$pageslug}-text-delete"}</th>{/if}
				</tr>
			</thead>
			<tbody>
				{foreach from="$pagelist" item="page" key="pageid" }
					<tr>
						<th>{$page->getTitle()|escape}</th>
						<td>{$page->getAccessRight()|escape}</td>
						<td>{if $currentUser->isAllowed( $page->getAccessRight() )}<a href="{$cScriptPath}/{$pageslug}/execute/{$pageid}" class="btn btn-small btn-info">{message name="{$pageslug}-button-execute"}</a>{/if}</td>
						{if $allowEdit == "true"}<td><a href="{$cScriptPath}/{$pageslug}/edit/{$pageid}" class="btn btn-small">{message name="{$pageslug}-button-edit"}</a></td>{/if}
						{if $allowDelete == "true"}<td><a href="{$cScriptPath}/{$pageslug}/delete/{$pageid}" class="btn btn-small btn-danger">{message name="{$pageslug}-button-delete"}</a></td>{/if}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</p>
{/block}